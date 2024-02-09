<?php

namespace App\Http\Controllers;

use App\Models\BeneCompte;
use App\Models\CompteDepense;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BeneCompteController extends Controller
{
    public function AllBeneComptes()
    {
        $bene_comptes = BeneCompte::with('compte_depense')->orderBy('created_at', 'desc')->get();
        return view('bene_comptes.list-bene-compte', compact('bene_comptes')); //
    }

    public function AddBeneCompte()
    {
        if (auth()->check()) {
        $bene_comptes = BeneCompte::latest()->get(); 
        $compte_depenses = CompteDepense::all();
        return view('bene_comptes.add-bene-compte', compact('bene_comptes', 'compte_depenses'));
        // return view('backend.clients.add_client');
    } else {
        // User is not authenticated, redirect to the login page
        return redirect('/login')->with('error', 'Vous devez être connecté pour effectuer cette action');
    }
    }

    public function StoreBeneCompte(Request $request)
{
    if (auth()->check()) {
        // Validate the incoming request data
        $request->validate([
            'nom' => 'required|string|max:100',
            'compte_depense_id' => 'required|exists:compte_depenses,id',
        ]);

        // Create the BeneCompte with the authenticated user's ID
        $beneCompte = BeneCompte::create([
            'nom' => $request->input('nom'),
            'compte_depense_id' => $request->input('compte_depense_id'),
            'user_id' => auth()->id(), // Assuming you are associating the BeneCompte with the currently authenticated user
            // Add other fields as needed
        ]);

        return redirect('/tous/bene-comptes')->with('success', 'BeneCompte created successfully');
    } else {
        // User is not authenticated, redirect to the login page
        return redirect('/login')->with('error', 'Vous devez être connecté pour effectuer cette action');
    }
}

    public function ShowBeneCompte($id)
    {
        $bene_comptes = BeneCompte::findOrFail($id);; // Retrieve all clients from the database
        return view('bene_comptes.show-bene-compte', compact('bene_comptes'));
    }

    public function EditBeneCompte($id)
    {
        $bene_comptes = BeneCompte::findOrFail($id);
        $compte_depenses = CompteDepense::all(); // Assuming you need the list of compte_depenses
        return view('bene_comptes.edit-bene-compte', compact('bene_comptes', 'compte_depenses'));
    }


    public function UpdateBeneCompte(Request $request, BeneCompte $bene_compte)
    {

        $cbkId = $request->id; // Assuming you're passing the ID through the request
        $bene_compte = BeneCompte::findOrFail($cbkId);

        // Update the checkbook record
        $bene_compte->update([
            'nom' => $request->input('nom'),
            'compte_depense_id' => $request->input('compte_depense_id'),
            // Add other fields as needed
        ]);

        // Update the user ID associated with this checkbook
        $bene_compte->user_id = auth()->user()->id;
        $bene_compte->save();



        return redirect('/tous/bene-comptes')->with('success', 'Checkbook updated successfully');
    }

    public function DeleteBeneCompte(BeneCompte $checkbook, $id)
    {
        // $checkbook->delete();

        // $clt = $request->id;
        BeneCompte::findOrFail($id)->delete();
        return redirect('/tous/bene-comptes')->with('success', 'Checkbook deleted successfully');
    }
}