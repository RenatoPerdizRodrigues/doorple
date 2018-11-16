<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Config;
use App\Admin;
use Hash;

//Classe de acesso à página inicial do administrador, assim como as funções de CRUD de criação de um novo admin
class AdminController extends Controller
{
    //Construct que permite acesso apenas a administradores logados
    public function __construct(){
        $this->middleware('auth:admin');
    }

    //Função de acesso a view inicial do administrador
    public function home(){
        $config = Config::select('configured')->get();
        if (empty($config[0])){
            return view('admin.configuration.config');
        }
        return view('admin.dashboard')->withConfig($config);
    }

    //Função de acesso ao index de todos os admins cadastrados
    public function index(){
        $admins = Admin::all();
        return view('admin.admin-creation.index')->withAdmins($admins);
    }

    //Mostra o formulário de criação de novos administradores
    public function create()
    {
        return view('admin.admin-creation.create');
    }

    //Salva o novo admin no banco de dados
    public function store(Request $request)
    {
        //Validação de dados do formulário
        $this->validate($request, array(
            'name' => 'required|min:3|max:35',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ));

        //Criação do modelo e salvamento das mudanças
        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->save();

        //Redirecionamento
        return redirect()->route('admin.dashboard');
    }

    //Busca um admin e redireciona para a página de show
    public function search(Request $request)
    {   
        $admin = Admin::where('email', $request->email)->get();
        return redirect()->route('adm.show', $admin[0]->id);
    }

    //Mostra um admin
    public function show($id)
    {
        $admin = Admin::find($id);
        return view('admin.admin-creation.show')->withAdmin($admin);
    }

    //Mostra formulário de edição
    public function edit($id)
    {
        $admin = Admin::find($id);
        return view('admin.admin-creation.edit')->withAdmin($admin);
    }

    //Salva as alterações da edição
    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);

        $this->validate($request, array(
            'name' => 'required|min:5|max:35',
            'email' => 'required|email',
            'password' => 'nullable|min:6|same:password-confirmation',
            'password-confirmation' => 'nullable|min:6|same:password'
        ));

        $admin->name = $request->name;
        //Verifica se a senha foi alterada
        $admin->email = $request->email;
        if (!empty($admin->password)){
            $admin->password = Hash::make($request->password);
        }
        $admin->save();

        return redirect()->route('admin.dashboard');
    }

    public function delete($id){
        $admin = Admin::find($id);
        return view('admin.admin-creation.delete')->withAdmin($admin);
    }

    //Deleta o admin
    public function destroy($id)
    {
        $admin = Admin::find($id);
        $admin->delete();

        return redirect()->route('admin.dashboard');
    }
}
