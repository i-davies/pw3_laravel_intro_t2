<?php

use App\Models\User;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('home');
});

Route::view('/landing', 'landing');

// Rota da listagem e painel administrativo (GET)
Route::get('/admin', [UserController::class, 'index']);

// Rota para carregar o formulário (GET)
Route::get('/usuarios/novo', [UserController::class, 'create']);

// Rota para salvar os dados enviados (POST)
Route::post('/usuarios', [UserController::class, 'store']);

// Rotas de edição e atulização
Route::get('/usuarios/{id}/editar', [UserController::class, 'edit']);
Route::put('/usuarios/{id}', [UserController::class, 'update']);


// Rota de exclusão (DELETE)
Route::delete('/usuarios/{id}', [UserController::class, 'destroy']);

Route::get('/produtos', [ProdutoController::class , 'index']);
Route::post('/produtos', [ProdutoController::class , 'store']);

Route::get('/teste-orm', function() {
    User::create([
        'name' => 'Icaro Davies',
        'email' => 'icaro.davies@escola.sp.gov.br',
        'password' => '12345678',
    ]);

    return User::all();
});

Route::get('/lab-seguranca', function (Request $request) {
    $termo = $request->query('busca', '');

    $resultadoVulneravel = [];
    $erroVulneravel = null;

    // 1. Simulação didática com falha (cancatenada propositalmente para teste)
    if ($termo !== '') {
        try {
            $resultadoVulneravel = DB::select("SELECT id, name, email FROM users WHERE name = '$termo'");
        } catch (\Exception $e) {
            $erroVulneravel = $e->getMessage();
        }
    }
});