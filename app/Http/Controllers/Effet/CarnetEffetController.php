<?php

namespace App\Http\Controllers\Effet;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\CarnetEffet;
use App\Models\Effet;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CarnetEffetController extends Controller
{
    public function AllCarnetsEffets()
    {
        $carnets_effets = CarnetEffet::with('bank')->orderBy('created_at', 'desc')->get();
        return view('carnets_effets.list_carnets_effets', compact('carnets_effets')); //
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

    public function ShowCarnetEffet($id)
    {
        $carnet_effet = CarnetEffet::findOrFail($id);; // Retrieve all clients from the database
        return view('carnets_effets.show_carnet_effet', compact('carnet_effet'));
    }

    public function EditCarnetEffet($id)
    {
        $carnet_effet = CarnetEffet::findOrFail($id);
        return view('carnets_effets.edit_carnets_effets', compact('carnet_effet'));
    }


    public function UpdateCarnetEffet(Request $request, CarnetEffet $carnet_effet)
    {

        $cbkId = $request->id; // Assuming you're passing the ID through the request
        $carnet_effet = CarnetEffet::findOrFail($cbkId);

        // Update the checkbook record
        $carnet_effet->update([
            'reception_date' => $request->reception_date,
            'series' => $request->series,
            'bank_id' => $request->bank_name,
            'effet_sie' => $request->cheque_sie,
            'effet_start_number' => $request->start_number,
            'effet_quantity' => $request->quantity,
            'status' => $request->status,
        ]);

        $carnet_effet->user_id = auth()->user()->id;
        $carnet_effet->save();



        return redirect('/tous/carnets-effets')->with('success', 'Checkbook updated successfully');
    }

    public function DeleteCarnetEffet(CarnetEffet $carnetEffet, $id)
    {
        CarnetEffet::findOrFail($id)->delete();
        return redirect('/tous/carnets-effets')->with('success', 'Carnet Effet deleted successfully');
    }
}
