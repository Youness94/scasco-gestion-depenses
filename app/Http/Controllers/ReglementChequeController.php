<?php

namespace App\Http\Controllers;

use App\Models\BeneCompte;
use App\Models\Check;
use App\Models\Compagnie;
use App\Models\CompteDepense;
use App\Models\ReglementCheque;
use App\Models\ReglementChequeImage;
use App\Models\ReglementCltRistourn;
use App\Models\ReglementFournisseur;
use App\Models\ReglementSiniAuto;
use App\Models\ReglementSiniRdp;
use App\Models\Service;
use App\Models\SousCompte;
// use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Rules\UniqueChequeId;
use Barryvdh\DomPDF\Facade\Pdf;



class ReglementChequeController extends Controller


{

    public function AllReglementCheques()
    {
        $reglements = ReglementCheque::with(['cheque', 'compte', 'bene', 'service', 'RelChequeImages'])->orderBy('created_at', 'desc')->get();
        return view('reglement_cheques.list-reglement-cheque', compact('reglements'));
    }

    public function AddReglementCheque()
    {

        // $checks = Check::all();
        $checks = Check::doesntHave('reglementCheque')
            ->doesntHave('chequeDebit')
            ->doesntHave('chequeAnnule')
            ->get();
        $services = Service::all();
        $benefiiaires = BeneCompte::all();
        $comptes = CompteDepense::all();
        $compagnies = Compagnie::all();
        $sous_comptes = SousCompte::all();
        $reglement_cheques = ReglementCheque::latest()->get();
        $compteNom = '';

        return view('reglement_cheques.add-reglement-cheque', compact('reglement_cheques', 'benefiiaires', 'services', 'checks', 'comptes', 'compagnies', 'sous_comptes', 'compteNom'));
    }

    // this function to handle the AJAX request:
    // public function checkIfChequeSelected(Request $request)
    // {
    //     $chequeId = $request->input('cheque_id');

    //     \Log::info('Check if Cheque Selected method called');
    //     $selected = ReglementCheque::where('cheque_id', $chequeId)->exists();

    //     return response()->json(['selected' => $selected]);
    // }
    // end function

    public function StoreReglementCheque(Request $request)
    {

        $request->validate([
            'date_reglement' => 'required|date',
            // 'cheque_id' => 'required|exists:checks,id',
            'compte_id' => 'required|exists:compte_depenses,id',
            'benefiiaire_id' => 'required|exists:bene_comptes,id',
            'service_id' => 'required|exists:services,id',
            'referance' => 'required|string',
            'echeance' => 'required|date',
            'montant' => 'required|integer',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cheque_id' => [
                'required',
                'exists:checks,id',
                'unique:reglement_cheques,cheque_id,NULL,id,cheque_id,' . $request->input('cheque_id'),
            ],


        ]);
        DB::beginTransaction();
        try {


            $reglementCheque = ReglementCheque::create([
                'date_reglement' => $request->input('date_reglement'),
                'cheque_id' => $request->input('cheque_id'),
                'compte_id' => $request->input('compte_id'),
                'benefiiaire_id' => $request->input('benefiiaire_id'),
                'service_id' => $request->input('service_id'),
                'referance' => $request->input('referance'),
                'echeance' => $request->input('echeance'),
                'montant' => $request->input('montant'),
            ]);

            $uploadPath = 'public/reglement_cheque_images/';


            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $extension = $image->getClientOriginalExtension();
                    $fileName = time() . '_' . uniqid() . '.' . $extension;
                    $image->move($uploadPath, $fileName);


                    ReglementChequeImage::create([
                        'reglement_cheque_id' => $reglementCheque->id,
                        'images' => $fileName,
                    ]);
                }
            }



            $compteId = $request->input('compte_id');

            $compte = CompteDepense::find($compteId);

            $compteNom = trim($compte->nom);


            switch ($compteNom) {

                case 'Règlement sinistres automobiles':

                    ReglementSiniAuto::create([
                        'reglement_cheque_id' => $reglementCheque->id,
                        'companier_id' => $request->input('companier_id'),
                        'referance_dossier_auto' => $request->input('referance_dossier_auto'),
                        'referance_quittance_auto' => $request->input('referance_quittance_auto'),
                    ]);
                    break;

                case 'Règlement sinistres RDP':
                    ReglementSiniRdp::create([
                        'reglement_cheque_id' => $reglementCheque->id,
                        'companier_id' => $request->input('companier_id'),
                        'referance_dossier' => $request->input('referance_dossier'),
                        'referance_quittance' => $request->input('referance_quittance'),
                    ]);
                    break;
                case 'Règlement fournisseurs':
                    ReglementFournisseur::create([
                        'sous_compte_id' => $request->input('sous_compte_id'),
                        'reglement_cheque_id' => $reglementCheque->id,
                    ]);
                    break;
                case 'Règlement clients - Ristournes':
                    ReglementCltRistourn::create([
                        'reglement_cheque_id' => $reglementCheque->id,
                        'companier_id' => $request->input('companier_id'),
                        'referance_diam' => $request->input('referance_diam'),
                        'referance_cie' => $request->input('referance_cie'),
                    ]);
                    break;
                default:

                    break;
            }



            DB::commit();
            return redirect()->route('all.reglement-cheques')->with('success', "Régelement a été créée avec succès");
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error');
        }
    }




    public function ShowReglementCheque($id)
    {
        $reglements = ReglementCheque::with(['cheque', 'compte', 'bene', 'service', 'RelChequeImages'])->findOrFail($id);
        return view('reglement_cheques.show-reglement-cheque', compact('reglements'));
    }
    public function EditReglementCheque($id)
    {
        // $checks = Check::doesntHave('reglementCheque')->get();
        $checks = Check::whereDoesntHave('reglementCheque', function ($query) use ($id) {
            $query->where('id', '!=', $id);
        })->get();
        $services = Service::all();
        $benefiiaires = BeneCompte::all();
        $comptes = CompteDepense::all();
        $compagnies = Compagnie::all();
        $sous_comptes = SousCompte::all();
        $reglement_cheques = ReglementCheque::findOrFail($id);

        return view('reglement_cheques.edit-reglement-cheque', compact('reglement_cheques', 'benefiiaires', 'services', 'checks', 'comptes', 'compagnies', 'sous_comptes'));
    }

    public function UpdateReglementCheque(Request $request, $id)
    {
        $request->validate([
            'date_reglement' => 'required|date',
            'compte_id' => 'required|exists:compte_depenses,id',
            'benefiiaire_id' => 'required|exists:bene_comptes,id',
            'service_id' => 'required|exists:services,id',
            'referance' => 'required|string',
            'echeance' => 'required|date',
            'montant' => 'required|integer',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cheque_id' => [
                'nullable',
                'exists:checks,id',
            ],
        ]);
        Log::info('ID being ignored in unique check: ' . $id);

        DB::beginTransaction();

        try {
            // Find the existing ReglementCheque record
            $reglementCheque = ReglementCheque::findOrFail($id);


            $reglementCheque->update([
                'date_reglement' => $request->input('date_reglement'),
                'cheque_id' => $request->input('cheque_id'),
                'compte_id' => $request->input('compte_id'),
                'benefiiaire_id' => $request->input('benefiiaire_id'),
                'service_id' => $request->input('service_id'),
                'referance' => $request->input('referance'),
                'echeance' => $request->input('echeance'),
                'montant' => $request->input('montant'),
            ]);
            Log::info('Cheque ID being updated: ' . $request->input('cheque_id'));
            // Log::info('Before deleting existing images');
            if ($request->hasFile('images') && count($request->file('images')) > 0) {
                $reglementCheque->RelChequeImages()->delete();
            }
            // Log::info('After deleting existing images');

            // Log::info('Before uploading new images');

            $uploadPath = 'public/reglement_cheque_images/';
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $extension = $image->getClientOriginalExtension();
                    $fileName = time() . '_' . uniqid() . '.' . $extension;
                    $image->move($uploadPath, $fileName);

                    ReglementChequeImage::create([
                        'reglement_cheque_id' => $reglementCheque->id,
                        'images' => $fileName,
                    ]);
                }
            }
            // Log::info('After uploading new images');



            $compteId = $request->input('compte_id');

            $compte = CompteDepense::find($compteId);

            $compteNom = trim($compte->nom);


            switch ($compteNom) {

                case 'Règlement sinistres automobiles':

                    ReglementSiniAuto::create([
                        'reglement_cheque_id' => $reglementCheque->id,
                        'companier_id' => $request->input('companier_id'),
                        'referance_dossier_auto' => $request->input('referance_dossier_auto'),
                        'referance_quittance_auto' => $request->input('referance_quittance_auto'),
                    ]);
                    break;

                case 'Règlement sinistres RDP':
                    ReglementSiniRdp::create([
                        'reglement_cheque_id' => $reglementCheque->id,
                        'companier_id' => $request->input('companier_id'),
                        'referance_dossier' => $request->input('referance_dossier'),
                        'referance_quittance' => $request->input('referance_quittance'),
                    ]);
                    break;
                case 'Règlement fournisseurs':
                    ReglementFournisseur::create([
                        'sous_compte_id' => $request->input('sous_compte_id'),
                        'reglement_cheque_id' => $reglementCheque->id,
                    ]);
                    break;
                case 'Règlement clients - Ristournes':
                    ReglementCltRistourn::create([
                        'reglement_cheque_id' => $reglementCheque->id,
                        'companier_id' => $request->input('companier_id'),
                        'referance_diam' => $request->input('referance_diam'),
                        'referance_cie' => $request->input('referance_cie'),
                    ]);
                    break;
                default:

                    break;
            }

            DB::commit();

            return redirect()->route('all.reglement-cheques')->with('success', "Régelement a été mis à jour avec succès");
        } catch (\Exception $ex) {
            Log::error('Error deleting existing images: ' . $ex->getMessage());
            DB::rollBack();
            // Log::info('dazetch');
            return redirect()->back()->with('error', 'Error');
        }
    }
    public function generateReglementChequePDF($id)
    {
        $reglements = ReglementCheque::with(['cheque', 'compte', 'bene', 'service', 'RelChequeImages'])->findOrFail($id);
        $date_reglement = $reglements->date_reglement;
        $cheque = $reglements->cheque->number;
        $compte = $reglements->compte->nom;
        $bene = $reglements->bene->nom;
        $service = $reglements->service->nom;
        $referance = $reglements->referance;
        $echeance =   $reglements->echeance;
        $montant =    $reglements->montant;

        $data = [
            'title'=> $date_reglement,
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

        $pdf = PDF::loadView('pdf.reglement_cheque_pdf', $data);
        return $pdf->download("reglement_cheque_.pdf");
    }
}
