<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Exibe o formulário de cadastro de usuários
     */
    public function create() 
    {
        return view('users.create');
    }

    /**
     * Salvar o novo usuário no banco de dados com validação
     */
    public function store(Request $request)
    {
        // Validação dos campos de foromulário
        $dadosValidados = $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);
        

        // Persistência no banco de dados usando o ORM Eloquent
        User::create($dadosValidados);


        // Redirecionar para o painel administrativo com mensagem de sucesso
        return redirect('/admin')->with('sucesso', 'Usuário cadastrado com sucesso');
    }
}
