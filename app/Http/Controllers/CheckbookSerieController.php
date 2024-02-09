<?php

namespace App\Http\Controllers;

use App\Models\Checkbook;
use App\Models\CheckbookSerie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckbookSerieController extends Controller
{
    //
    public function AllCheckbookSerie()
    {
        $checkbook_serie = CheckbookSerie::latest()->get(); // Retrieve all clients from the database
        return view('checkbookserie.list-checkbookserie', compact('checkbook_serie')); //
    }

   
    // public function store()
    // {
    //     // Assuming you have a user_id; replace with the actual user ID
    //     $userId = 1;

    //     $checkbooks = Checkbook::where('user_id', $userId)->get();

    //     foreach ($checkbooks as $checkbook) {
    //         // Calculate the end number based on start_number and checkbook_q
    //         $endNumber = $checkbook->start_number + $checkbook->checkbook_q - 1;

    //         // Insert the series into the checkbook_serie table
    //         CheckbookSerie::create([
    //             'serie_checkbook' => $checkbook->series,
    //             'checkbook_serie_q' => $checkbook->checkbook_q,
    //         ]);
    //     }

    //     return response()->json(['message' => 'Checkbook series calculated successfully']);
    // }
}
