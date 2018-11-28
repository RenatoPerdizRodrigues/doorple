<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
use Session;

//Classe de funções de CRUD de criação de um novo usuário
class UserController extends Controller
{
    //Construct que permite acesso apenas a administradores logados
    public function __construct(){
        $this->middleware('auth:admin');
    }

    //Função de acesso ao index de todos os usuários cadastrados
    public function index(){
        $users = User::all();
        return view('admin.user-creation.index')->withUsers($users);
    }

    //Mostra o formulário de criação de novos usuários
    public function create()
    {
        return view('admin.user-creation.create');
    }

    //Salva o novo usuário no banco de dados
    public function store(Request $request)
    {
        //Validação de dados do formulário
        $this->validate($request, array(
            'name' => 'required|min:3|max:35',
            'email' => 'required|email',
            'password' => 'required|min:6|same:password-confirmation'
        ));

        //Criação do modelo e save das mudanças
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        //Criação de mensagem de sucesso
        Session::flash('success', 'Usuário cadastrado com sucesso!');

        //Redirecionamento
        return redirect()->route('usr.index');
    }

    //Busca um usuário e redireciona para a página de show
    public function search(Request $request)
    {   
        $user = User::where('email', $request->email)->get();
        return redirect()->route('usr.show', $user[0]->id);
    }

    //Mostra um usuário
    public function show($id)
    {
        $user = User::find($id);
        return view('admin.user-creation.show')->withUser($user);
    }

    //Mostra formulário de edição de usuário
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.user-creation.edit')->withUser($user);
    }

    //Salva as alterações da edição
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $this->validate($request, array(
            'name' => 'required|min:5|max:35',
            'email' => 'required|email',
            'password' => 'nullable|min:6|same:password-confirmation',
            'password-confirmation' => 'nullable|min:6|same:password'
        ));

        $user->name = $request->name;
        $user->email = $request->email;
        //Verifica se a senha foi alterada
        $user->email = $request->email;
        if (!empty($user->password)){
            $user->password = Hash::make($request->password);
        }
        $user->save();

        //Criação de mensagem de sucesso
        Session::flash('success', 'Usuário editado com sucesso!');

        return redirect()->route('usr.show', $user->id);
    }

    public function delete($id){
        $user = User::find($id);
        return view('admin.user-creation.delete')->withUser($user);
    }

    //Deleta o usuário
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        //Criação de mensagem de sucesso
        Session::flash('success', 'Usuário deletado com sucesso!');

        return redirect()->route('usr.index');
    }
}
