<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\TypeFormController;
use App\Http\Controllers\Setting;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AffectationController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\BeneCompteController;
use App\Http\Controllers\CheckAnnuleController;
use App\Http\Controllers\CheckbookController;
use App\Http\Controllers\CheckbookSerieController;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\CheckDebitController;
use App\Http\Controllers\CompagnieController;
use App\Http\Controllers\CompteDepenseController;
use App\Http\Controllers\CourtierController;
use App\Http\Controllers\Effet\CarnetEffetController;
use App\Http\Controllers\Effet\EffetAffectationController;
use App\Http\Controllers\Effet\EffetAnnuleController;
use App\Http\Controllers\Effet\EffetServiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReglementChequeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SousCompteController;
use App\Http\Controllers\Effet\EffetCompteController;
use App\Http\Controllers\Effet\EffetController;
use App\Http\Controllers\Effet\EffetDebitController;
use App\Http\Controllers\Effet\ReglementEffetController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** for side bar menu active */
if (!function_exists('set_active')) {
    function set_active($route)
    {
        if (is_array($route)) {
            return in_array(Request::path(), $route) ? 'Active' : '';
        }
        return Request::path() == $route ? 'Active' : '';
    }
}


Route::get('/', function () {
    return view('auth.login');
});


Route::group(['middleware' => 'auth'], function () {
    Route::get('accueil', function () {
        return view('accueil');
    })->middleware('checkUserStatus');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Auth::routes();

// ----------------------------login ------------------------------//
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
    Route::post('/change/password', 'changePassword')->name('change/password');
});

// ----------------------------- register -------------------------//

Route::middleware(['auth', 'role:responsable'])->group(function () {
}); // end group admin middleware


// -------------------------- main dashboard ----------------------//
Route::controller(HomeController::class)->group(function () {
    Route::get('/accueil', 'index')->middleware('auth')->name('accueil');
    Route::get('user/profile/page', 'userProfile')->middleware('auth')->name('user/profile/page');
    // Route::get('teacher/dashboard', 'teacherDashboardIndex')->middleware('auth')->name('teacher/dashboard');
    // Route::get('student/dashboard', 'studentDashboardIndex')->middleware('auth')->name('student/dashboard');

    Route::get('/fetch-monthly-reglement-cheque', 'fetchMonthlyReglementCheque')->middleware('auth')->name('fetch.reglement.cheque');
    Route::get('/fetch-monthly-reglement-effet', 'fetchMonthlyReglementEffet')->middleware('auth')->name('fetch.reglement.effet');
    Route::get('/pie-chart', 'pieChart')->middleware('auth')->name('pie.chart');
});

// ----------------------------- user controller -------------------------//


// ------------------------ setting -------------------------------//
// Route::controller(Setting::class)->group(function () {
//     Route::get('setting/page', 'index')->middleware('auth')->name('setting/page');
// });


// =============

Route::group(['middleware' => 'checkRole:Admin'], function () {
    // Routes accessible only for Admin
    // Add your routes here
});

Route::controller(UserManagementController::class)->group(function () {
    Route::get('/update-profile',  'profileUpdateForm')->middleware('auth')->name('update.profile.form');
    Route::post('/update-profile', 'updateProfile')->middleware('auth')->name('update.profile');
    Route::post('change/password', 'changePassword')->middleware('auth')->name('change/password');
});


Route::group(['middleware' => 'checkRole:Super Admin'], function () {

    Route::controller(CarnetEffetController::class,)->group(function () {
        Route::get('/tous/carnets-effets', 'AllCarnetsEffets')->name('all.carnets-effets');
        Route::get('/ajouter/carnet-effet', 'AddCarnetEffet')->name('add.carnet-effet');
        Route::post('/store/carnet-effet', 'StoreCarnetEffet')->name('store.carnet-effet');
        Route::get('/show/carnet-effet/{id}', 'ShowCarnetEffet')->name('show.carnet-effet');
        Route::get('/modifier/carnet-effet/{id}', 'EditCarnetEffet')->name('edit.carnet-effet');
        Route::post('/update/carnet-effet', 'UpdateCarnetEffet')->name('update.carnet-effet');
        Route::get('/supprimer/carnet-effet/{id}', 'DeleteCarnetEffet')->name('delete.carnet-effet');
    });
    Route::controller(EffetServiceController::class)->group(function () {
        Route::get('/tous/effet-services', 'AllEffetServices')->name('all.effet-services');
        Route::get('/ajouter/effet-service', 'AddEffetService')->name('add.effet-service');
        Route::post('/store/effet-service', 'StoreEffetService')->name('store.effet-service');
        Route::get('/modifier/effet-service/{id}', 'EditEffetService')->name('edit.effet-service');
        Route::post('/update/effet-service', 'UpdateEffetService')->name('update.effet-service');
        Route::get('/delete/effet-service/{id}', 'DeleteEffteService')->name('delete.effet-service');
    });
    Route::controller(EffetAffectationController::class)->group(function () {
        Route::get('/tous/effet-affectations', 'AllEffetAffectations')->name('all.effet-affectations');
        Route::get('/ajouter/effet-affectation', 'AddEffetAffectation')->name('add.effet-affectation');
        Route::post('/store/effet-affectation', 'StoreEffetAffectation')->name('store.effet-affectation');
        Route::get('/modifier/effet-affectation/{id}', 'EditEffetAffectation')->name('edit.effet-affectation');
        Route::post('/update/effet-affectation', 'UpdateEffetAffectation')->name('update.effet-affectation');
        Route::get('/delete/effet-affectation/{id}', 'DeleteEffetAffectation')->name('delete.effet-affectation');

        Route::get('/show/effet-affectation/{id}', 'ShowEffetAffectation')->name('show.effet-affectation');
    });

    Route::controller(EffetCompteController::class)->group(function () {
        Route::get('/tous/compte-effets', 'AllCompteEffets')->name('all.compte-effets');
        Route::get('/ajouter/compte-effet', 'AddCompteEffet')->name('add.compte-effet');
        Route::post('/store/compte-effet', 'StoreCompteEffet')->name('store.compte-effet');
        Route::get('/modifier/compte-effet/{id}', 'EditCompteEffet')->name('edit.compte-effet');
        Route::post('/update/compte-effet', 'UpdateCompteEffet')->name('update.compte-effet');
        Route::get('/delete/compte-effet/{id}', 'DeleteCompteEffet')->name('delete.compte-effet');
    });

    Route::controller(ReglementEffetController::class)->group(function () {
        Route::get('/tous/reglement-effets', 'AllReglementEffets')->name('all.reglement-effets');
        Route::get('/ajouter/reglement-effet', 'AddReglementEffet')->name('add.reglement-effet');
        Route::post('/store/reglement-effet', 'StoreReglementEffet')->name('store.reglement-effet');
        Route::get('/modifier/reglement-effet/{id}', 'EditReglementEffet')->name('edit.reglement-effet');
        Route::post('/update/reglement-effet/{id}', 'UpdateReglementEffet')->name('update.reglement-effet');
        Route::get('/delete/reglement-effet/{id}', 'DeleteReglementEffet')->name('delete.reglement-effet');
        Route::get('/show/reglement-effet/{id}', 'ShowReglementEffet')->name('show.reglement-effet');
        // Route::get('/ajouter/reglement-cheque-test', 'testFunction')->name('ajouter.reglement-cheque-test');
        
        Route::get('/download-reglement-effet-pdf/{id}', 'generateReglementEffetPDF')->name('download.reglement.effet.pdf');

        // Route::get('/checkIfEffetSelected', 'checkIfEffetSelected')->name('checkIfEffetSelected');
    });

    Route::controller(EffetAnnuleController::class)->group(function () {
        Route::get('/all/effets-cancelled', 'all_effets_annule')->name('all.effets-cancelled');
        Route::get('/add/effet-cancelled', 'addEffetAnnule')->name('add.effet-cancelled');
        Route::post('/store/effet-cancelled', 'store_effets_annule')->name('store.effet-cancelled');
        Route::get('/edit/effet-cancelled/{id}', 'edit_effets_annule')->name('edit.effet-cancelled');
        Route::post('/update/effet-cancelled/{id}', 'update_effets_annule')->name('update.effet-cancelled');
        Route::get('/show/effet-cancelled/{id}', 'show_effets_annule')->name('show.effet-cancelled');
    });

    Route::controller(EffetDebitController::class)->group(function () {
        Route::get('/all/effets-debit', 'all_effets_debit')->name('all.effets-debit');
        Route::get('/add/effet-debit', 'add_effets_debit')->name('add.effet-debit');
        Route::post('/store/effet-debit', 'store_effets_debit')->name('store.effet-debit');
        Route::get('/edit/effet-debit/{id}', 'edit_effets_debit')->name('edit.effet-debit');
        Route::post('/update/effet-debit/{id}', 'update_effet_debit')->name('update.effet-debit');
        Route::get('/show/effet-debit/{id}', 'show_effet_debit')->name('show.effet-debit');
    });


    Route::controller(EffetController::class)->group(function () {
        Route::post('/add/fillEffets/{id}', 'FillEffets')->name('add.fillEffets');
        Route::get('/all/Effets-non-consommes', 'get_effet_non_consommes')->name('all.effets-non-consommes');
        // Route::get('/add/effet-cancelled', 'add_effets_annule')->name('add.effet-cancelled');
    });

    // ============ Chéquier Routes =========== // 


    Route::controller(CheckbookController::class,)->group(function () {
        Route::get('/tous/checkbooks', 'AllCheckbooks')->name('all.checkbooks');
        Route::get('/ajouter/checkbook', 'AddCheckbook')->name('add.checkbook');
        Route::post('/store/checkbook', 'StoreCheckbook')->name('store.checkbook');
        Route::get('/show/checkbook/{id}', 'ShowCheckbook')->name('show.checkbook');
        Route::get('/modifier/checkbook/{id}', 'EditCheckbook')->name('edit.checkbook');
        Route::post('/update/checkbook', 'UpdateCheckbook')->name('update.checkbook');
        Route::get('/supprimer/checkbook/{id}', 'DeleteCheckbook')->name('delete.checkbook');
    });


    Route::controller(CheckController::class)->group(function () {
        Route::post('/add/fillChecks/{id}', 'FillChecks')->name('add.fillChecks');
        Route::get('/all/checks-non-consommes', 'get_cheque_non_consommes')->name('all.checks-non-consommes');
        Route::get('/add/check-cancelled', 'add_cheques_annule')->name('add.check-cancelled');
    });

    Route::controller(CheckAnnuleController::class)->group(function () {
        Route::get('/all/checks-cancelled', 'all_cheques_annule')->name('all.checks-cancelled');
        Route::get('/add/check-cancelled', 'add_cheques_annule')->name('add.check-cancelled');
        Route::post('/store/check-cancelled', 'store_cheques_annule')->name('store.check-cancelled');
        Route::get('/edit/check-cancelled/{id}', 'edit_cheques_annule')->name('edit.check-cancelled');
        Route::post('/update/check-cancelled/{id}', 'update_cheques_annule')->name('update.check-cancelled');
        Route::get('/show/check-cancelled/{id}', 'show_cheque_annule')->name('show.check-cancelled');
    });

    Route::controller(CheckDebitController::class)->group(function () {
        Route::get('/all/checks-debit', 'all_cheques_debit')->name('all.checks-debit');
        Route::get('/add/check-debit', 'add_cheques_debit')->name('add.check-debit');
        Route::post('/store/check-debit', 'store_cheques_debit')->name('store.check-debit');
        Route::get('/edit/check-debit/{id}', 'edit_cheques_debit')->name('edit.check-debit');
        Route::post('/update/check-debit/{id}', 'update_cheque_debit')->name('update.check-debit');
        Route::get('/show/check-debit/{id}', 'show_cheque_debit')->name('show.check-debit');
    });

    Route::controller(CheckbookSerieController::class)->group(function () {
        Route::post('/add/fillCheckbookSerie/{id}', 'FillCheckbookSerie')->name('add.fillCheckbookSerie');
    });



    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'register')->name('register');
        Route::post('/register-post', 'storeUser')->name('register');
    });


    Route::controller(UserManagementController::class)->group(function () {
        Route::get('liste/utilisateurs', 'index')->middleware('auth')->name('all.users');
        Route::get('/ajouter/utilisateur', 'userAdd')->name('add.user');
        Route::post('/store/utilisateur', 'userStore')->name('store.user');
        Route::get('view/user/edit/{id}', 'userView')->middleware('auth');
        Route::post('user/update', 'userUpdate')->name('user/update');
        Route::post('user/delete', 'userDelete')->name('user/delete');
    });

    // ------------------------ compagnies -------------------------------//

    Route::controller(CompagnieController::class)->group(function () {
        Route::get('/tous/compagnies', 'AllCompagnies')->name('all.compagnies');
        Route::get('/ajouter/compagnie', 'AddCompagnie')->name('add.compagnie');
        Route::post('/store/compagnie', 'StoreCompagnie')->name('store.compagnie');
        Route::get('/modifier/compagnie/{id}', 'EditCompagnie')->name('edit.compagnie');
        Route::post('/update/compagnie', 'UpdateCompagnie')->name('update.compagnie');
        Route::get('/delete/compagnie/{id}', 'DeleteCompagnie')->name('delete.compagnie');
    });

    Route::controller(BankController::class)->group(function () {
        Route::get('/tous/banques', 'AllBanks')->name('all.banks');
        Route::get('/ajouter/banque', 'AddBank')->name('add.bank');
        Route::post('/store/banque', 'StoreBank')->name('store.bank');
        Route::get('/modifier/banque/{id}', 'EditBank')->name('edit.bank');
        Route::post('/update/banque', 'UpdateBank')->name('update.bank');
        Route::get('/delete/banque/{id}', 'DeleteBank')->name('delete.bank');
    });

    Route::controller(ServiceController::class)->group(function () {
        Route::get('/tous/services', 'AllServices')->name('all.services');
        Route::get('/ajouter/service', 'AddService')->name('add.service');
        Route::post('/store/service', 'StoreService')->name('store.service');
        Route::get('/modifier/service/{id}', 'EditService')->name('edit.service');
        Route::post('/update/service', 'UpdateService')->name('update.service');
        Route::get('/delete/service/{id}', 'DeleteService')->name('delete.service');
    });

    Route::controller(CourtierController::class)->group(function () {
        Route::get('/tous/courtiers', 'AllCourtiers')->name('all.courtiers');
        Route::get('/ajouter/courtier', 'AddCourtier')->name('add.courtier');
        Route::post('/store/courtier', 'StoreCourtier')->name('store.courtier');
        Route::get('/modifier/courtier/{id}', 'EditCourtier')->name('edit.courtier');
        Route::post('/update/courtier', 'UpdateCourtier')->name('update.courtier');
        Route::get('/delete/courtier/{id}', 'DeleteCourtier')->name('delete.courtier');
    });

    Route::controller(AffectationController::class)->group(function () {
        Route::get('/tous/affectations', 'AllAffectations')->name('all.affectations');
        Route::get('/ajouter/affectation', 'AddAffectation')->name('add.affectation');
        Route::post('/store/affectation', 'StoreAffectation')->name('store.affectation');
        Route::get('/modifier/affectation/{id}', 'EditAffectation')->name('edit.affectation');
        Route::post('/update/affectation', 'UpdateAffectation')->name('update.affectation');
        Route::get('/delete/affectation/{id}', 'DeleteAffectation')->name('delete.affectation');

        Route::get('/show/affectation/{id}', 'ShowAffectation')->name('show.affectation');
    });

    Route::controller(SousCompteController::class)->group(function () {
        Route::get('/tous/sous-comptes', 'AllSousComptes')->name('all.sous-comptes');
        Route::get('/ajouter/sous-compte', 'AddSousCompte')->name('add.sous-compte');
        Route::post('/store/sous-compte', 'StoreSousCompte')->name('store.sous-compte');
        Route::get('/modifier/sous-compte/{id}', 'EditSousCompte')->name('edit.sous-compte');
        Route::post('/update/sous-compte', 'UpdateSousCompte')->name('update.sous-compte');
        Route::get('/delete/sous-compte/{id}', 'DeleteSousCompte')->name('delete.sous-compte');
    });

    Route::controller(CompteDepenseController::class)->group(function () {
        Route::get('/tous/compte-depenses', 'AllCompteDepenses')->name('all.compte-depenses');
        Route::get('/ajouter/compte-depense', 'AddCompteDepense')->name('add.compte-depense');
        Route::post('/store/compte-depense', 'StoreCompteDepense')->name('store.compte-depense');
        Route::get('/modifier/compte-depense/{id}', 'EditCompteDepense')->name('edit.compte-depense');
        Route::post('/update/compte-depense', 'UpdateCompteDepense')->name('update.compte-depense');
        Route::get('/delete/compte-depense/{id}', 'DeleteCompteDepense')->name('delete.compte-depense');
    });


    Route::controller(BeneCompteController::class)->group(function () {
        Route::get('/tous/bene-comptes', 'AllBeneComptes')->name('all.bene-comptes');
        Route::get('/ajouter/bene-compte', 'AddBeneCompte')->name('add.bene-compte');
        Route::post('/store/bene-compte', 'StoreBeneCompte')->name('store.bene-compte');
        Route::get('/modifier/bene-compte/{id}', 'EditBeneCompte')->name('edit.bene-compte');
        Route::post('/update/bene-compte', 'UpdateBeneCompte')->name('update.bene-compte');
        Route::get('/delete/bene-compte/{id}', 'DeleteBeneCompte')->name('delete.bene-compte');
    });

    Route::controller(ReglementChequeController::class)->group(function () {
        Route::get('/tous/reglement-cheques', 'AllReglementCheques')->name('all.reglement-cheques');
        Route::get('/ajouter/reglement-cheque', 'AddReglementCheque')->name('add.reglement-cheque');
        Route::post('/store/reglement-cheque', 'StoreReglementCheque')->name('store.reglement-cheque');
        Route::get('/modifier/reglement-cheque/{id}', 'EditReglementCheque')->name('edit.reglement-cheque');
        Route::post('/update/reglement-cheque/{id}', 'UpdateReglementCheque')->name('update.reglement-cheque');
        Route::get('/delete/reglement-cheque/{id}', 'DeleteReglementCheque')->name('delete.reglement-cheque');
        Route::get('/show/reglement-cheque/{id}', 'ShowReglementCheque')->name('show.reglement-cheque');
        // Route::get('/ajouter/reglement-cheque-test', 'testFunction')->name('ajouter.reglement-cheque-test');
        
        Route::get('/download-reglement-pdf/{id}', 'generateReglementChequePDF')->name('download.reglement.pdf');

        Route::get('/checkIfChequeSelected', 'checkIfChequeSelected')->name('checkIfChequeSelected');
    });
});
