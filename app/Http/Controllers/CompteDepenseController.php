<?php

namespace App\Http\Controllers;

use App\Models\CompteDepense;
use Illuminate\Http\Request;

class CompteDepenseController extends Controller
{
    public function AllCompteDepenses()
    {
       $compte_depenses = CompteDepense::latest()->get();// Retrieve all remunerations from the database
        return view('compte_depenses.list-compte-depense', compact('compte_depenses'));//
    }

    public function AddCompteDepense()
    {
        $compte_depenses = CompteDepense::latest()->get();// Retrieve all remunerations from the database
        return view('compte_depenses.add-compte-depense', compact('compte_depenses'));
        
    }

    public function StoreCompteDepense(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:100',
            
        // Add more validation rules for other fields
        ]);

        $compte_depense = new CompteDepense($validatedData);
        $compte_depense->user_id = auth()->user()->id; // Associate the remuneration with the logged-in user
        $compte_depense->save();

        return redirect('/tous/compte-depenses')->with('success', 'Services created successfully');
        
        
      
    }

    public function ShowCompteDepense($id)
    {
        $compte_depenses = CompteDepense::findOrFail($id);
        return view('compte_depenses.show-compte-depense', compact('compte_depenses'));
    }

    public function EditCompteDepense($id)
    {
        $compte_depenses = CompteDepense::findOrFail($id);
        return view('compte_depenses.edit-compte-depense', compact('compte_depenses'));
    }

   
    public function UpdateCompteDepense(Request $request, CompteDepense $compte_depenses)
    {
        
        $cmptDepense = $request->id;
        CompteDepense::findOrFail($cmptDepense)->update([
            'nom' => $request->nom,
            // Add more validation rules for other fields
        ]);
        $compte_depenses->user_id = auth()->user()->id;
        

        return redirect('/tous/compte-depenses')->with('success', 'Services updated successfully');
    }

    public function DeleteCompteDepense(CompteDepense $compte_depense, $id)
    {
        CompteDepense::findOrFail($id)->delete();
        return redirect('/tous/compte-depenses')->with('success', 'Services deleted successfully');
    }
}
