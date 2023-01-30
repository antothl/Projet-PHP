<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

//Compte
Route::get('compte', function () {
    return view('compte/compte');
});

//Commune
Route::get('commune', function () {
    return view('commune/commune');
});


//Activités
Route::get('script_inscription', function () {
    return view('activite/script_inscription');
});

Route::get('script_desinscription', function () {
    return view('activite/script_desinscription');
});

//Associations
Route::get('script_adhesion', function () {
    return view('association/script_adhesion');
});

Route::get('script_desadhesion', function () {
    return view('association/script_desadhesion');
});


use App\Http\Controllers\ActiviteController;
Route::get('activite/{activite?}/inscrit', [ActiviteController::class, 'inscrit'])->name('activite.inscrit');
Route::get('activite/{activite?}/inscription', [ActiviteController::class, 'inscription'])->name('activite.inscription');
Route::get('activite/{activite?}/inscription_admin', [ActiviteController::class, 'inscription_admin'])->name('activite.inscription_admin');
Route::resource('activite', ActiviteController::class);


use App\Http\Controllers\UserController;
Route::get('user/{user?}/enfant', [UserController::class, 'enfant'])->name('user.enfant');
Route::resource('user', UserController::class);


use App\Http\Controllers\EnfantController;
Route::get('enfant/{enfant?}/inscrit', [EnfantController::class, 'inscrit'])->name('enfant.inscrit');
Route::resource('enfant', EnfantController::class);


use App\Http\Controllers\CompteController;
Route::get('compte/compte_enfant/{compte_enfant?}/inscrit', [CompteController::class, 'inscrit'])->name('compte/compte_enfant.inscrit');
Route::resource('compte/compte_enfant', CompteController::class);


use App\Http\Controllers\AssociationController;
Route::get('association/{association?}/activite', [AssociationController::class, 'activite'])->name('association.activite');
Route::get('association/{association?}/adherant', [AssociationController::class, 'adherant'])->name('association.adherant');
Route::resource('association', AssociationController::class);


Route::fallback(function () {
    return view('error');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('index');
    })->name('/');
});