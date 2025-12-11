<?php

use App\Http\Controllers\Dashboard\ConfeitariaController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::get('/informacoes', function () {
    return Inertia::render('Informacoes');
})->name('dashboard');


Route::get('/catalogo/produtos',[ConfeitariaController::class,'index'])->name('dashboard.produtos');


