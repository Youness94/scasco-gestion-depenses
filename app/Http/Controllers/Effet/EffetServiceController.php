<?php

namespace App\Http\Controllers\Effet;

use App\Http\Controllers\Controller;
use App\Models\EffetService;
use Illuminate\Http\Request;

class EffetServiceController extends Controller
{
    public function AllEffetServices()
    {
       $effet_services = EffetService::latest()->get();// Retrieve all remunerations from the database
        return view('effet_services.list-effet_service', compact('effet_services'));//
    }

    public function AddEffetService()
    {
        $effet_services = EffetService::latest()->get();// Retrieve all remunerations from the database
        return view('effet_services.add-effet_service', compact('effet_services'));
        
    }

    public function StoreEffetService(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:100',
            
        // Add more validation rules for other fields
        ]);

        $effet_service = new EffetService($validatedData);
        $effet_service->user_id = auth()->user()->id; // Associate the remuneration with the logged-in user
        $effet_service->save();

        return redirect('/tous/effet-services')->with('success', 'Services created successfully');
        
        
      
    }

    public function ShowEffetService($id)
    {
        $effet_services = EffetService::findOrFail($id);
        return view('effet_services.show-effet_service', compact('effet_services'));
    }

    public function EditEffetService($id)
    {
        $effet_services = EffetService::findOrFail($id);
        return view('effet_services.edit-effet_service', compact('effet_services'));
    }

   
    public function UpdateEffetService(Request $request, EffetService $effet_services)
    {
        
        $serv = $request->id;
        EffetService::findOrFail($serv)->update([
            'nom' => $request->nom,
            // Add more validation rules for other fields
        ]);
        $effet_services->user_id = auth()->user()->id;
        

        return redirect('/tous/effet-services')->with('success', 'Services updated successfully');
    }

    public function DeleteEffetService(EffetService $effet_service, $id)
    {
    
        EffetService::findOrFail($id)->delete();
        return redirect('/tous/effet-services')->with('success', 'Services deleted successfully');
    }
}
