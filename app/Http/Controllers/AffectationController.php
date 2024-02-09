<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\AffectationImage;
use App\Models\Check;
use App\Models\Checkbook;
use App\Models\Courtier;
use App\Models\Image;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AffectationController extends Controller
{
    // public function AllAffectations2()
    // {

    //     // $a=new Affectation();
    //     // $affectations = $a->gettest();

    //     $affectations = Affectation::with('images')->orderBy('created_at', 'desc')->get();
    //     return view('affectations.list-affectation', compact('affectations'));
    // }

    public function AllAffectations()
    {
        $affectations = Affectation::with('images')->orderBy('created_at', 'desc')->get();
        return view('affectations.list-affectation', compact('affectations'));
    }

    public function AddAffectation()
    {
        $checkbooks = Checkbook::doesntHave('affectation')->get();

        $services = Service::all();
        $courtiers = Courtier::all();
        $affectations = Affectation::latest()->get();


        return view('affectations.add-affectation', compact('affectations', 'checkbooks', 'services', 'courtiers'));
    }

    public function StoreAffectation(Request $request)
    {
        $data = $request->validate([
            'affectation_date' => 'required|date',
            'checkbook_id' => 'required|exists:checkbooks,id',
            'start_number' => 'required|integer',
            'end_number' => 'required|integer',
            'service_id' => 'required|exists:services,id',
            'courtier_id' => 'required|exists:courtiers,id',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Retrieve the selected checkbook
        $checkbook = Checkbook::findOrFail($request->input('checkbook_id'));

        // Get the first and last items from the Checkbook array
        $firstItem = $checkbook->start_number;
        $lastItem = $checkbook->start_number + $checkbook->quantity - 1;

        Log::info($firstItem);
        Log::info($lastItem);


        $images = [];

        // Create the affectation
        $affectation = Affectation::create([
            'affectation_date' => $request->input('affectation_date'),
            'checkbook_id' => $checkbook->id,
            'start_number' => $request->input('start_number'),
            'end_number' => $request->input('end_number'),
            'service_id' => $request->input('service_id'),
            'courtier_id' => $request->input('courtier_id'),
            'images' => $images,
        ]);

        foreach ($data['images'] as $image) {
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image_path = $image->storeAs('images', $fileName, 'public');

            $images[] = $image_path;
        }

        $affectation->update(['images' => $images]);
        return redirect()->route('all.affectations')->with('success', 'Affectation created successfully');
    }

    public function ShowAffectation($id)
    {
        $affectation = Affectation::with(['images', 'checkbook', 'service', 'courtier'])->findOrFail($id);
        return view('affectations.show-affectation', compact('affectation'));
    }

    public function EditAffectation($id)
    {
        $checkbooks = Checkbook::whereDoesntHave('affectation', function ($query) use ($id) {
            $query->where('id', '!=', $id);
        })->get();
        $services = Service::all();
        $courtiers = Courtier::all();
        $affectations = Affectation::findOrFail($id);
        return view('affectations.edit-affectation', compact('affectations', 'checkbooks', 'courtiers', 'services'));
    }


    public function UpdateAffectation(Request $request)
    {
        $data = $request->validate([
            'affectation_date' => 'required|date',
            'checkbook_id' => 'required|exists:checkbooks,id',
            'start_number' => 'required|integer',
            'end_number' => 'required|integer',
            'service_id' => 'required|exists:services,id',
            'courtier_id' => 'required|exists:courtiers,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $affectations = Affectation::findOrFail($request->input('id'));

        $affectations->update([
            'affectation_date' => $data['affectation_date'],
            'checkbook_id' => $data['checkbook_id'],
            'start_number' => $data['start_number'],
            'end_number' => $data['end_number'],
            'service_id' => $data['service_id'],
            'courtier_id' => $data['courtier_id'],
        ]);

        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                $image_path = $image->storeAs('images', $fileName, 'public');
                $images[] = $image_path;
            }

            $affectations->update(['images' => $images]);
        }


        return redirect()->route('all.affectations')->with('success', 'Affectation updated successfully');
    }

    public function DeleteAffectation(Affectation $affectation, $id)
    {

        Affectation::findOrFail($id)->delete();
        return redirect('/tous/affectations')->with('success', 'Affectation deleted successfully');
    }
}
