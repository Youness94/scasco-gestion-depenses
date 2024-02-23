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
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ReglementChequeController extends Controller


{

    public function AllReglementCheques()
    {
        $reglements = ReglementCheque::with(['cheque', 'compte', 'bene', 'service', 'RelChequeImages', 'reglementSiniAuto', 'reglementRdp', 'reglementFournisseur', 'reglementCltRistourne'])->orderBy('created_at', 'desc')->get();
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
            'montant' => 'required|string',
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
        $reglements = ReglementCheque::with(['cheque', 'compte', 'bene', 'service', 'RelChequeImages', 'reglementSiniAuto', 'reglementRdp', 'reglementFournisseur', 'reglementCltRistourne'])->findOrFail($id);
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
            'montant' => 'required|string',
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

            $updateData = [
                'date_reglement' => $request->input('date_reglement'),
                'cheque_id' => $request->input('cheque_id'),
                'compte_id' => $request->input('compte_id'),
                'benefiiaire_id' => $request->input('benefiiaire_id'),
                'service_id' => $request->input('service_id'),
                'referance' => $request->input('referance'),
                'echeance' => $request->input('echeance'),
                'montant' => $request->input('montant'),
            ];
            $reglementCheque->update($updateData);

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
                    $companierId = $request->input('companier_id');
                    $referanceDossierAuto = $request->input('referance_dossier_auto');
                    $referanceQuittanceAuto = $request->input('referance_quittance_auto');

                    // Check if 'companier_id' is not null
                    if ($companierId !== null) {
                        // Check if a record already exists
                        $existingRecord = ReglementSiniAuto::where('companier_id', $companierId)
                            ->where('referance_dossier_auto', $referanceDossierAuto)
                            ->where('referance_quittance_auto', $referanceQuittanceAuto)
                            ->where('reglement_cheque_id', $reglementCheque->id)
                            ->first();

                        if (!$existingRecord) {
                            // Create a new record only if it doesn't exist
                            ReglementSiniAuto::create([
                                'reglement_cheque_id' => $reglementCheque->id,
                                'companier_id' => $companierId,
                                'referance_dossier_auto' => $referanceDossierAuto,
                                'referance_quittance_auto' => $referanceQuittanceAuto,
                            ]);
                        } else {
                            // Record already exists, you can keep the last one (no action needed)
                        }
                    } else {
                        // Handle the case where 'companier_id' is null
                        Log::error("companier_id is null. Cannot create a new record in 'Règlement sinistres automobiles'.");
                    }
                    break;

                case 'Règlement sinistres RDP':
                    $companierIdRDP = $request->input('companier_id');
                    $referanceDossierRDP = $request->input('referance_dossier');
                    $referanceQuittanceRDP = $request->input('referance_quittance');

                    if ($companierIdRDP !== null) {
                        $existingRecordRDP = ReglementSiniRdp::where('companier_id', $companierIdRDP)
                            ->where('referance_dossier', $referanceDossierRDP)
                            ->where('referance_quittance', $referanceQuittanceRDP)
                            ->where('reglement_cheque_id', $reglementCheque->id)
                            ->first();

                        if (!$existingRecordRDP) {
                            ReglementSiniRdp::create([
                                'reglement_cheque_id' => $reglementCheque->id,
                                'companier_id' => $companierIdRDP,
                                'referance_dossier' => $referanceDossierRDP,
                                'referance_quittance' => $referanceQuittanceRDP,
                            ]);
                        } else {
                        }
                    } else {
                        Log::error("companier_id is null. Cannot create a new record in 'Règlement sinistres RDP'.");
                    }
                    break;

                case 'Règlement fournisseurs':
                    $sousCompteId = $request->input('sous_compte_id');

                    if ($sousCompteId !== null) {
                        $existingRecordFournisseurs = ReglementFournisseur::where('sous_compte_id', $sousCompteId)
                            ->where('reglement_cheque_id', $reglementCheque->id)
                            ->first();

                        if (!$existingRecordFournisseurs) {
                            ReglementFournisseur::create([
                                'sous_compte_id' => $sousCompteId,
                                'reglement_cheque_id' => $reglementCheque->id,
                            ]);
                        } else {
                        }
                    } else {
                        Log::error("sous_compte_id is null. Cannot create a new record in 'Règlement fournisseurs'.");
                    }
                    break;

                case 'Règlement clients - Ristournes':
                    $companierIdRistournes = $request->input('companier_id');
                    $referanceDiam = $request->input('referance_diam');
                    $referanceCie = $request->input('referance_cie');
                    if ($companierIdRistournes !== null) {
                        $existingRecordRistournes = ReglementCltRistourn::where('companier_id', $companierIdRistournes)
                            ->where('referance_diam', $referanceDiam)
                            ->where('referance_cie', $referanceCie)
                            ->where('reglement_cheque_id', $reglementCheque->id)
                            ->first();

                        if (!$existingRecordRistournes) {
                            ReglementCltRistourn::create([
                                'reglement_cheque_id' => $reglementCheque->id,
                                'companier_id' => $companierIdRistournes,
                                'referance_diam' => $referanceDiam,
                                'referance_cie' => $referanceCie,
                            ]);
                        } else {
                        }
                    } else {
                        Log::error("companier_id is null. Cannot create a new record in 'Règlement clients - Ristournes'.");
                    }
                    break;

                default:
                    // Remove the record from the respective table if it exists
                    ReglementSiniAuto::where('reglement_cheque_id', $reglementCheque->id)->delete();
                    ReglementSiniRdp::where('reglement_cheque_id', $reglementCheque->id)->delete();
                    ReglementFournisseur::where('reglement_cheque_id', $reglementCheque->id)->delete();
                    ReglementCltRistourn::where('reglement_cheque_id', $reglementCheque->id)->delete();
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
    $reglements = ReglementCheque::with(['cheque', 'compte', 'bene', 'service', 'RelChequeImages', 'reglementSiniAuto', 'reglementRdp', 'reglementFournisseur', 'reglementCltRistourne'])->findOrFail($id);
    $date_reglement = $reglements->date_reglement;


    $images = $reglements->RelChequeImages;
    $imagePaths = [];

    foreach ($images as $image) {
        $imagePaths[] = public_path("public/reglement_cheque_images/{$image->images}");
    }

    $imageDirectory = 'reglement_cheque_images/';

    // Create the directory if it doesn't exist
    if (!file_exists(public_path($imageDirectory))) {
        mkdir(public_path($imageDirectory), 0755, true);
    }

    // Copy images to the specified directory
    foreach ($imagePaths as $imagePath) {
        if (file_exists($imagePath)) {
            $imageName = basename($imagePath);
            $newImagePath = public_path("{$imageDirectory}{$imageName}");
            copy($imagePath, $newImagePath);
        } else {
            Log::error("Image not found at path: {$imagePath}");
        }
    }

    // Define the PDF file name
    $pdfFileName = "reglement_cheque_$date_reglement.pdf";

    // Load PDF view with image links
    $pdf = PDF::loadView('pdf.reglement_cheque_pdf', [
        'title' => $date_reglement,
        'date' => date('m/d/Y'),
        'imagePaths' => $imagePaths,
        'reglements' => $reglements
    ])->setPaper('a4');

    // Save the PDF file within the 'public' directory
    $pdf->save(public_path("pdf/$pdfFileName"));

    // Create a zip archive
    $zipFileName = "reglement_cheque_$date_reglement.zip";
    $zipFilePath = public_path("pdf/$zipFileName");
    $zip = new ZipArchive();
    
    if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
        // Add PDF file to the zip archive
        $zip->addFile(public_path("pdf/$pdfFileName"), $pdfFileName);

        // Add images to the zip archive
        foreach ($imagePaths as $imagePath) {
            if (file_exists($imagePath)) {
                $imageName = basename($imagePath);
                $zip->addFile($imagePath, "{$imageDirectory}{$imageName}");
            } else {
                Log::error("Image not found at path: {$imagePath}");
            }
        }

        // Close the zip archive
        $zip->close();

        // Response with download link
        return response()->download($zipFilePath);
    } else {
        Log::error("Failed to open zip archive");
        return response()->json(['error' => 'Failed to create zip archive'], 500);
    }
}
}
