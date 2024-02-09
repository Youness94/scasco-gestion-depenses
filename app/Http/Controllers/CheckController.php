<?php

namespace App\Http\Controllers;

use App\Models\BeneCompte;
use App\Models\Check;
use App\Models\Checkbook;
use App\Models\CompteDepense;
use App\Models\ReglementCheque;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckController extends Controller
{

    public function get_cheque_non_consommes()
    {
        $checks = Check::doesntHave('reglementCheque')->with(['checkbook.affectation.service'])->get();
        $services = Service::all();
        // Log::info([
        //     'check = ', $checks,
        //     'services = ', $services,
        // ]);
        return view('checks.all_checks', compact('services', 'checks'));
    }

   


    // public function FillChecks($checkbookId)
    // {
    //     $checkbooks = Checkbook::findOrFail($checkbookId);


    //     if ($checkbooks->checks()->count() >= $checkbooks->quantity) {
    //         return redirect()->back()->with('error', 'Checkbook is already filled');
    //     }

    //     $startNumber = $checkbooks->start_number;
    //     $remainingChecks = $checkbooks->quantity - $checkbooks->checks()->count();
    //     $user = Auth::user(); // Get the authenticated user

    //     for ($i = 0; $i < $remainingChecks; $i++) {
    //         $checkNumber = $startNumber + $i;

    //         Check::create([
    //             'series' => $checkbooks->series,
    //             'cheque_sie' => $checkbooks->cheque_sie,
    //             'number' => $checkNumber,
    //             'checkbook_id' => $checkbooks->id,

    //             'user_id' => $user->id,
    //         ]);
    //     }
    //     return redirect()->back()->with('success', 'Checks filled successfully');
    // }


    // ==================
    public function index()
    {
        $checks = Check::all();
        return view('checks.index', compact('checks'));
    }

    // Show the form to create a new check
    public function create()
    {
        return view('checks.create');
    }

    // Store a new check in the database
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'check_number' => 'required|unique:checks',
            'status' => 'required',
            // Add more validation rules as needed
        ]);

        // Create a new check record
        $check = new Check;
        $check->check_number = $request->check_number;
        $check->status = $request->status;
        $check->user_id = auth()->user()->id;
        // Add more fields as needed
        $check->save();

        return redirect()->route('checks.index')->with('success', 'Check created successfully');
    }

    // Show the form to edit a check
    public function edit($id)
    {
        $check = Check::findOrFail($id);
        return view('checks.edit', compact('check'));
    }

    // Update an existing check in the database
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'check_number' => 'required|unique:checks,check_number,' . $id,
            'status' => 'required',
            // Add more validation rules as needed
        ]);

        // Find the check to update
        $check = Check::findOrFail($id);
        $check->check_number = $request->check_number;
        $check->status = $request->status;
        // Update more fields as needed
        $check->save();

        return redirect()->route('checks.index')->with('success', 'Check updated successfully');
    }

    // Delete a check
    public function destroy($id)
    {
        $check = Check::findOrFail($id);
        $check->delete();

        return redirect()->route('checks.index')->with('success', 'Check deleted successfully');
    }
}
