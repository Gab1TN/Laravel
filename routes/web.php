<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FavorisController;
use App\Http\Controllers\MonCompteController;
use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\DeposerBienController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Validator;

// Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// Routes d'authentification
Auth::routes();
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// Routes pour les favoris
Route::post('/favoris/ajouter/{bienImmoId}', [FavorisController::class, 'ajouter'])->name('favoris.ajouter');
Route::post('/favoris/supprimer/{bienImmoId}', [FavorisController::class, 'supprimer'])->name('favoris.supprimer');

// Routes pour le compte utilisateur
Route::get('/moncompte', [MonCompteController::class, 'index'])->name('moncompte');
Route::put('/moncompte/{id}', [MonCompteController::class, 'update'])->name('moncompte.update');

// Route pour afficher une annonce
Route::get('/annonce/{id}', [AnnonceController::class, 'show'])->name('annonce.show');

// Routes pour déposer un bien immobilier
Route::get('/deposer-bien', [DeposerBienController::class, 'index'])->name('deposer_bien');
Route::post('/deposer-bien', [DeposerBienController::class, 'store'])->name('deposer_bien.store');

// Route pour effectuer une recherche
Route::get('/annonces/search', [AnnonceController::class, 'search'])->name('annonces.search');

// Route pour la page de contact
Route::get('/contact', [ContactController::class, 'showForm'])->name('contact.showForm');
Route::post('/contact/send', [ContactController::class, 'sendEmail'])->name('contact.send');

// Route pour la page qui sommes nous ?
Route::get('/about', function () {
    return view('about');
})->name('about');

// Route de test message d'erreur en FR
Route::get('/test-validation', function () {
    $validator = Validator::make([], [
        'test' => 'required',
    ]);

    return $validator->errors()->first('test');
});
