<?php

namespace App\Http\Controllers;

use App\Models\Courtier;
use Illuminate\Http\Request;

class CourtierController extends Controller
{
    public function AllCourtiers()
    {
       $courtiers = Courtier::latest()->get();// Retrieve all remunerations from the database
        return view('courtiers.list-courtier', compact('courtiers'));//
    }

    public function AddCourtier()
    {
        $courtiers = Courtier::latest()->get();// Retrieve all remunerations from the database
        return view('courtiers.add-courtier', compact('courtiers'));
        
    }

    public function StoreCourtier(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:100',
            
        // Add more validation rules for other fields
        ]);

        $courtier = new Courtier($validatedData);
        $courtier->user_id = auth()->user()->id; // Associate the remuneration with the logged-in user
        $courtier->save();

        return redirect('/tous/courtiers')->with('success', 'Courtier created successfully');
        
        
      
    }

    public function ShowCourtier($id)
    {
        $courtiers = Courtier::findOrFail($id);
        return view('courtiers.show-courtier', compact('courtiers'));
    }

    public function EditCourtier($id)
    {
        $courtiers = Courtier::findOrFail($id);
        return view('courtiers.edit-courtier', compact('courtiers'));
    }

   
    public function UpdateCourtier(Request $request, Courtier $courtiers)
    {
        
        $court = $request->id;
        Courtier::findOrFail($court)->update([
            'nom' => $request->nom,
            // Add more validation rules for other fields
        ]);
        $courtiers->user_id = auth()->user()->id;
        

        return redirect('/tous/courtiers')->with('success', 'Courtier updated successfully');
    }

    public function DeleteCourtier(Courtier $courtier, $id)
    {
    
        Courtier::findOrFail($id)->delete();
        return redirect('/tous/courtiers')->with('success', 'Courtier deleted successfully');
    }
}
