<?php

namespace App\Http\Controllers;

use App\Models\Production;
use App\Models\ReglementCheque;
use App\Models\ReglementEffet;
use App\Models\Sinistre;
use App\Models\SinistreDim;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    /** home dashboard */
    public function index()
    {
        $reglement_cheque = ReglementCheque::with(['cheque', 'compte', 'bene', 'service', 'RelChequeImages', 'reglementSiniAuto', 'reglementRdp', 'reglementFournisseur', 'reglementCltRistourne'])->get();
        $reglement_effet = ReglementEffet::with(['effet', 'effet_compte', 'bene', 'service', 'RelEffetImages', 'reglementEffetFournisseur'])->orderBy('created_at', 'desc')->get();
        $totalReglementCheque = ReglementCheque::count(); 
        $totalReglementEffet = ReglementEffet::count();
        $users = User::latest()->get();
        // $users = User::all();
        return view('dashboard.accueil', compact('users', 'reglement_cheque', 'reglement_effet','totalReglementCheque', 'totalReglementEffet') );
    }

    // =============
    public function fetchMonthlyReglementCheque()
{
    $reglement_cheque = ReglementCheque::selectRaw('MONTHNAME(date_reglement) as month, COUNT(*) as count')
        ->groupByRaw('MONTHNAME(date_reglement)')
        ->orderByRaw('STR_TO_DATE(CONCAT(MONTH(date_reglement), " 1"), "%m %d")')
        ->get();

    return response()->json($reglement_cheque);
}


    public function fetchMonthlyReglementEffet()
    {
        $reglement_effet = ReglementEffet::selectRaw('MONTHNAME(date_reglement) as month, COUNT(*) as count')
            ->groupByRaw('MONTHNAME(date_reglement)')
            ->orderByRaw('MONTH(date_reglement)')
            ->get();
    
        return response()->json($reglement_effet);
    }


    public function pieChart()
{
    $reglement_cheque_count = ReglementCheque::count();
    $reglement_effet_count = ReglementEffet::count();

    return response()->json([
        'labels' => ['Réglements Par Cheques', 'Réglements Par Effets'],
        'values' => [$reglement_cheque_count, $reglement_effet_count],
    ]);
}





    /** profile user */
     public function userProfile()
     {
        $id = Auth::user()->id;
      $users = User::find($id);
        return view('dashboard.profile', compact('users'));
    }

    /** teacher dashboard */
    // public function teacherDashboardIndex()
    // {
    //     return view('dashboard.teacher_dashboard');
    // }

    // /** student dashboard */
    // public function studentDashboardIndex()
    // {
    //     return view('dashboard.student_dashboard');
    // }


   
}
