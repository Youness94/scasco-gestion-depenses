<?php
// php artisan make:import ReglementEffetImport --model=ReglementEffet
//  php artisan make:import ReglementChequeImport --model=ReglementCheque
//  php artisan make:import CarnetEffetImport --model=CarnetEffet
//  php artisan make:import CheckbookImport --model=Checkbook 

namespace App\Imports;

use App\Models\CarnetEffet;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Bank;
use Carbon\Carbon;

class CarnetEffetImport implements WithHeadingRow, ToModel, WithMapping
{

    private $banks;
    private $carnetEffets = [];

    public function __construct()
    { 
        $this->banks = Bank::select('id', 'nom')->get();
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    
    public function model(array $row)
    {
        // dd($row);
        $bank = $this->banks->where('nom', $row['bank_id'])->first();
        $carnetEffet = new CarnetEffet([
            'reception_date' =>  $row['reception_date'],
            'carnet_series' => $row['carnet_series'],
            'bank_id' =>  $row['bank_id'],
            'effet_sie' => $row['effet_sie'],
            'effet_start_number' => $row['effet_start_number'],
            'effet_quantity' => $row['effet_quantity'],
            'user_id' => $row['user_id'],
        ]);
        $this->carnetEffets[] = $carnetEffet;

        return $carnetEffet;
    }

    public function map($row): array
    {
        try {
            // $receptionDate = Carbon::createFromFormat('Y-m-d', $row['reception_date']);
            $excelDate = $row['reception_date'];
            $receptionDate = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($excelDate))->format('Y-m-d');
            // $formattedDate = $receptionDate->format('Y-m-d');
            // dd($receptionDate );
        } catch (\Exception $e) {
            dd('Error: ' . $e->getMessage(), 'Date String: ' . $row['reception_date']);
        }
        $bank = $this->banks->where('nom', $row['bank_id'])->first();
        $user_id = auth()->user() ? auth()->user()->id : null;
        // dd( $bank );
        return [
            'reception_date' => $receptionDate ?? null,
            'carnet_series' => $row['carnet_series'],
            'bank_id' => $bank ? $bank->id : null,
            'effet_sie' => $row['effet_sie'],
            'effet_start_number' => $row['effet_start_number'],
            'effet_quantity' => $row['effet_quantity'],
            'user_id' => $user_id,
        ];
    }
    


    public function getCarneteffets()
    {
        return $this->carnetEffets;
    }
}
