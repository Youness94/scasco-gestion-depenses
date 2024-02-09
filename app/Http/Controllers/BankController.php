<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function AllBanks()
    {
       $banks = Bank::latest()->get();// Retrieve all remunerations from the database
        return view('banks.list-bank', compact('banks'));//
    }

    public function AddBank()
    {
        $banks = Bank::latest()->get();// Retrieve all remunerations from the database
        return view('banks.add-bank', compact('banks'));
        
    }

    public function StoreBank(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:100',
            
        // Add more validation rules for other fields
        ]);

        $bank = new Bank($validatedData);
        $bank->user_id = auth()->user()->id; // Associate the remuneration with the logged-in user
        $bank->save();

        return redirect('/tous/banques')->with('success', 'Bankreated successfully');
        
        
      
    }

    public function ShowBank($id)
    {
        $banks = Bank::findOrFail($id);
        return view('banks.show-bank', compact('banks'));
    }

    public function EditBank($id)
    {
        $banks = Bank::findOrFail($id);
        return view('banks.edit-bank', compact('banks'));
    }

   
    public function UpdateBank(Request $request, Bank $banks)
    {
        
        $ban = $request->id;
        Bank::findOrFail($ban)->update([
            'nom' => $request->nom,
            // Add more validation rules for other fields
        ]);
        $banks->user_id = auth()->user()->id;
        

        return redirect('/tous/banques')->with('success', 'Bank updated successfully');
    }

    public function DeleteBank(Bank $bank, $id)
    {
    
        Bank::findOrFail($id)->delete();
        return redirect('/tous/banques')->with('success', 'Bank deleted successfully');
    }
}
