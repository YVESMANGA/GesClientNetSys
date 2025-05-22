<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VenteController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\DashboardController;
use App\Models\Fournisseur;
use App\Models\Produit;
use App\Models\Vente;
use Illuminate\Support\Facades\Route;




Route::get('/', function () {
    return view('welcome');
});



Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/// ==========================Both ========================

Route::get('/client/potentiel', [ClientController::class, 'list'])->name('clients.clientsp');





require __DIR__.'/auth.php';
require __DIR__.'/employe-auth.php';

