<?php

namespace App\Http\Controllers\Effet;

use App\Http\Controllers\Controller;
use App\Models\CarnetEffet;
use App\Models\Courtier;
use App\Models\EffetAffectation;
use App\Models\EffetAffectationImage;
use App\Models\EffetService;
use App\Models\Service;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EffetAffectationController extends Controller
{

    use PhotoTrait;
    public function AllEffetAffectations()
    {
        $effet_affectations = EffetAffectation::with('effet_images')->orderBy('created_at', 'desc')->get();
        return view('effet_affectations.list_effet_affectation', compact('effet_affectations'));
    }

    public function AddEffetAffectation()
    {
        $carnet_effets = CarnetEffet::doesntHave('effet_affectation')->get();

        $effet_services = Service::all();
        $courtiers = Courtier::all();
        $effet_affectations = EffetAffectation::latest()->get();


        return view('effet_affectations.add_effet_affectation', compact('effet_affectations', 'carnet_effets', 'effet_services', 'courtiers'));
    }

    public function StoreEffetAffectation(Request $request)
    {
        $data = $request->validate([
            'affectation_date' => 'required|date',
            'carnet_effet_id' => 'required|exists:carnet_effets,id',
            'start_number' => 'required|integer',
            'end_number' => 'required|integer',
            'service_id' => 'required|exists:services,id',
            'courtier_id' => 'required|exists:courtiers,id',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Retrieve the selected checkbook
        $carnet_effet = CarnetEffet::findOrFail($request->input('carnet_effet_id'));

        // Get the first and last items from the Checkbook array
        $firstItem = $carnet_effet->start_number;
        $lastItem = $carnet_effet->start_number + $carnet_effet->effet_quantity - 1;

        Log::info($firstItem);
        Log::info($lastItem);


        $images = [];

        // Create the affectation
        $effet_affectation = EffetAffectation::create([
            'affectation_date' => $request->input('affectation_date'),
            'carnet_effet_id' => $carnet_effet->id,
            'start_number' => $request->input('start_number'),
            'end_number' => $request->input('end_number'),
            'service_id' => $request->input('service_id'),
            'courtier_id' => $request->input('courtier_id'),
            'images' => $images,
        ]);

        $this->uploadFiles($request, 'public/photos/effet_affectation', EffetAffectationImage::class, 'effet_affectation_id', $effet_affectation->id);
        // foreach ($data['images'] as $image) {
        //     $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
        //     $image_path = $image->storeAs('images', $fileName, 'public');

        //     $images[] = $image_path;
        // }

        // $effet_affectation->update(['images' => $images]);
        return redirect()->route('all.effet-affectations')->with('success', 'Affectation created successfully');
    }

    public function ShowEffetAffectation($id)
    {
        $effet_affectation = EffetAffectation::with(['effet_images', 'carnet_effet', 'service', 'courtier'])->findOrFail($id);
        return view('effet_affectations.show_effet_affectation', compact('effet_affectation'));
    }

    public function EditEffetAffectation($id)
    {
        $carnet_effets = CarnetEffet::whereDoesntHave('effet_affectation', function ($query) use ($id) {
            $query->where('id', '!=', $id);
        })->get();
        $effet_services = Service::all();
        $courtiers = Courtier::all();
        $effet_affectations = EffetAffectation::findOrFail($id);
        return view('effet_affectations.edit_effet_affectation', compact('effet_affectations', 'carnet_effets', 'courtiers', 'effet_services'));
    }


    public function UpdateEffetAffectation(Request $request)
    {
        $data = $request->validate([
            'affectation_date' => 'required|date',
            'carnet_effet_id' => 'required|exists:carnet_effets,id',
            'start_number' => 'required|integer',
            'end_number' => 'required|integer',
            'service_id' => 'required|exists:services,id',
            'courtier_id' => 'required|exists:courtiers,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $effet_affectations = EffetAffectation::findOrFail($request->input('id'));

        $effet_affectations->update([
            'affectation_date' => $data['affectation_date'],
            'carnet_effet_id' => $data['carnet_effet_id'],
            'start_number' => $data['start_number'],
            'end_number' => $data['end_number'],
            'service_id' => $data['service_id'],
            'courtier_id' => $data['courtier_id'],
        ]);

        // if ($request->hasFile('images')) {
        //     $images = [];
        //     foreach ($request->file('images') as $image) {
        //         $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
        //         $image_path = $image->storeAs('images', $fileName, 'public');
        //         $images[] = $image_path;
        //     }

        //     $effet_affectations->update(['images' => $images]);
        // }
        $this->handleFileUpload($request, 'public/photos/effet_affectation', EffetAffectationImage::class, 'effet_affectation_id', $effet_affectations->id);

        return redirect()->route('all.effet-affectations')->with('success', 'Affectation updated successfully');
    }

    public function DeleteEffetAffectation(EffetAffectation $effet_affectation, $id)
    {

        EffetAffectation::findOrFail($id)->delete();
        return redirect('/tous/effet-affectations')->with('success', 'Affectation deleted successfully');
    }
}
