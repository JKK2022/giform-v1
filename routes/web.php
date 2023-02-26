<?php

use App\Http\Livewire\Utilisateurs;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\Roles\RoleList;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Metiers\MetierList;
use App\Http\Livewire\Modules\ModuleList;
use App\Http\Livewire\Filieres\FiliereList;
use App\Http\Livewire\Services\ServicesList;
use App\Http\Livewire\Motifs\MotifPaiementsList;
use App\Http\Livewire\Permission\PermissionList;
use App\Http\Livewire\Stagiaires\StagiairesList;
use App\Http\Livewire\Typestagiaires\TypeStagiaireList;
use App\Http\Livewire\Typesformations\TypeFormationList;

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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Le groupe des routes relatives aux administrateurs uniquement
Route::group(["middleware" => ["auth","auth.isAdmin"],"as" => "admin."],function(){

    // Route relative à la gestion des habilitations
    Route::group(["prefix" => "habilitations","as" => "habilitations."],function(){
        Route::get('/utilisateurs', Utilisateurs::class, 'index')->name('users.index');
        Route::get('/roles', RoleList::class, 'index')->name('roles.index');
        Route::get('/permissions', PermissionList::class, 'index')->name('permissions.index');
    });

});


// Le groupe des routes relatives aux conseillers uniquement
Route::group(["middleware" => ["auth","auth.isCfip"],"as" => "conseillers."],function(){

    // Route relative à la gestion des formations
    Route::group(["prefix" => "parametres","as" => "parametres."],function(){
        Route::get('/services', ServicesList::class, 'index')->name('services.index');
    });

    // Route relative à la gestion des stagiaires
    Route::group(["prefix" => "geststagiaires","as" => "geststagiaires."],function(){
        Route::get('/stagiaires', StagiairesList::class, 'index')->name('stagiaires.index');
        Route::get('/typestagiaires', TypeStagiaireList::class, 'index')->name('typestagiaires.index');
    });

    // Route relative à la gestion des formations
    Route::group(["prefix" => "gestformations","as" => "gestformations."],function(){
        Route::get('/filieres', FiliereList::class, 'index')->name('filieres.index');
        Route::get('/typesformations', TypeFormationList::class, 'index')->name('typesformations.index');
        Route::get('/metiers', MetierList::class, 'index')->name('metiers.index');
        Route::get('/modules', ModuleList::class, 'index')->name('modules.index');
    });

    Route::group(["prefix" => "gestpaiements","as" => "gestpaiements."],function(){
        Route::get('/motifs', MotifPaiementsList::class, 'index')->name('motifs.index');
        // Route::get('/frais', StagiairesList::class, 'index')->name('frais.index');
    });

});
