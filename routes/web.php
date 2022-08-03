<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('storage-link',function(){
    Artisan::call('storage:link');
});

#Auth
Route::post('/validar-login', [LoginController::class, 'login'])->name('validar_login');

#Para el administrador
Route::group(['middleware' => 'auth', 'prefix' => '/panel'], function () {

    #Para el administrador
    Route::controller(HomeController::class)
        ->group(function () {

        #Inicio
        Route::get('/', 'index')->name('panel');

    });

    #Usuarios
    Route::controller(UserController::class)
        ->group(function () {

        Route::get('/usuarios', 'index')->name('usuarios.index');
        Route::get('/usuarios/all', 'all')->name('usuarios.all');
        Route::post('/usuarios/create', 'create')->name('usuarios.create');
        Route::get('/usuarios/delete/{id}', 'delete')->name('usuarios.delete');
        Route::get('/usuarios/get/{id}', 'get')->name('usuarios.get');
        Route::get('/usuarios/edit/{id}', 'edit')->name('usuarios.edit');
        Route::post('/usuarios/update', 'update')->name('usuarios.update');

    });

    #servicios
    Route::controller(ServicioController::class)
        ->prefix('configuracion')->group(function () {

        Route::get('/servicios', 'index')->name('servicios.index');
        Route::get('/servicios/all', 'all')->name('servicios.all');
        Route::post('/servicios/create', 'create')->name('servicios.create');
        Route::get('/servicios/delete/{id}', 'delete')->name('servicios.delete');
        Route::get('/servicios/edit/{id}', 'edit')->name('servicios.edit');
        Route::post('/servicios/update', 'update')->name('servicios.update');

        Route::get('/tipos-de-servicios', 'indexTipos')->name('servicios.tipos.index');
        Route::get('/tipos-de-servicios/all', 'allTipos')->name('servicios.tipos.all');
        Route::post('/tipos-de-servicios/create', 'createTipos')->name('servicios.tipos.create');
        Route::get('/tipos-de-servicios/delete/{id}', 'deleteTipos')->name('servicios.tipos.delete');
        Route::get('/tipos-de-servicios/edit/{id}', 'editTipos')->name('servicios.tipos.edit');
        Route::post('/tipos-de-servicios/update', 'updateTipos')->name('servicios.tipos.update');

    });

    #Registro
    Route::controller(RegistroController::class)
        ->prefix('registro')->group(function () {

        Route::get('/servicios', 'servicios')->name('registro.servicios.index');
        Route::post('/servicios/create', 'serviciosCreate')->name('registro.servicios.create');

    });

});

