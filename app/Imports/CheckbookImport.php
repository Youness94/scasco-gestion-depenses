<?php

namespace App\Imports;

use App\Models\Bank;
use App\Models\Checkbook;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMapping;

class CheckbookImport implements WithHeadingRow, ToModel, WithMapping
{
    private $banks;
    private $checkbooks = [];

    public function __construct()
    { 
        $this->banks = Bank::select('id', 'nom')->get();
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    // public function rules(): array
    // {
    //     return [
    //         'reception_date' => 'required|date_format:d/m/Y',
    //         'series' => 'required',
    //         'cheque_sie' => 'required',
    //         'start_number' => 'required|numeric',
    //         'quantity' => 'required|numeric',
    //         'validation' => 'nullable|boolean',
    //     ];
    // }
    public function model(array $row)
    {
        // dd($row);
        $bank = $this->banks->where('nom', $row['bank_id'])->first();

        $checkbook = new Checkbook([
            'reception_date' => $row['reception_date'],
            'series' => $row['series'],
            'bank_id' => $row['bank_id'],
            'cheque_sie' => $row['cheque_sie'],
            'start_number' => $row['start_number'],
            'quantity' => $row['quantity'],
            'user_id' => $row['user_id'],
        ]);
        $this->checkbooks[] = $checkbook;

        return $checkbook;
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
        // dd( $row );
        return [
            'reception_date' => $receptionDate ?? null,
            'series' => $row['series'],
            'bank_id' => $bank ? $bank->id : null,
            'cheque_sie' => $row['cheque_sie'],
            'start_number' => $row['start_number'],
            'quantity' => $row['quantity'],
            'user_id' => $user_id,
        ];
    }
    


    public function getCheckbooks()
    {
        return $this->checkbooks;
    }
}
