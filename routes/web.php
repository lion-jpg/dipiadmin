<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Credencial;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\SaludController;

Route::get('/', function () {
    return redirect('/admin');
});
Route::get('/generar-credencial/{id}', [Credencial::class, 'generarCredencial'])->name('generar-credencial');