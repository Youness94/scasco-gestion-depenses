<?php

namespace App\Http\Controllers;

use App\Models\SousCompte;
use Illuminate\Http\Request;

class SousCompteController extends Controller
{
    public function AllSousComptes()
    {
       $sous_comptes = SousCompte::latest()->get();// Retrieve all remunerations from the database
        return view('sous_comptes.list-sous-compte', compact('sous_comptes'));//
    }

    public function AddSousCompte()
    {
        $sous_comptes = SousCompte::latest()->get();// Retrieve all remunerations from the database
        return view('sous_comptes.add-sous-compte', compact('sous_comptes'));
        
    }

    public function StoreSousCompte(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:100',
            
        // Add more validation rules for other fields
        ]);

        $sous_compte = new SousCompte($validatedData);
        $sous_compte->user_id = auth()->user()->id; // Associate the remuneration with the logged-in user
        $sous_compte->save();

        return redirect('/tous/sous-comptes')->with('success', 'Services created successfully');
        
        
      
    }

    public function ShowSousCompte($id)
    {
        $sous_comptes = SousCompte::findOrFail($id);
        return view('sous_comptes.show-sous-compte', compact('sous_comptes'));
    }

    public function EditSousCompte($id)
    {
        $sous_comptes = SousCompte::findOrFail($id);
        return view('sous_comptes.edit-sous-compte', compact('sous_comptes'));
    }

   
    public function UpdateSousCompte(Request $request, SousCompte $services)
    {
        
        $souscompte = $request->id;
        SousCompte::findOrFail($souscompte)->update([
            'nom' => $request->nom,
            // Add more validation rules for other fields
        ]);
        $services->user_id = auth()->user()->id;
        

        return redirect('/tous/sous-comptes')->with('success', 'Services updated successfully');
    }

    public function DeleteSousCompte(SousCompte $sous_compte, $id)
    {
    
        SousCompte::findOrFail($id)->delete();
        return redirect('/tous/sous-comptes')->with('success', 'Services deleted successfully');
    }
}
