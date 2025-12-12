<?php

use App\Http\Controllers\Dashboard\CatalogoProdutosController;
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


Route::get('/catalogo/produtos', [CatalogoProdutosController::class, 'getProdutos'])->name('catalogo.produtos');
Route::post('/catalogo/categorias', [CategoriaController::class, 'getCategorias'])->name('catalogo.categorias');



// CATALOGO DE PRODUTOS

Route::prefix("catalogo/")->group(function () {
    Route::post('/produto/variacao', [ProdutoController::class, 'getVariacao'])->name('catalogo.variacao');
    Route::post('/produto/deleteopcao', [ProdutoController::class, 'deleteOpcao'])->name('catalogo.deleteOpcao');
    Route::post('/produto/deletevariacao', [ProdutoController::class, 'deleteVariacao'])->name('catalogo.deleteVariacao');
    Route::post('/produto/setproduto', [ProdutoController::class, 'setProduto'])->name('catalogo.setProduto');
});
