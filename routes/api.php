<?php

use App\Http\Controllers\API\ConfeitariaController;
use App\Http\Controllers\Api\PedidoController as ApiPedidoController;
use App\Http\Controllers\API\ProdutoController;
use App\Models\Confeitaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('{slug}/')->group(function () {
    Route::get('index', [ConfeitariaController::class, 'index']);
    Route::get('{idcat}/produtos', [ConfeitariaController::class, 'getProdutos']);
    Route::get('{idproduto}/produto', [ProdutoController::class, 'getProduto']);
    Route::post('/newpedido', [ApiPedidoController::class, 'setPedido']);
});

Route::post('/produto/getvariacao', [ProdutoController::class, 'geVariacao']);
