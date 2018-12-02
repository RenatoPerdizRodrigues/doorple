<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Config;
use App\Admin;
use App\Visita;
use Hash;
use Session;
use Auth;

//Classe de acesso à página inicial do administrador, assim como as funções de CRUD de criação de um novo admin
class AdminController extends Controller
{
    //Construct que permite acesso apenas a administradores logados
    public function __construct(){
        $this->middleware('auth:admin');
    }

    /*Função de acesso a view inicial do administrador, que pode redirecionar para a configuração do sistema
    caso o mesmo ainda não tenha sido configurado*/
    public function home(){
        $config = Config::select('configured')->get();
        $visitas = Visita::whereDate('created_at', date('Y-m-d'))->limit(5)->get();
        if (empty($config[0])){
            return view('admin.configuration.config');
        }
        $configs = Config::all();
        return view('admin.dashboard')->withConfig($config)->withVisitas($visitas)->withConfigs($configs);
    }

    //Função de acesso ao index de todos os admins cadastrados, paginados em 10
    public function index(){
        $admins = Admin::paginate(10);
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
            'password' => 'required|min:6|same:password-confirmation'
        ));

        //Criação do modelo e salvamento das mudanças
        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->save();

        //Mensagem de sucesso
        Session::flash('success', 'Administrador cadastrado com sucesso!');

        //Redirecionamento para o index de admins
        $admins = Admin::all();
        return redirect()->route('adm.index')->withAdmins($admins);;
    }

    //Busca um admin na página de index e redireciona para a página de show
    public function search(Request $request)
    {   
        $admin = Admin::where('email', $request->email)->get();
        return redirect()->route('adm.show', $admin[0]->id);
    }

    //Mostra um admin com opções de deletar ou editar
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

        //Criação de mensagem de sucesso
        Session::flash('success', 'Administrador editado com sucesso!');

        //Redirecionamento para a página do administrador modificado
        return redirect()->route('adm.show', $admin->id);
    }

    //Mostra o formulário de delete de administrador
    public function delete($id){
        $admin = Admin::find($id);

        //Caso o administrador esteja logado, não deve permitir o delete
        if(Auth::id() == $admin->id){
            //Cria mensagem de aviso
            Session::flash('warning', 'Não é possível deletar o administrador logado!');
            return redirect()->route('adm.show', $admin->id);
        } else {
            return view('admin.admin-creation.delete')->withAdmin($admin);
        }
    }

    //Deleta o admin escolhido
    public function destroy($id)
    {
        $admin = Admin::find($id);
        $admin->delete();

        //Cria mensagem de sucesso
        Session::flash('success', 'Administrador deletado com sucesso!');

       //Redirecionamento para o index de admins
       $admins = Admin::all();
       return redirect()->route('adm.index')->withAdmins($admins);;
    }
}
