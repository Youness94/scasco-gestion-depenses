<?php

namespace App\Http\Controllers\Effet;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BeneCompte;
use App\Models\Effet;
use App\Models\EffetAnnule;
use App\Models\EffetAnnuleImage;
use App\Models\EffetCompte;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Traits\PhotoTrait;
use Illuminate\Support\Facades\Log;

class EffetAnnuleController extends Controller
{
    use PhotoTrait;

    public function all_effets_annule()
    {

        $effets = EffetAnnule::with('carnet_effet','service','benef','compte','reglementEffet')->get();
        return view('effets_annules.all_effets_cancelled', compact('effets'));
    }

    public function addEffetAnnule()
    {

        // $checks = Check::has('reglementCheque')->with(['checkbook', 'reglementCheque'])->get();
        $effets_annules = Effet::doesntHave('effetAnnule')
            ->doesntHave('effetDebit')
            ->with('carnet_effet')
            ->get();
        $services = Service::all();
        $effet_comptes = EffetCompte::all();
        $beneficiares = BeneCompte::all();
        $banks = Bank::all();

        foreach ($effets_annules as $effet) {
            Log::info([
                'effets_number' => $effet->effet_number,
                'effets_annules' => $effet->carnet_effet->effet_serie,
            ]);
        }
        foreach ($services as $service) {
            Log::info(['services' => $service->nom,]);
        }
        foreach ($effet_comptes as $effet_compte) {
            Log::info(['effet_compte' => $effet_compte->nom,]);
        }
        foreach ($beneficiares as $beneficiare) {
            Log::info(['beneficiares' => $beneficiare->nom,]);
        }
        foreach ($banks as $bank) {
            Log::info(['banks' => $bank->nom,]);
        }

        return view('effets_annules.add_effet_cancelled', compact('effets_annules', 'services', 'effet_comptes', 'beneficiares', 'banks'));
    }

    public function store_effets_annule(Request $request)
    {

        $request->validate([
            'effet_id' => 'required|array',
            'effet_id.*' => 'exists:checks,id',
        ]);
        // dd($request->all());
        foreach ($request->input('effet_id') as $effetId) {
            $effet = Effet::find($effetId);

            $effet_annule =  EffetAnnule::create([
                'effet_id' => $effetId,
                'effet_compte_id' => $request->input('effet_compte_id'),
                'benefiiaire_id' => $request->input('benefiiaire_id'),
                'service_id' => $request->input('service_id'),
                'montant_annule' => $request->input('montant_annule'),
                'bank_effet_annule' => $effet->carnet_effet->bank->nom,
                'series_effet_annule' => $effet->carnet_effet->carnet_series,
                'effet_sie_annule' => $effet->carnet_effet->effet_sie,
                'refe_effet_annule' => $request->input('refe_effet_annule'),
                'retour_effet_annule' => $request->input('retour_effet_annule'),
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
            $this->uploadFiles($request, 'public/photos/effets_annule', EffetAnnuleImage::class, 'effet_annule_id', $effet_annule->id);

        }

        return redirect()->route('all.effets-cancelled')->with('success', 'Effet annulés ajoutés avec succès.');
    }


    public function edit_effets_annule($id)
    {
        $effet_annules = EffetAnnule::findOrFail($id);

        $effets = Effet::where(function ($query) use ($effet_annules) {
            $query->doesntHave('effetAnnule')
            // ->doesntHave('effetDebit')
            ;
                
        })
            ->orWhere('id', $effet_annules->effet_id) 
            ->with('carnet_effet')
            ->get();

        $services = Service::all();
        $effet_comptes = EffetCompte::all();
        $beneficiares = BeneCompte::all();
        $banks = Bank::all();

        return view('effets_annules.edit_effet_cancelled', compact('effet_annules', 'services', 'effet_comptes', 'beneficiares', 'banks', 'effets'));
    }

    public function update_effets_annule(Request $request, $id)
    {
        $request->validate([
            'effet_id' => 'required|array',
            'effet_id.*' => 'exists:checks,id',
        ]);

        $effet_annule = EffetAnnule::findOrFail($id);

        foreach ($request->input('effet_id') as $effetId) {
            $effet = Effet::find($effetId);

            $effet_annule =  EffetAnnule::create([
                'effet_id' => $effetId,
                'effet_compte_id' => $request->input('effet_compte_id'),
                'benefiiaire_id' => $request->input('benefiiaire_id'),
                'service_id' => $request->input('service_id'),
                'montant_annule' => $request->input('montant_annule'),
                'bank_effet_annule' => $effet->carnet_effet->bank->nom,
                'series_effet_annule' => $effet->carnet_effet->carnet_series,
                'effet_sie_annule' => $effet->carnet_effet->effet_sie,
                'refe_effet_annule' => $request->input('refe_effet_annule'),
                'retour_effet_annule' => $request->input('retour_effet_annule'),
                'user_id' => auth()->id(),
            ]);

            $this->handleFileUpload($request, 'public/photos/effets_annule', EffetAnnuleImage::class, 'effet_annule_id', $effet_annule->id);
        }

        return redirect()->route('all.effets-cancelled')->with('success', 'Effet annule mis à jour avec succès.');
    }
}
