<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function AllServices()
    {
       $services = Service::latest()->get();// Retrieve all remunerations from the database
        return view('services.list-service', compact('services'));//
    }

    public function AddService()
    {
        $services = Service::latest()->get();// Retrieve all remunerations from the database
        return view('services.add-service', compact('services'));
        
    }

    public function StoreService(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:100',
            
        // Add more validation rules for other fields
        ]);

        $service = new Service($validatedData);
        $service->user_id = auth()->user()->id; // Associate the remuneration with the logged-in user
        $service->save();

        return redirect('/tous/services')->with('success', 'Services created successfully');
        
        
      
    }

    public function ShowService($id)
    {
        $services = Service::findOrFail($id);
        return view('services.show-service', compact('services'));
    }

    public function EditService($id)
    {
        $services = Service::findOrFail($id);
        return view('services.edit-service', compact('services'));
    }

   
    public function UpdateService(Request $request, Service $services)
    {
        
        $serv = $request->id;
        Service::findOrFail($serv)->update([
            'nom' => $request->nom,
            // Add more validation rules for other fields
        ]);
        $services->user_id = auth()->user()->id;
        

        return redirect('/tous/services')->with('success', 'Services updated successfully');
    }

    public function DeleteService(Service $service, $id)
    {
    
        Service::findOrFail($id)->delete();
        return redirect('/tous/services')->with('success', 'Services deleted successfully');
    }
}
