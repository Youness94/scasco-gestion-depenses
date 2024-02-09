<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Check;
use App\Models\Checkbook;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;


class CheckbookController extends Controller
{
    public function AllCheckbooks()
    {
        $checkbooks = Checkbook::with('bank')->orderBy('created_at', 'desc')->get();
        return view('checkbooks.list-checkbook', compact('checkbooks')); //
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

    public function ShowCheckbook($id)
    {
        $checkbooks = Checkbook::findOrFail($id);; // Retrieve all clients from the database
        return view('checkbooks.show-checkbook', compact('checkbooks'));
    }

    public function EditCheckbook($id)
    {
        $checkbooks = Checkbook::findOrFail($id);
        return view('checkbooks.edit-checkbook', compact('checkbooks'));
    }


    public function UpdateCheckbook(Request $request, Checkbook $checkbook)
    {

        $cbkId = $request->id; // Assuming you're passing the ID through the request
        $checkbook = Checkbook::findOrFail($cbkId);

        // Update the checkbook record
        $checkbook->update([
            'reception_date' => $request->reception_date,
            'series' => $request->series,
            'bank_name' => $request->bank_name,
            'cheque_sie' => $request->cheque_sie,
            'start_number' => $request->start_number,
            'quantity' => $request->quantity,
            'status' => $request->status,
        ]);

        // Update the user ID associated with this checkbook
        $checkbook->user_id = auth()->user()->id;
        $checkbook->save();



        return redirect('/tous/checkbooks')->with('success', 'Checkbook updated successfully');
    }

    public function DeleteCheckbook(Checkbook $checkbook, $id)
    {
        // $checkbook->delete();

        // $clt = $request->id;
        Checkbook::findOrFail($id)->delete();
        return redirect('/tous/checkbooks')->with('success', 'Checkbook deleted successfully');
    }
}
