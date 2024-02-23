<?php

namespace App\Http\Controllers;

use App\Models\Check;
use App\Models\CheckDebit;
use App\Models\ChequeDebitImage;
use App\Traits\PhotoTrait;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CheckDebitController extends Controller
{
    use PhotoTrait;
    public function all_cheques_debit()
    {

        $checks = CheckDebit::with('ChequeDebitImages')->latest()->get();
        return view('checks_debits.all_checks_debit', compact('checks'));
    }

    public function add_cheques_debit()
    {

        // $checks = Check::has('reglementCheque')->doesntHave(['chequeDebit','chequeAnnule'])->with(['checkbook', 'reglementCheque'])->get();
        $checks = Check::has('reglementCheque')
            ->doesntHave('chequeDebit')
            ->doesntHave('chequeAnnule')
            ->with(['checkbook', 'reglementCheque'])
            ->get();
        foreach ($checks as $check) {
            Log::info($check->checkbook->bank);
        }

        return view('checks_debits.add_check_debit', compact('checks'));
    }

    public function store_cheques_debit(Request $request)
    {

        $request->validate([
            'check_id' => 'required|array',
            'check_id.*' => 'exists:checks,id',

        ]);

        //  dd($request->all());

        foreach ($request->input('check_id') as $checkId) {
            $check = Check::find($checkId);
            // $file_name =  $this->uploadFiles($request, 'public/photos/cheques_debit', ChequeDebitImage::class, 'cheque_debit_id');
            $chequeDebit = CheckDebit::create([
                'cheque_sie_debit' => $check->checkbook->cheque_sie,
                'check_id' => $checkId,
                'date_debit' => $request->input('date_debit'),
                'series_debit' => $check->checkbook->series,
                'banque_debit' => $check->checkbook->bank->nom,
                'compte_debit' => $check->reglementCheque->compte->nom,
                'reference_debit' => $check->reglementCheque->referance,
                'service_debit' => $check->reglementCheque->service->nom,
                'beneficiare_debit' => $check->reglementCheque->bene->nom,
                'amount_debit' => $check->reglementCheque->montant,
                'user_id' => auth()->id(),
            ]);

            $this->uploadFiles($request, 'public/photos/cheques_debit', ChequeDebitImage::class, 'cheque_debit_id', $chequeDebit->id);
        }

        return redirect()->route('all.checks-debit')->with('success', 'Chèque Débit ajouté avec succès.');
    }

    public function edit_cheques_debit($id)
    {
        $check_debit = CheckDebit::findOrFail($id);
        $checks = Check::has('reglementCheque')
       ->where(function ($query) use ($check_debit) {
            $query->doesntHave('chequeDebit')
                ->doesntHave('chequeAnnule');
        })
            ->orWhere('id', $check_debit->check_id) 
            ->with(['checkbook', 'reglementCheque'])
            ->get();

    
        foreach ($checks as $check) {
            Log::info(['Check Info' => $check->toArray(), 'Check Debit Info' => $check_debit->toArray()]);
        }

        return view('checks_debits.edit_check_debit', compact('checks', 'check_debit'));
    }

    public function show_cheque_debit ($id){
        
            $checks_debits = CheckDebit::with('ChequeDebitImages')->findOrFail($id);
            return view('checks_debits.show_check_debit', compact('checks_debits'));
        
    }

    public function update_cheque_debit(Request $request, $id)
    {
        $request->validate([
            'check_id' => 'required|array',
            'check_id.*' => 'exists:checks,id',
        ]);

        $check_debit = CheckDebit::findOrFail($id);

        foreach ($request->input('check_id') as $checkId) {
            $check = Check::find($checkId);

            $check_debit->update([
                'cheque_sie_debit' => $check->checkbook->cheque_sie,
                'check_id' => $checkId,
                'date_debit' => $request->input('date_debit'),
                'series_debit' => $check->checkbook->series,
                'banque_debit' => $check->checkbook->bank->nom,
                'compte_debit' => $check->reglementCheque->compte->nom,
                'reference_debit' => $check->reglementCheque->referance,
                'service_debit' => $check->reglementCheque->service->nom,
                'beneficiare_debit' => $check->reglementCheque->bene->nom,
                'amount_debit' => $check->reglementCheque->montant,
            ]);

            $this->handleFileUpload($request, 'public/photos/cheques_debit', ChequeDebitImage::class, 'cheque_debit_id', $check_debit->id);
        }

        return redirect()->route('all.checks-debit')->with('success', 'Chèque Débit mis à jour avec succès.');
    }

    
}
