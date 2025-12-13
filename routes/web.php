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

// CATALOGO DE PRODUTOS
Route::prefix("catalogo/")->group(function () {
    // CONFIGURAÇÂO DOS PRODUTOS
    Route::get('/produtos', [CatalogoProdutosController::class, 'getProdutos'])->name('catalogo.produtos');
    Route::post('/categorias', [CategoriaController::class, 'getCategorias'])->name('catalogo.categorias');
    Route::post('/produto/variacao', [ProdutoController::class, 'getVariacao'])->name('catalogo.variacao');
    Route::post('/produto/deleteopcao', [ProdutoController::class, 'deleteOpcao'])->name('catalogo.deleteOpcao');
    Route::post('/produto/deletevariacao', [ProdutoController::class, 'deleteVariacao'])->name('catalogo.deleteVariacao');
    Route::post('/produto/deleteproduto', [ProdutoController::class, 'deleteProduto'])->name('catalogo.deleteProduto');
    Route::post('/produto/setproduto', [ProdutoController::class, 'setProduto'])->name('catalogo.setProduto');
    Route::post('/produto/search', [ProdutoController::class, 'search'])->name('catalogo.searchProduto');

    // CONFIGURAÇÂO DOS PEDIDOS
    Route::get('/pedidos', function () {
        return Inertia::render('catalogo/Pedidos');
    })->name('catalogo.pedidos');
});
