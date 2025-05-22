<?php


use App\Http\Controllers\Employe\Auth\RegisteredUserController;
use App\Http\Controllers\Employe\Auth\LoginController;
use App\Http\Controllers\Employe\Dashboard\ValiderController;
use App\Models\Produit;
use App\Models\Vente;
use Illuminate\Support\Facades\Route;

Route::prefix('employe')->middleware('guest:employe')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [LoginController::class, 'create'])->name('employe.loginP');
    Route::post('login', [LoginController::class, 'store'])->name('employe.connexion');
  
});

Route::prefix('employe')->middleware('auth:employe')->group(function () {

    Route::get('/dashboard', function () {
       
        return view('employe.dashboard');
    })->name('employe.dashboard');
 
    Route::post('logout', [LoginController::class, 'destroy'])
        ->name('employe.logout');




   

});
