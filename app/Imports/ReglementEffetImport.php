<?php

namespace App\Imports;

use App\Models\BeneCompte;
use App\Models\Compagnie;
use App\Models\Effet;
use App\Models\EffetCompte;
use App\Models\ReglementEffet;
use App\Models\ReglementEffetFournisseur;
use App\Models\ReglementEffetImage;
use App\Models\Service;
use App\Models\SousCompte;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReglementEffetImport implements WithHeadingRow, ToModel, WithMapping
{
    private $effets;
    private $effet_comptes;
    private $benes;
    private $services;
    private $companiers;
    private $sous_comptes;

    private $reglementEffets = [];

    public function __construct()
    {
        $this->effets = Effet::select('id', 'effet_number')->get();
        $this->effet_comptes = EffetCompte::select('id', 'nom')->get();
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
        $reglementEffet = new ReglementEffet([
            'date_reglement' =>  $row['date_reglement'],
            'effet_id' => $row['effet_id'],
            'effet_compte_id' =>  $row['effet_compte_id'],
            'benefiiaire_id' => $row['benefiiaire_id'],
            'service_id' => $row['service_id'],
            'montant' => $row['montant'],
            'echeance' => $row['echeance'],
            'referance' => $row['referance'],
        ]);
        $reglementEffet->save();
        $imagePath = $row['images'];
        // dd($imagePath);
        if ($imagePath !== null) {
            ReglementEffetImage::create([
                'reglement_effet_id' => $reglementEffet->id,
                'images' => $imagePath,
            ]);
        }
        $compte = EffetCompte::find($row['effet_compte_id']);
        // dd($compte->nom);
        if ($compte) {
            switch ($compte->nom) {
                case 'Règlement fournisseurs':
                    $reglementEffet->save();
                    ReglementEffetFournisseur::create([
                        'sous_compte_id' => $row['sous_compte_id'],
                        'reglement_effet_id' => $reglementEffet->id,
                    ]);
                    break;

                default:
                    $reglementEffet->save();
                    break;
            }
        }
        $reglementEffet->save();

        Log::info('ReglementCheque ID: ' . $reglementEffet->id);
        // dd($reglementCheque->id);
        $this->reglementEffets[] = $reglementEffet;

        return $reglementEffet;
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



        $effet = $this->effets->where('effet_number', $row['effet_id'])->first();
        $effet_compte = $this->effet_comptes->where('nom', $row['effet_compte_id'])->first();
        $bene = $this->benes->where('nom', $row['benefiiaire_id'])->first();
        $service = $this->services->where('nom', $row['service_id'])->first();
        // $companier = $this->companiers->where('nom', $row['companier_id'])->first();
        $sous_compte = $this->sous_comptes->where('nom', $row['sous_compte_id'])->first();

        $user_id = auth()->user() ? auth()->user()->id : null;
        // dd( $row );
        return [
            'date_reglement' =>  $reglementDateConvert ?? null,
            'effet_id' =>  $effet ? $effet->id : null,
            'effet_compte_id' =>  $effet_compte ? $effet_compte->id : null,
            'benefiiaire_id' =>  $bene ? $bene->id : null,
            'service_id' =>  $service ? $service->id : null,
            'montant' => $row['montant'],
            'echeance' => $echeanceDateConvert ?? null,
            'referance' => $row['referance'],

            'sous_compte_id' => $sous_compte ? $sous_compte->id : null,
            // 'companier_id' => $companier ? $companier->id : null,

            'images' => $row['images'],


        ];
    }
}
