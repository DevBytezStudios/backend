<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\PedidoController;
use App\Http\Controllers\Dashboard\CatalogoController;
use App\Http\Controllers\Dashboard\CategoriaController;
use App\Http\Controllers\Dashboard\ConfeitariaController;
use App\Http\Controllers\Dashboard\EncomendaController;
use App\Http\Controllers\Dashboard\EstiloController;
use App\Http\Controllers\Dashboard\EtapaController;
use App\Http\Controllers\Dashboard\EtapaOpcaoController;
use App\Http\Controllers\Dashboard\ProdutoController;
use App\Http\Middleware\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [CatalogoController::class, 'dashboard'])->name('dashboard')->middleware(Auth::class);

Route::get('/informacoes', function () {
    return Inertia::render('Informacoes');
})->name('informacoes')->middleware(Auth::class);

Route::post('/informacoes/setinfo', [ConfeitariaController::class, 'setInfo'])->middleware(Auth::class);

// CATALOGO DE PRODUTOS
Route::prefix("catalogo/")->group(function () {
    // CONFIGURAÇÂO DOS PRODUTOS
    Route::get('/produtos', [CatalogoController::class, 'getProdutos'])->name('catalogo.produtos');

    Route::post('/categorias', [CategoriaController::class, 'getCategorias'])->name('catalogo.produtoCategorias');

    Route::post('/produto/variacao', [ProdutoController::class, 'getVariacao'])->name('catalogo.variacao');

    Route::post('/produto/deleteopcao', [ProdutoController::class, 'deleteOpcao'])->name('catalogo.deleteOpcao');

    Route::post('/produto/deletevariacao', [ProdutoController::class, 'deleteVariacao'])->name('catalogo.deleteVariacao');

    Route::post('/produto/deleteproduto', [ProdutoController::class, 'deleteProduto'])->name('catalogo.deleteProduto');

    Route::post('/produto/setproduto', [ProdutoController::class, 'setProduto'])->name('catalogo.setProduto');

    Route::post('/produto/search', [ProdutoController::class, 'search'])->name('catalogo.searchProduto');

    // CONFIGURAÇÂO DOS PEDIDOS
    Route::get('/pedidos', [CatalogoController::class, "getPedidos"])->name('catalogo.pedidos');

    Route::post('/pedidos/updatestatus', [PedidoController::class, "setStatus"])->name('catalogo.pedidosStatus');

    Route::post('/pedidos/delete', [PedidoController::class, "deletePedido"])->name('catalogo.deletePedido');

    Route::post('/pedidos/search', [PedidoController::class, "search"])->name('catalogo.searchPedido');

    // CONFIGURAÇÂO DAS CATEGORIAS
    Route::get('/categorias', [CatalogoController::class, "getCategorias"])->name('catalogo.categorias');

    Route::post('/categorias/setcategoria', [CategoriaController::class, "setCategoria"])->name('catalogo.setCategoria');

    Route::post('/categorias/delete', [CategoriaController::class, 'deleteCategoria'])->name('catalogo.deleteCategoria');
})->middleware(Auth::class);

// CONFIGURAÇÔES DE ENCOMENDA
Route::prefix("encomenda/")->group(function () {
    // ETAPAS
    Route::get('/etapas', [EtapaController::class, 'getEtapas'])->name('encomenda.etapas');

    Route::post('/etapas/setetapa', [EtapaController::class, 'setEtapa'])->name('encomenda.setEtapa');

    Route::post('/etapas/setordem', [EtapaController::class, 'setOrdem'])->name('encomenda.setOrdem');

    Route::post('/etapas/delete', [EtapaController::class, 'delete'])->name('encomenda.delete');

    // OPCOES
    Route::get('/opcoes', [EtapaOpcaoController::class, 'getOpcoes'])->name('encomenda.opcoes');

    Route::get('/opcoes/getetapas', [EtapaOpcaoController::class, 'getEtapas'])->name('encomenda.getEtapas');

    Route::post('/opcoes/setopcao', [EtapaOpcaoController::class, 'setOpcao'])->name('encomenda.setOpcao');

    Route::post('/opcoes/search', [EtapaOpcaoController::class, 'search'])->name('opcoes.search');

    Route::post('/opcoes/delete', [EtapaOpcaoController::class, 'delete'])->name('opcoes.delete');


    // ESTILOS
    Route::get('/estilos', [EstiloController::class, 'getEstilos'])->name('encomenda.estilos');

    Route::post('/estilos/setestilo', [EstiloController::class, 'setEstilo'])->name('encomenda.setEstilo');

    Route::post('/estilos/delete', [EstiloController::class, 'delete'])->name('encomenda.estiloDelete');


    // ENCOMENDAS
    Route::get('/encomendas', [EncomendaController::class, 'getEncomendas'])->name('encomenda.getEncomendas');

    Route::post('/updatestatus', [EncomendaController::class, 'updateStatus'])->name('encomenda.updatestatus');

    Route::post('/delete', [EncomendaController::class, 'deleteEncomenda'])->name('encomenda.delete');

    Route::post('/search', [EncomendaController::class, 'search'])->name('encomenda.search');
})->middleware(Auth::class);


// AUTH
Route::prefix("auth/")->group(function () {
    Route::post('/login', [LoginController::class, "authenticate"])->name('auth.login');
    Route::get('/login', function () {
        return Inertia::render('auth/Login');
    })->name('auth.loginForm');
    Route::get('/logout', [LoginController::class, "logout"])->name('login.logout');
});
