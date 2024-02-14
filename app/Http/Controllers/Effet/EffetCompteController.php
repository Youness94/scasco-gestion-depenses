<?php

namespace App\Http\Controllers\Effet;

use App\Http\Controllers\Controller;
use App\Models\EffetCompte;
use Illuminate\Http\Request;

class EffetCompteController extends Controller
{
      public function AllCompteEffets()
      {
         $compte_effets = EffetCompte::latest()->get();
          return view('compte_effets.list-compte-effets', compact('compte_effets'));//
      }
  
      public function AddCompteEffet()
      {
          $compte_effets = EffetCompte::latest()->get();
          return view('compte_effets.add-compte-effet', compact('compte_effets'));
          
      }
  
      public function StoreCompteEffet(Request $request)
      {
          $validatedData = $request->validate([
              'nom' => 'required|string|max:100',
              
          ]);
  
          $compte_effet = new EffetCompte($validatedData);
          $compte_effet->user_id = auth()->user()->id; 
          $compte_effet->save();
  
          return redirect('/tous/compte-effets')->with('success', 'Compte created successfully');
          
          
        
      }
  
      public function ShowCompteEffet($id)
      {
          $compte_effets = EffetCompte::findOrFail($id);
          return view('compte_effets.show-compte_effet', compact('compte_effets'));
      }
  
      public function EditCompteEffet($id)
      {
          $compte_effets = EffetCompte::findOrFail($id);
          return view('compte_effets.edit-compte-effet', compact('compte_effets'));
      }
  
     
      public function UpdateCompteEffet(Request $request, EffetCompte $compte_effet)
      {
          
          $cmptEffet = $request->id;
          EffetCompte::findOrFail($cmptEffet)->update([
              'nom' => $request->nom,
          ]);
          $compte_effet->user_id = auth()->user()->id;
          
  
          return redirect('/tous/compte-effets')->with('success', 'Compte updated successfully');
      }
  
      public function DeleteCompteEffet(EffetCompte $compte_effet, $id)
      {
            EffetCompte::findOrFail($id)->delete();
          return redirect('/tous/compte-effets')->with('success', 'Compte deleted successfully');
      }
}
