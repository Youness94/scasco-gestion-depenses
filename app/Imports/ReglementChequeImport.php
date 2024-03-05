<?php

namespace App\Imports;

use App\Models\ReglementCheque;
use Maatwebsite\Excel\Concerns\ToModel;

use App\Models\BeneCompte;
use App\Models\Check;
use App\Models\Compagnie;
use App\Models\CompteDepense;
use App\Models\ReglementChequeImage;
use App\Models\ReglementCltRistourn;
use App\Models\ReglementFournisseur;
use App\Models\ReglementSiniAuto;
use App\Models\ReglementSiniRdp;
use App\Models\Service;
use App\Models\SousCompte;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\WithImages;
use Maatwebsite\Excel\Imports\ProcessesImages;
use Maatwebsite\Excel\Concerns\RegistersImages;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class ReglementChequeImport implements WithHeadingRow, ToModel, WithMapping
{
    private $cheques;
    private $comptes;
    private $benes;
    private $services;
    private $companiers;
    private $sous_comptes;

    private $reglementCheques = [];

    public function __construct()
    {
        $this->cheques = Check::select('id', 'number')->get();
        $this->comptes = CompteDepense::select('id', 'nom')->get();
        $this->benes = BeneCompte::select('id', 'nom')->get();
        $this->services = Service::select('id', 'nom')->get();
        $this->companiers = Compagnie::select('id', 'nom')->get();
        $this->sous_comptes = SousCompte::select('id', 'nom')->get();
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // dd($row);
        $reglementCheque = new ReglementCheque([

            'date_reglement' =>  $row['date_reglement'],
            'cheque_id' => $row['cheque_id'],
            'compte_id' =>  $row['compte_id'],
            'benefiiaire_id' => $row['benefiiaire_id'],
            'service_id' => $row['service_id'],
            'montant' => $row['montant'],
            'echeance' => $row['echeance'],
            'referance' => $row['referance'],
        ]);
        $reglementCheque->save();
        $imagePath = $row['images'];
        dd( $imagePath );
        if ($imagePath !== null) { 
            ReglementChequeImage::create([
                'reglement_cheque_id' => $reglementCheque->id,
                'images' => $imagePath,
            ]);
        }
    


        $compte = CompteDepense::find($row['compte_id']);
// dd($compte->nom);
if ($compte) {
        switch ($compte->nom) {
            case 'Règlement sinistres automobiles':
                $reglementCheque->save(); 
                ReglementSiniAuto::create([
                    'reglement_cheque_id' => $reglementCheque->id,
                    'companier_id' => $row['companier_id'],
                    'referance_dossier_auto' => $row['referance_dossier_auto'],
                    'referance_quittance_auto' => $row['referance_quittance_auto'],
                ]);
                break;
    
            case 'Règlement sinistres RDP':
                $reglementCheque->save();
                ReglementSiniRdp::create([
                    'reglement_cheque_id' => $reglementCheque->id,
                    'companier_id' => $row['companier_id'],
                    'referance_dossier' => $row['referance_dossier'],
                    'referance_quittance' => $row['referance_quittance'],
                ]);
                break;
    
            case 'Règlement fournisseurs':
                $reglementCheque->save();
                ReglementFournisseur::create([
                    'sous_compte_id' => $row['sous_compte_id'],
                    'reglement_cheque_id' => $reglementCheque->id,
                ]);
                break;
    
            case 'Règlement clients - Ristournes':
                $reglementCheque->save();
                ReglementCltRistourn::create([
                    'reglement_cheque_id' => $reglementCheque->id,
                    'companier_id' => $row['companier_id'],
                    'referance_diam' => $row['referance_diam'],
                    'referance_cie' => $row['referance_cie'],
                ]);
                break;
    
            default:
                $reglementCheque->save(); // Save for other cases if needed
                break;
        }
    }
        $reglementCheque->save();

        Log::info('ReglementCheque ID: ' . $reglementCheque->id);
        // dd($reglementCheque->id);
        $this->reglementCheques[] = $reglementCheque;

        return $reglementCheque;
    }
    public function map($row): array
    {
        try {
            // $receptionDate = Carbon::createFromFormat('Y-m-d', $row['reception_date']);
            $reglementDate = $row['date_reglement'];
            $reglementDateConvert = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($reglementDate))->format('Y-m-d');

            $echeanceDate = $row['echeance'];
            $echeanceDateConvert = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($echeanceDate))->format('Y-m-d');
            // $formattedDate = $receptionDate->format('Y-m-d');
            // dd($receptionDate );
        } catch (\Exception $e) {
            dd('Error: ' . $e->getMessage(), 'Date String: ' . $row['reception_date']);
        }



        $cheque = $this->cheques->where('number', $row['cheque_id'])->first();
        $compte = $this->comptes->where('nom', $row['compte_id'])->first();
        $bene = $this->benes->where('nom', $row['benefiiaire_id'])->first();
        $service = $this->services->where('nom', $row['service_id'])->first();
        $companier = $this->companiers->where('nom', $row['companier_id'])->first();
        $sous_compte = $this->sous_comptes->where('nom', $row['sous_compte_id'])->first();

        $user_id = auth()->user() ? auth()->user()->id : null;
        // dd( $row );
        return [
            'date_reglement' =>  $reglementDateConvert ?? null,
            'cheque_id' =>  $cheque ? $cheque->id : null,
            'compte_id' =>  $compte ? $compte->id : null,
            'benefiiaire_id' =>  $bene ? $bene->id : null,
            'service_id' =>  $service ? $service->id : null,
            'montant' => $row['montant'],
            'echeance' => $echeanceDateConvert ?? null,
            'referance' => $row['referance'],

            'referance_diam' => $row['referance_diam'],
            'referance_cie' => $row['referance_cie'],
            'referance_dossier' => $row['referance_dossier'],
            'referance_quittance' => $row['referance_quittance'],
            'sous_compte_id' => $sous_compte ? $sous_compte->id : null,
            'referance_dossier_auto' => $row['referance_dossier_auto'],
            'referance_quittance_auto' => $row['referance_quittance_auto'],
            'companier_id' => $companier ? $companier->id : null,
          
            'images' => $row['images'], 


        ];
    }
    
}
