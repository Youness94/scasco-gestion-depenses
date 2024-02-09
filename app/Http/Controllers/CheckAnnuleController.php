<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BeneCompte;
use App\Models\Check;
use App\Models\CheckAnnule;
use App\Models\ChequeAnnuleImage;
use App\Models\CompteDepense;
use App\Models\Service;
use App\Traits\PhotoTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckAnnuleController extends Controller
{
    use PhotoTrait;

    public function all_cheques_annule()
    {

        $checks = CheckAnnule::all();
        return view('checks_annules.all_checks_cancelled', compact('checks'));
    }

    public function add_cheques_annule()
    {

        // $checks = Check::has('reglementCheque')->with(['checkbook', 'reglementCheque'])->get();
        $checks_annules = Check::doesntHave('chequeDebit')
            ->doesntHave('chequeAnnule')
            ->with('checkbook')
            ->get();
        $services = Service::all();
        $comptes = CompteDepense::all();
        $beneficiares = BeneCompte::all();
        $banks = Bank::all();

        foreach ($checks_annules as $check) {
            Log::info([
                'checks_number' => $check->number,
                'checks_annules' => $check->checkbook->serie,
            ]);
        }
        foreach ($services as $service) {
            Log::info(['services' => $service->nom,]);
        }
        foreach ($comptes as $compte) {
            Log::info(['comptes' => $compte->nom,]);
        }
        foreach ($beneficiares as $beneficiare) {
            Log::info(['beneficiares' => $beneficiare->nom,]);
        }
        foreach ($banks as $bank) {
            Log::info(['banks' => $bank->nom,]);
        }

        return view('checks_annules.add_check_cancelled', compact('checks_annules', 'services', 'comptes', 'beneficiares', 'banks'));
    }

    public function store_cheques_annule(Request $request)
    {

        $request->validate([
            'check_id' => 'required|array',
            'check_id.*' => 'exists:checks,id',
        ]);
        // dd($request->all());
        foreach ($request->input('check_id') as $checkId) {
            $check = Check::find($checkId);

            $cheque_annule =  CheckAnnule::create([
                'check_id' => $checkId,
                'compte_id' => $request->input('compte_id'),
                'benefiiaire_id' => $request->input('benefiiaire_id'),
                'service_id' => $request->input('service_id'),
                'montant_annule' => $request->input('montant_annule'),
                'bank_check_annule' => $check->checkbook->bank->nom,
                'series_checkbook_annule' => $check->checkbook->series,
                'cheque_sie_annule' => $check->checkbook->cheque_sie,
                'refe_check_annule' => $request->input('refe_check_annule'),
                'retour_check_annule' => $request->input('retour_check_annule'),
                'user_id' => auth()->id(),
            ]);

            // $uploadPath = 'public/photos/cheques_annule/';


            // if ($request->hasFile('images')) {
            //     foreach ($request->file('images') as $image) {
            //         $extension = $image->getClientOriginalExtension();
            //         $fileName = time() . '_' . uniqid() . '.' . $extension;
            //         $image->move($uploadPath, $fileName);


            //         ChequeAnnuleImage::create([
            //             'check_annule_id' => $cheque_annule->id,
            //             'images' => $fileName,
            //         ]);
            //     }
            // }
            $this->uploadFiles($request, 'public/photos/cheques_annule', ChequeAnnuleImage::class, 'check_annule_id', $cheque_annule->id);

        }

        return redirect()->route('all.checks-cancelled')->with('success', 'Chèques annulés ajoutés avec succès.');
    }


    public function edit_cheques_annule($id)
    {
        $check_annules = CheckAnnule::findOrFail($id);

        $checks = Check::where(function ($query) use ($check_annules) {
            $query->doesntHave('chequeDebit')
                ->doesntHave('chequeAnnule');
        })
            ->orWhere('id', $check_annules->check_id) 
            ->with('checkbook')
            ->get();

        $services = Service::all();
        $comptes = CompteDepense::all();
        $beneficiares = BeneCompte::all();
        $banks = Bank::all();

        return view('checks_annules.edit_check_cancelled', compact('check_annules', 'services', 'comptes', 'beneficiares', 'banks', 'checks'));
    }

    public function update_cheques_annule(Request $request, $id)
    {
        $request->validate([
            'check_id' => 'required|array',
            'check_id.*' => 'exists:checks,id',
        ]);

        $check_debit = CheckAnnule::findOrFail($id);

        foreach ($request->input('check_id') as $checkId) {
            $check = Check::find($checkId);

            $cheque_annule =  CheckAnnule::create([
                'check_id' => $checkId,
                'compte_id' => $request->input('compte_id'),
                'benefiiaire_id' => $request->input('benefiiaire_id'),
                'service_id' => $request->input('service_id'),
                'montant_annule' => $request->input('montant_annule'),
                'bank_check_annule' => $check->checkbook->bank->nom,
                'series_checkbook_annule' => $check->checkbook->series,
                'cheque_sie_annule' => $check->checkbook->cheque_sie,
                'refe_check_annule' => $request->input('refe_check_annule'),
                'retour_check_annule' => $request->input('retour_check_annule'),
                'user_id' => auth()->id(),
            ]);

            $this->handleFileUpload($request, 'public/photos/cheques_annule', ChequeAnnuleImage::class, 'check_annule_id', $cheque_annule->id);
        }

        return redirect()->route('all.checks-cancelled')->with('success', 'Chèque Débit mis à jour avec succès.');
    }
}
