<?php

namespace App\Http\Controllers\Effet;

use App\Http\Controllers\Controller;
use App\Models\Effet;
use Illuminate\Http\Request;

class EffetController extends Controller
{
    public function get_effets_non_consommes()
    {
        $effets = Effet::doesntHave('reglementEffet')->with(['carnet_effet.effet_affectation.effet_service'])->get();
        // $effet_services = EffetService::all();
        
        return view('effets.all_effets', compact('services', 'effets'));
    }



    // ==================
    public function index()
    {
        $effets = Effet::all();
        return view('effets.index', compact('effets'));
    }

    public function create()
    {
        return view('effets.create');
    }

    
    public function store(Request $request)
    {
 
        $validatedData = $request->validate([
            'effet_number' => 'required|unique:effets',
            'status' => 'required',
            
        ]);

       
        $effet = new Effet;
        $effet->effet_number = $request->effet_number;
        $effet->status = $request->status;
        $effet->user_id = auth()->user()->id;
     
        $effet->save();

        return redirect()->route('effets.index')->with('success', 'effets created successfully');
    }

    
    public function edit($id)
    {
        $effet = Effet::findOrFail($id);
        return view('effets.edit', compact('effet'));
    }

    
    public function update(Request $request, $id)
    {
       
        $validatedData = $request->validate([
            'effet_number' => 'required|unique:effets,effet_number,' . $id,
            'status' => 'required',
            
        ]);

        $effet = Effet::findOrFail($id);
        $effet->effet_number = $request->effet_number;
        $effet->status = $request->status;
      
        $effet->save();

        return redirect()->route('effets.index')->with('success', 'effet updated successfully');
    }

    
    public function destroy($id)
    {
        $effet = Effet::findOrFail($id);
        $effet->delete();

        return redirect()->route('effet.index')->with('success', 'effet deleted successfully');
    }
}
