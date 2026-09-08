<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * Exibe a listagem de usuários com suporte a filtro de busca
     */
    public function index(Request $request)
    {
        // Captura o termo de busca enviado pelo GET
        $busca = $request->input('busca');

        // Se houver busca, filtra pro nome; caso contrário, busca todos ordernados por nome
        if ($busca){
            $usuarios = User::where('name', 'like', "%{$busca}%", 'and')
                ->orderBy('name', 'ASC')
                ->get();
            // select * from user where name = 'ana'
            // select * from user where name like '%ana%'
        } else {
            $usuarios = User::orderBy('name', 'ASC')->get();
        }

        // Retorna a view do painel passando a coleção de usuários e o termo de pesquisa
        return view('admin.dashboard', compact('usuarios', 'busca'));

    }

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
