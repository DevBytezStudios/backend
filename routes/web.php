<?php

use App\Http\Controllers\Dashboard\CategoriaController;
use App\Http\Controllers\Dashboard\ConfeitariaController;
use App\Http\Controllers\Dashboard\ProdutoController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::get('/informacoes', function () {
    return Inertia::render('Informacoes');
})->name('dashboard');


Route::get('/catalogo/produtos',[ConfeitariaController::class,'index'])->name('catalogo.produtos');
Route::post('/catalogo/categorias',[CategoriaController::class,'getCategorias'])->name('catalogo.categorias');



// EDIÇÔES DO PRODUTO - TRANSFORMAR EM GROUP DEPOIS
Route::post('/catalogo/produto/variacao',[ProdutoController::class,'getVariacao'])->name('catalogo.variacao');
Route::post('/catalogo/produto/deleteopcao',[ProdutoController::class,'deleteOpcao'])->name('catalogo.deleteOpcao');
Route::post('/catalogo/produto/deletevariacao',[ProdutoController::class,'deleteVariacao'])->name('catalogo.deleteVariacao');
Route::post('/catalogo/produto/setproduto',[ProdutoController::class,'setProduto'])->name('catalogo.setProduto');



