<?php

namespace App\Http\Controllers\Effet;

use App\Http\Controllers\Controller;
use App\Models\BeneCompte;
use App\Models\Compagnie;
use App\Models\Effet;
use App\Models\EffetCompte;
use App\Models\ReglementEffet;
use App\Models\ReglementEffetFournisseur;
use App\Models\ReglementEffetImage;
use App\Models\Service;
use App\Models\SousCompte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class ReglementEffetController extends Controller
{
    public function AllReglementEffets()
    {
        $reglements = ReglementEffet::with(['effet', 'effet_compte', 'bene', 'service', 'RelEffetImages'])->orderBy('created_at', 'desc')->get();
        return view('reglement_effets.list-reglement-effets', compact('reglements'));
    }

    public function AddReglementEffet()
    {

        // $effets = Effet::all();
        $effets = Effet::doesntHave('reglementEffet')
            // ->doesntHave('effetDebit')
            // ->doesntHave('effetAnnule')
            ->get();
        $services = Service::all();
        $benefiiaires = BeneCompte::all();
        $effet_comptes = EffetCompte::all();
        $compagnies = Compagnie::all();
        $sous_comptes = SousCompte::all();
        $reglement_effets = ReglementEffet::latest()->get();
        $compteNom = '';

        // Log::info([
        //     'effets'. $effets,
        //     'services'. $services,
        //     'benefiiaires'. $benefiiaires,
        //     'effet_comptes'. $effet_comptes,
        //     'compagnies'. $compagnies,
        //     'sous_comptes'. $sous_comptes,
        //     'reglement_effets'. $reglement_effets,
        // ]);

        return view('reglement_effets.add-reglement-effet', compact('reglement_effets', 'benefiiaires', 'services', 'effets', 'effet_comptes', 'compagnies', 'sous_comptes', 'compteNom'));
    }



    public function StoreReglementEffet(Request $request)
    {

        // dd($request->all());
        Log::info('Attempting to store Reglement Effet', $request->all());

        $request->validate([
            'date_reglement' => 'required|date',
            'effet_compte_id' => 'required|exists:effet_comptes,id',
            'benefiiaire_id' => 'required|exists:bene_comptes,id',
            'service_id' => 'required|exists:services,id',
            'referance' => 'required|string',
            'echeance' => 'required|date',
            'montant' => 'required|integer',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'effet_id' => [
                'required',
                'exists:effets,id',
                'unique:reglement_effets,effet_id,NULL,id,effet_id,' . $request->input('effet_id'),
            ],


        ]);
        DB::beginTransaction();
        try {


            $reglementEffet = ReglementEffet::create([
                'date_reglement' => $request->input('date_reglement'),
                'cheque_id' => $request->input('cheque_id'),
                'effet_compte_id' => $request->input('effet_compte_id'),
                'benefiiaire_id' => $request->input('benefiiaire_id'),
                'service_id' => $request->input('service_id'),
                'referance' => $request->input('referance'),
                'echeance' => $request->input('echeance'),
                'montant' => $request->input('montant'),
            ]);

            $uploadPath = 'public/reglement_effet_images/';


            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    Log::info('Processing image:', [
                        'file_name' => $image->getClientOriginalName(),
                        'file_size' => $image->getSize(),
                    ]);
                    // $extension = $image->getClientOriginalExtension();
                    // $fileName = time() . '_' . uniqid() . '.' . $extension;
                    // $image->move($uploadPath, $fileName);
                    $extension = $image->getClientOriginalExtension();
                    $fileName = time() . '_' . uniqid() . '.' . $extension;
                    $image->move($uploadPath, $fileName);


                    ReglementEffetImage::create([
                        'reglement_effet_id' => $reglementEffet->id,
                        'images' => $fileName,
                    ]);
                }
            }



            $compteId = $request->input('effet_compte_id');

            $effet_compte = EffetCompte::find($compteId);

            $compteNom = trim($effet_compte->nom);


            switch ($compteNom) {
                case 'Règlement fournisseurs':
                    ReglementEffetFournisseur::create([
                        'sous_compte_id' => $request->input('sous_compte_id'),
                        'reglement_effet_id' => $reglementEffet->id,
                    ]);
                    break;
                default:

                    break;
            }



            DB::commit();
            Log::info('Transaction committed successfully');
            return redirect()->route('all.reglement-effets')->with('success', "Régelement a été créée avec succès");
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error');
        }
    }




    public function ShowReglementEffet($id)
    {
        $reglements = ReglementEffet::with(['effet', 'effet_compte', 'bene', 'service', 'RelChequeEffetImages'])->findOrFail($id);
        return view('reglement_effets.show-reglement-effet', compact('reglements'));
    }
    public function EditReglementEffet($id)
    {
        // $checks = Check::doesntHave('reglementCheque')->get();
        $effets = Effet::whereDoesntHave('reglementEffet', function ($query) use ($id) {
            $query->where('id', '!=', $id);
        })->get();
        $services = Service::all();
        $benefiiaires = BeneCompte::all();
        $effet_comptes = EffetCompte::all();
        $compagnies = Compagnie::all();
        $sous_comptes = SousCompte::all();
        $reglement_cheques = ReglementEffet::findOrFail($id);

        return view('reglement_effets.edit-reglement-effet', compact('reglement_cheques', 'benefiiaires', 'services', 'checks', 'effet_comptes', 'compagnies', 'sous_comptes'));
    }

    public function UpdateReglementEffet(Request $request, $id)
    {
        $request->validate([
            'date_reglement' => 'required|date',
            'effet_compte_id' => 'required|exists:effet_comptes,id',
            'benefiiaire_id' => 'required|exists:bene_comptes,id',
            'service_id' => 'required|exists:services,id',
            'referance' => 'required|string',
            'echeance' => 'required|date',
            'montant' => 'required|integer',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'effet_id' => [
                'nullable',
                'exists:effets,id',
            ],
        ]);
        Log::info('ID being ignored in unique check: ' . $id);

        DB::beginTransaction();

        try {
            // Find the existing ReglementCheque record
            $reglementEffet = ReglementEffet::findOrFail($id);


            $reglementEffet->update([
                'date_reglement' => $request->input('date_reglement'),
                'cheque_id' => $request->input('cheque_id'),
                'effet_compte_id' => $request->input('effet_compte_id'),
                'benefiiaire_id' => $request->input('benefiiaire_id'),
                'service_id' => $request->input('service_id'),
                'referance' => $request->input('referance'),
                'echeance' => $request->input('echeance'),
                'montant' => $request->input('montant'),
            ]);
            Log::info('Cheque ID being updated: ' . $request->input('effet_id'));
            // Log::info('Before deleting existing images');
            if ($request->hasFile('images') && count($request->file('images')) > 0) {
                $reglementEffet->RelChequeEffetImages()->delete();
            }
            // Log::info('After deleting existing images');

            // Log::info('Before uploading new images');

            $uploadPath = 'public/reglement_effet_images/';
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $extension = $image->getClientOriginalExtension();
                    $fileName = time() . '_' . uniqid() . '.' . $extension;
                    $image->move($uploadPath, $fileName);

                    ReglementEffetImage::create([
                        'reglement_effet_id' => $reglementEffet->id,
                        'images' => $fileName,
                    ]);
                }
            }
            // Log::info('After uploading new images');



            $compteId = $request->input('compte_id');

            $effet_compte = EffetCompte::find($compteId);

            $compteNom = trim($effet_compte->nom);


            switch ($compteNom) {

                case 'Règlement fournisseurs':
                    ReglementEffetFournisseur::create([
                        'sous_compte_id' => $request->input('sous_compte_id'),
                        'reglement_effet_id' => $reglementEffet->id,
                    ]);
                    break;
                default:

                    break;
            }

            DB::commit();

            return redirect()->route('all.reglement-effets')->with('success', "Régelement a été mis à jour avec succès");
        } catch (\Exception $ex) {
            Log::error('Error deleting existing images: ' . $ex->getMessage());
            DB::rollBack();
            // Log::info('dazetch');
            return redirect()->back()->with('error', 'Error');
        }
    }
    public function generateReglementEffetPDF($id)
    {
        $reglements = ReglementEffet::with(['effet', 'effet_compte', 'bene', 'service', 'RelChequeEffetImages'])->findOrFail($id);
        $date_reglement = $reglements->date_reglement;
        $cheque = $reglements->cheque->number;
        $compte = $reglements->effet_compte->nom;
        $bene = $reglements->bene->nom;
        $service = $reglements->service->nom;
        $referance = $reglements->referance;
        $echeance =   $reglements->echeance;
        $montant =    $reglements->montant;

        $data = [
            'title' => $date_reglement,
            'date' => date('m/d/Y'),
            // 'date_reglement' =>  $date_reglement,
            // 'cheque' => $cheque ,
            // 'compte' => $compte,
            // 'bene' => $bene,
            // 'service' => $service,
            // 'referance' => $referance,
            // 'echeance' => $echeance,
            // 'montant' => $montant,
            'reglements' => $reglements
        ];

        $pdf = PDF::loadView('pdf.reglement_effet_pdf', $data);
        return $pdf->download("reglement_effet_$date_reglement.pdf");
    }
}
