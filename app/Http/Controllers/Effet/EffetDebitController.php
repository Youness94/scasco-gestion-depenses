<?php

namespace App\Http\Controllers\Effet;

use App\Http\Controllers\Controller;
use App\Models\Effet;
use App\Models\EffetDebit;
use App\Models\EffetDebitImage;
use Illuminate\Http\Request;
use App\Traits\PhotoTrait;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class EffetDebitController extends Controller
{
    use PhotoTrait;
    public function all_effets_debit()
    {

        $effets = EffetDebit::with('EffetDebitImages')->latest()->get();
        return view('effets_debits.all_effets_debit', compact('effets'));
    }

    public function add_effets_debit()
{
    $effets = Effet::has('reglementEffet')
        ->doesntHave('effetDebit')
        ->doesntHave('effetAnnule')
        ->with('carnet_effet', 'reglementEffet')
        ->get();

    Log::info('Effets count before condition: ' . Effet::has('reglementEffet')->count());
    Log::info('Effets effetAnnule : ' . Effet::doesntHave('effetAnnule')->count());
    Log::info('Effets effetDebit: ' . Effet::doesntHave('effetDebit')->count());
    Log::info('Effets : ' . $effets);

    return view('effets_debits.add_effet_debit', compact('effets'));
}

    public function store_effets_debit(Request $request)
    {

        $request->validate([
            'effet_id' => 'required|array',
            'effet_id.*' => 'exists:effets,id',

        ]);

        //  dd($request->all());

        foreach ($request->input('effet_id') as $effetId) {
            $effet = Effet::find($effetId);
            // $file_name =  $this->uploadFiles($request, 'public/photos/cheques_debit', ChequeDebitImage::class, 'cheque_debit_id');
            $effetDebit = EffetDebit::create([
                'effet_sie_debit' => $effet->carnet_effet->effet_sie,
                'effet_id' => $effetId,
                // 'check_id' => $check->number,
                'effet_series_debit' => $effet->carnet_effet->carnet_series,
                'effet_banque_debit' => $effet->carnet_effet->bank->nom,
                'effet_compte_debit' => $effet->reglementEffet->effet_compte->nom,
                'effet_reference_debit' => $effet->reglementEffet->referance,
                'effet_service_debit' => $effet->reglementEffet->service->nom,
                'effet_beneficiare_debit' => $effet->reglementEffet->bene->nom,
                'effet_amount_debit' => $effet->reglementEffet->montant,
                'user_id' => auth()->id(),
            ]);

            $this->uploadFiles($request, 'public/photos/effets_debit', EffetDebitImage::class, 'effet_debit_id', $effetDebit->id);
        }

        return redirect()->route('all.effets-debit')->with('success', 'Effet Débit ajouté avec succès.');
    }

    public function edit_effets_debit($id)
    {
        $effet_debit = EffetDebit::findOrFail($id);
        $effets = Effet::has('reglementEffet')
            ->where(function ($query) use ($effet_debit) {
                $query->doesntHave('effetDebit')
                    ->doesntHave('effetAnnule');
            })
            ->orWhere('id', $effet_debit->check_id)
            ->with(['carnet_effet', 'reglementEffet'])
            ->get();


        foreach ($effets as $effet) {
            Log::info(['Check Info' => $effet->toArray(), 'effet Debit Info' => $effet_debit->toArray()]);
        }

        return view('effets_debits.edit_effet_debit', compact('effets', 'effet_debit'));
    }

    public function show_effet_debit($id)
    {

        $effets_debits = EffetDebit::with('EffetDebitImages')->findOrFail($id);
        return view('effets_debits.show_effet_debit', compact('effets_debits'));
    }

    public function update_effet_debit(Request $request, $id)
    {
        $request->validate([
            'effet_id' => 'required|array',
            'effet_id.*' => 'exists:effets,id',
        ]);

        $effet_debit = EffetDebit::findOrFail($id);

        foreach ($request->input('check_id') as $effetId) {
            $effet = Effet::find($effetId);

            $effet_debit->update([
                'effet_sie_debit' => $effet->carnet_effet->effet_sie,
                'effet_id' => $effetId,
                'series_debit' => $effet->carnet_effet->carnet_series,
                'banque_debit' => $effet->carnet_effet->bank->nom,
                'compte_debit' => $effet->reglementEffet->effet_compte->nom,
                'reference_debit' => $effet->reglementEffet->referance,
                'service_debit' => $effet->reglementEffet->service->nom,
                'beneficiare_debit' => $effet->reglementEffet->bene->nom,
                'amount_debit' => $effet->reglementEffet->montant,
            ]);

            $this->handleFileUpload($request, 'public/photos/effets_debit', EffetDebitImage::class, 'effet_debit_id', $effet_debit->id);
        }

        return redirect()->route('all.effets-debit')->with('success', 'Chèque Débit mis à jour avec succès.');
    }
}
