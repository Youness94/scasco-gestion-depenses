<?php

namespace App\Http\Controllers\Effet;

use App\Http\Controllers\Controller;
use App\Imports\CarnetEffetImport;
use App\Models\Bank;
use App\Models\CarnetEffet;
use App\Models\Effet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class CarnetEffetController extends Controller
{
    public function AllCarnetsEffets()
    {
        $carnets_effets = CarnetEffet::with('bank',)->orderBy('created_at', 'desc')->get();
        return view('carnets_effets.list_carnets_effets', compact('carnets_effets')); //
    }

    public function search_carnet_effet(Request $request)
    {
        $search = $request->search;
    
        $carnets_effets = CarnetEffet::where(function ($query) use ($search) {
            $query->where('reception_date', 'like', '%' . $search . '%')
                ->orWhere('carnet_series', 'like', '%' . $search . '%')
                ->orWhere('effet_quantity', 'like', '%' . $search . '%');
        })
            ->orWhereHas('bank', function ($query) use ($search) {
                $query->where('nom', 'like', '%' . $search . '%');
            })
            ->get();
    
            return view('carnets_effets.list_carnets_effets', compact('carnets_effets', 'search'));
    }
    public function AddCarnetEffet()
    {
        if (auth()->check()) {
        $carnet_effet = CarnetEffet::latest()->get(); 
        $banks = Bank::all();
        return view('carnets_effets.add_carnet_effet', compact('carnet_effet', 'banks'));
    } else {
        
        return redirect('/login')->with('error', 'Vous devez être connecté pour effectuer cette action');
    }
    }

    public function StoreCarnetEffet(Request $request)
{
    if (auth()->check()) {
    $validatedData = $request->validate([
        'reception_date' => 'required|date_format:Y-m-d', 
        'bank_id' => 'required|exists:banks,id',
        'effet_sie' => 'required|string',
        'effet_start_number' => 'required|integer',
        'effet_quantity' => 'required|integer',
    ]);

    // Dynamically generate the series based on reception_date
    $formattedDate = Carbon::parse($validatedData['reception_date'])->format('dmY');
    $series = $formattedDate . '01';

    $lastCranetEffet = CarnetEffet::whereDate('reception_date', '=', $validatedData['reception_date'])->latest()->first();

    if ($lastCranetEffet) {
        // If there is an existing checkbook for the specified date, increment the series by 1
        $lastSeriesNumber = (int) substr($lastCranetEffet->carnet_series, -2) + 1;
        $series = $formattedDate . str_pad($lastSeriesNumber, 2, '0', STR_PAD_LEFT);
    }

    $carnetEffetData = array_merge($validatedData, [
        'carnet_series' => $series,
        // 'user_id' => $request->user()->id, 
        'user_id' => auth()->user()->id,
    ]);

    $carnetEffet = CarnetEffet::create($carnetEffetData);

    if ($carnetEffet->effets()->count() >= $carnetEffet->effet_quantity) {
        return redirect()->back()->with('error', 'Checkbook is already filled');  
    }

    $startNumber = $carnetEffet->effet_start_number;
    $remainingEffets = $carnetEffet->effet_start_number - $carnetEffet->effets()->count();
    // $user = Auth::user(); // Get the authenticated user
    for ($i = 0; $i < $remainingEffets; $i++) {
        $effetNumber = $startNumber + $i;

        Effet::create([
            'effet_series' => $carnetEffet->carnet_series,
            'effet_sie' => $carnetEffet->effet_sie,
            'effet_number' => $effetNumber,
            'carnet_effet_id' => $carnetEffet->id,
            'user_id' => auth()->user()->id,
        ]);
    }

    return redirect('/tous/carnets-effets')->with('success', 'Carnet Effet created successfully');
} else {
   
    return redirect('/login')->with('error', 'Vous devez être connecté pour effectuer cette action');
}
}
public function updateValidation($id)
{
    try {
        $carnetEffet = CarnetEffet::findOrFail($id);

        $carnetEffet->update(['validation' => true]);
        Log::info( $carnetEffet);

        return redirect('/tous/carnets-effets')->with('success', 'Validation updated successfully');
    } catch (\Exception $ex) {
        return redirect('/tous/carnets-effets')->with('error', 'Error updating validation');
        Log::info( $ex);
    }
}

    public function ShowCarnetEffet($id)
    {
        $carnet_effet = CarnetEffet::findOrFail($id);
        
        return view('carnets_effets.show_carnet_effet', compact('carnet_effet'));
    }

 

    public function EditCarnetEffet($id)
    {
        
        
        if (auth()->check()) {
            $carnet_effet = CarnetEffet::findOrFail($id);
            $banks = Bank::all();
            return view('carnets_effets.edit_carnets_effets', compact('carnet_effet','banks'));
        } else {
            return redirect('/login')->with('error', 'Vous devez être connecté pour effectuer cette action');
        }
    }


    public function UpdateCarnetEffet(Request $request, CarnetEffet $carnet_effet)
    {

        $cbkId = $request->id; 
        $carnet_effet = CarnetEffet::findOrFail($cbkId);

        // Dynamically generate the series based on reception_date
        $formattedDate = Carbon::parse($request->reception_date)->format('dmY');
        $series = $formattedDate . '01';
    
        $lastCarnetEffet = CarnetEffet::whereDate('reception_date', '=', $request->reception_date)->latest()->first();
    
        if ($lastCarnetEffet) {
            $lastSeriesNumber = (int) substr($lastCarnetEffet->series, -2) + 1;
            $series = $formattedDate . str_pad($lastSeriesNumber, 2, '0', STR_PAD_LEFT);
        }
    
        $checkbookData = array_merge($request->all(), [
            'carnet_series' => $series,
            'user_id' => auth()->user()->id,
        ]);
    
        // Get the existing checks
        $existingEffets = $carnet_effet->effets;
    
        // Update the checkbook record
        $carnet_effet->update($checkbookData);
    
        // Update or create checks based on the new start number and quantity
        $startNumber = $carnet_effet->effet_start_number;
        $quantity = $carnet_effet->effet_quantity;
    
        foreach ($existingEffets as $existingEffet) {
            if ($existingEffet->effet_number >= $startNumber && $existingEffet->effet_number < ($startNumber + $quantity)) {
                // Update the existing check
                $existingEffet->update([
                    'carnet_series' => $carnet_effet->effet_series,
                    'effet_sie' => $carnet_effet->effet_sie,
                    'user_id' => auth()->user()->id,
                ]);
            } else {
                
                $existingEffet->delete();
            }
        }

        for ($i = 0; $i < $quantity; $i++) {
            $effetNumber = $startNumber + $i;
    
            Effet::create([
                'effet_series' => $carnet_effet->carnet_series,
                'effet_sie' => $carnet_effet->effet_sie,
                'effet_number' => $effetNumber,
                'carnet_effet_id' => $carnet_effet->id,
                'user_id' => auth()->user()->id,
            ]);
        }



        return redirect('/tous/carnets-effets')->with('success', 'Checkbook updated successfully');
    }

    public function DeleteCarnetEffet(CarnetEffet $carnetEffet, $id)
    {
        CarnetEffet::findOrFail($id)->delete();
        return redirect('/tous/carnets-effets')->with('success', 'Carnet Effet deleted successfully');
    }

    public function storeExcelCarnetEffet(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
             
          $file=  $request->file('file');
            $import = new CarnetEffetImport();
            
            Excel::import($import, $request->file('file'));
            // dd($file);
            // Now, calculate and store the checks for each imported checkbook
            $this->processEffets($import->getCarneteffets());
            Log::info('Carnet Effet  imported successfully.');
            return redirect()->back()->with('success', 'Carnet Effet imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing Carnet Effet : ' . $e->getMessage());
        }
    }
   

    private function processEffets($carnetEffets)
    {
        // dd($checkbooks);
        foreach ($carnetEffets as $carnetEffet) {
            $startNumber = $carnetEffet->effet_start_number;
            $remainingEffets = $carnetEffet->effet_quantity - $carnetEffet->effets()->count();
// dd($remainingEffets);
            for ($i = 0; $i < $remainingEffets; $i++) {
                $effetNumber = $startNumber + $i;
                
                $carnetEffet->effets()->create([
                    'effet_series' => $carnetEffet->carnet_series,
                    'effet_sie' => $carnetEffet->effet_sie,
                    'effet_number' => $effetNumber,
                    'carnet_effet_id' => $carnetEffet->id,
                    'user_id' => auth()->user()->id,
                ]);
            //      Effet::create([
            //         'effet_series' => $carnetEffet->carnet_series,
            // 'effet_sie' => $carnetEffet->effet_sie,
            // 'effet_number' => $effetNumber,
            // 'carnet_effet_id' => $carnetEffet->id,
            // 'user_id' => auth()->user()->id,
            //     ]);
            }
        }
    }

   
}
