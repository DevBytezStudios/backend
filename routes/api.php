<?php

use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\ConfeitariaController;
use App\Http\Controllers\Api\EncomendaController;
use App\Http\Controllers\Api\PedidoController as ApiPedidoController;
use App\Http\Controllers\API\ProdutoController;
use App\Models\Confeitaria;
use App\Models\Encomenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::prefix('{slug}/')->group(function () {
    //CATALOGO DE PRODUTOS
    Route::get('index', [ConfeitariaController::class, 'index']);
    Route::get('{idcat}/produtos', [ConfeitariaController::class, 'getProdutos']);
    Route::get('{idproduto}/produto', [ProdutoController::class, 'getProduto']);
    Route::post('newpedido', [ApiPedidoController::class, 'setPedido']);

    // ENCOMENDAS
    Route::get('encomenda', [ConfeitariaController::class, 'getEtapas']);
    Route::post('encomenda/{idetapa}', [ConfeitariaController::class, 'getOpcoes'])->name('encomenda.getOpcoes');
    Route::get('encomenda/estilos', [ConfeitariaController::class, 'getEstilos']);
    Route::post('newencomenda', [EncomendaController::class, 'setEncomenda']);
    Route::get('encomenda/blockdates',[ConfeitariaController::class,'getBlockDates']);
    Route::get('encomenda/checkdate/{date}',[EncomendaController::class,'checkDate'])->name('encomenda.checkdate');
});

// PEGAR VARIACAO DOS PRODUTOS
Route::post('/produto/getvariacao', [ProdutoController::class, 'geVariacao']);

// CONFIGURAÇÔES PARA OS ADMINISTRADORES
Route::prefix('/admin')->group(function () {
    Route::get('/getconfeitaria', [AdminController::class, 'getConfeitarias']);
    Route::post('/setconfeitaria', [AdminController::class, 'setConfeitaria']);
    Route::post('/deleteconfeitaria', [AdminController::class, 'deleteConfeitaria']);
});