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
        $this->middleware('checkConfig');
    }

    //Função de acesso ao index de todos os usuários cadastrados, paginados em 10
    public function index(){
        $users = User::paginate(10);
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
            'password' => 'alpha_num|required|min:8|same:password-confirmation|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
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
        $user = User::where('email', $request->email)->first();

        //Verifica se user existe
        if($user == null){
            Session::flash('warning', 'Usuário não encontrado!');
            return redirect()->route('usr.index');
        }

        return redirect()->route('usr.show', $user->id);
    }

    //Mostra um usuário
    public function show($id)
    {
        $user = User::find($id);

        //Verifica se user existe
        if($user == null){
            Session::flash('warning', 'Usuário não encontrado!');
            return redirect()->route('usr.index');
        }

        return view('admin.user-creation.show')->withUser($user);
    }

    //Mostra formulário de edição de usuário
    public function edit($id)
    {
        $user = User::find($id);

        //Verifica se user existe
        if($user == null){
            Session::flash('warning', 'Usuário não encontrado!');
            return redirect()->route('usr.index');
        }

        return view('admin.user-creation.edit')->withUser($user);
    }

    //Salva as alterações da edição
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        //Verifica se user existe
        if($user == null){
            Session::flash('warning', 'Usuário não encontrado!');
            return redirect()->route('usr.index');
        }

        $this->validate($request, array(
            'name' => 'required|min:3|max:35',
            'email' => 'required|email|unique:admins,email,'.$id,
            'password' => 'alpha_num|nullable|min:8|same:password-confirmation|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
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

    //Retorna o formulário de exclusão de Usuário
    public function delete($id){
        $user = User::find($id);
        
        //Verifica se user existe
        if($user == null){
            Session::flash('warning', 'Usuário não encontrado!');
            return redirect()->route('usr.index');
        }

        return view('admin.user-creation.delete')->withUser($user);
    }

    //Deleta o usuário
    public function destroy($id)
    {
        $user = User::find($id);

        //Verifica se user existe
        if($user == null){
            Session::flash('warning', 'Usuário não encontrado!');
            return redirect()->route('usr.index');
        }

        $user->delete();

        //Criação de mensagem de sucesso
        Session::flash('success', 'Usuário deletado com sucesso!');

        return redirect()->route('usr.index');
    }
}
