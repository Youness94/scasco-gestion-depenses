<?php

namespace App\Http\Controllers;

use App\Imports\CheckbookImport;
use App\Models\Bank;
use App\Models\Check;
use App\Models\Checkbook;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
// use Excel;
class CheckbookController extends Controller
{
    public function AllCheckbooks()
    {
        $checkbooks = Checkbook::with('bank')->orderBy('created_at', 'desc')->get();
        return view('checkbooks.list-checkbook', compact('checkbooks')); //
    }

    public function search_checkbook(Request $request)
    {
        $search = $request->search;

        $checkbooks = Checkbook::where(function ($query) use ($search) {
            $query->where('reception_date', 'like', '%' . $search . '%')
                ->orWhere('series', 'like', '%' . $search . '%')
                ->orWhere('quantity', 'like', '%' . $search . '%');
        })
            ->orWhereHas('bank', function ($query) use ($search) {
                $query->where('nom', 'like', '%' . $search . '%');
            })
            ->get();

        return view('checkbooks.list-checkbook', compact('checkbooks', 'search'));
    }


    public function AddCheckbook()
    {
        if (auth()->check()) {
            $checkbooks = Checkbook::latest()->get();
            $banks = Bank::all();
            return view('checkbooks.add-checkbook', compact('checkbooks', 'banks'));
            // return view('backend.clients.add_client');
        } else {
            // User is not authenticated, redirect to the login page
            return redirect('/login')->with('error', 'Vous devez être connecté pour effectuer cette action');
        }
    }

    public function StoreCheckbook(Request $request)
    {
        if (auth()->check()) {
            $validatedData = $request->validate([
                'reception_date' => 'required|date_format:Y-m-d', // Update the date format
                'bank_id' => 'required|exists:banks,id',
                'cheque_sie' => 'required|string',
                'start_number' => 'required|integer',
                'quantity' => 'required|integer',
            ]);

            // Dynamically generate the series based on reception_date
            $formattedDate = Carbon::parse($validatedData['reception_date'])->format('dmY');
            $series = $formattedDate . '01';

            $lastCheckbook = Checkbook::whereDate('reception_date', '=', $validatedData['reception_date'])->latest()->first();

            if ($lastCheckbook) {
                // If there is an existing checkbook for the specified date, increment the series by 1
                $lastSeriesNumber = (int) substr($lastCheckbook->series, -2) + 1;
                $series = $formattedDate . str_pad($lastSeriesNumber, 2, '0', STR_PAD_LEFT);
            }

            $checkbookData = array_merge($validatedData, [
                'series' => $series,
                // 'user_id' => $request->user()->id, 
                'user_id' => auth()->user()->id,
            ]);

            $checkbook = Checkbook::create($checkbookData);

            if ($checkbook->checks()->count() >= $checkbook->quantity) {
                return redirect()->back()->with('error', 'Checkbook is already filled');
            }

            $startNumber = $checkbook->start_number;
            $remainingChecks = $checkbook->quantity - $checkbook->checks()->count();
            // $user = Auth::user(); // Get the authenticated user
            for ($i = 0; $i < $remainingChecks; $i++) {
                $checkNumber = $startNumber + $i;

                Check::create([
                    'series' => $checkbook->series,
                    'cheque_sie' => $checkbook->cheque_sie,
                    'number' => $checkNumber,
                    'checkbook_id' => $checkbook->id,
                    'user_id' => auth()->user()->id,
                ]);
            }

            return redirect('/tous/checkbooks')->with('success', 'Checkbook created successfully');
        } else {
            // User is not authenticated, redirect to the login page
            return redirect('/login')->with('error', 'Vous devez être connecté pour effectuer cette action');
        }
    }

    public function updateValidation($id)
    {
        try {
            $checkbook = Checkbook::findOrFail($id);

            $checkbook->update(['validation' => true]);
            Log::info($checkbook);

            return redirect('/tous/checkbooks')->with('success', 'Validation updated successfully');
        } catch (\Exception $ex) {
            return redirect('/tous/checkbooks')->with('error', 'Error updating validation');
            Log::info($ex);
        }
    }
    public function ShowCheckbook($id)
    {
        $checkbooks = Checkbook::findOrFail($id);; // Retrieve all clients from the database
        return view('checkbooks.show-checkbook', compact('checkbooks'));
    }

    public function EditCheckbook($id)
    {
        if (auth()->check()) {
            $checkbooks = Checkbook::findOrFail($id);
            $banks = Bank::all();
            return view('checkbooks.edit-checkbook', compact('checkbooks', 'banks'));
        } else {
            return redirect('/login')->with('error', 'Vous devez être connecté pour effectuer cette action');
        }
    }


    public function UpdateCheckbook(Request $request, Checkbook $checkbook)
    {
        $cbkId = $request->id;
        $checkbook = Checkbook::findOrFail($cbkId);

        $formattedDate = Carbon::parse($request->reception_date)->format('dmY');
        $series = $formattedDate . '01';

        $lastCheckbook = Checkbook::whereDate('reception_date', '=', $request->reception_date)->latest()->first();

        if ($lastCheckbook) {
            $lastSeriesNumber = (int) substr($lastCheckbook->series, -2) + 1;
            $series = $formattedDate . str_pad($lastSeriesNumber, 2, '0', STR_PAD_LEFT);
        }

        $checkbookData = array_merge($request->all(), [
            'series' => $series,
            'user_id' => auth()->user()->id,
        ]);

        // Get the existing checks
        $existingChecks = $checkbook->checks;

        // Update the checkbook record
        $checkbook->update($checkbookData);

        // Update or create checks based on the new start number and quantity
        $startNumber = $checkbook->start_number;
        $quantity = $checkbook->quantity;

        foreach ($existingChecks as $existingCheck) {
            if ($existingCheck->number >= $startNumber && $existingCheck->number < ($startNumber + $quantity)) {
                // Update the existing check
                $existingCheck->update([
                    'series' => $checkbook->series,
                    'cheque_sie' => $checkbook->cheque_sie,
                    'user_id' => auth()->user()->id,
                ]);
            } else {

                $existingCheck->delete();
            }
        }

        for ($i = 0; $i < $quantity; $i++) {
            $checkNumber = $startNumber + $i;

            Check::create([
                'series' => $checkbook->series,
                'cheque_sie' => $checkbook->cheque_sie,
                'number' => $checkNumber,
                'checkbook_id' => $checkbook->id,
                'user_id' => auth()->user()->id,
            ]);
        }

        return redirect('/tous/checkbooks')->with('success', 'Checkbook updated successfully');
    }



    public function DeleteCheckbook(Checkbook $checkbook, $id)
    {
        // $checkbook->delete();

        // $clt = $request->id;
        Checkbook::findOrFail($id)->delete();
        return redirect('/tous/checkbooks')->with('success', 'Checkbook deleted successfully');
    }





    public function storeExcelCheckbook(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
             
          $file=  $request->file('file');
            $import = new CheckbookImport();
            
            Excel::import($import, $request->file('file'));
            // dd($file);
            // Now, calculate and store the checks for each imported checkbook
            $this->processChecks($import->getCheckbooks());
            Log::info('Checkbooks imported successfully.');
            return redirect()->back()->with('success', 'Checkbooks imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing checkbooks: ' . $e->getMessage());
        }
    }
   

    private function processChecks($checkbooks)
    {
        // dd($checkbooks);
        foreach ($checkbooks as $checkbook) {
            $startNumber = $checkbook->start_number;
            $remainingChecks = $checkbook->quantity - $checkbook->checks()->count();

            for ($i = 0; $i < $remainingChecks; $i++) {
                $checkNumber = $startNumber + $i;
                
                $checkbook->checks()->create([
                    'series' => $checkbook->series,
                    'cheque_sie' => $checkbook->cheque_sie,
                    'number' => $checkNumber,
                    'checkbook_id' => $checkbook->id,
                    'user_id' => auth()->user()->id,
                ]);
                //  Check::create([
                //     'series' => $checkbook->series,
                //     'cheque_sie' => $checkbook->cheque_sie,
                //     'number' => $checkNumber,
                //     'checkbook_id' => $checkbook->id,
                //     'user_id' => auth()->user()->id,
                // ]);
            }
        }
    }
}
