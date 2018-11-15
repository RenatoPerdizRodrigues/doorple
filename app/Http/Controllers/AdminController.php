<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Config;
use App\Admin;

class AdminController extends Controller
{
    //Construct que permite acesso apenas a administradores logados
    public function __construct(){
        $this->middleware('auth:admin');
    }

    //Função de acesso ao index do administrador
    public function index(){
        $config = Config::select('configured')->get();
        if (empty($config[0])){
            return view('admin.config');
        }
        return view('admin.dashboard')->withConfig($config);
    }

    //Mostra o formulário de criação de novos administradores
    public function create()
    {
        return view('admin.admin-creation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'name' => 'required|min:6|max:35',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ));

        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = $request->password;
        $admin->save();

        return redirect()->route('admin.dashboard');
    }

    //Mostra o formulário de busca de admin
    public function showSearchForm(){
        $admins = Admin::all();
        return view('admin.admin-creation.search')->withAdmins($admins);
    }

    //Busca um admin e redireciona para a página de show
    public function search(Request $request)
    {   
        $admin = Admin::where('email', $request->email)->get();
        return redirect()->route('adm.show', $admin[0]->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin = Admin::find($id);
        return view('admin.admin-creation.show')->withAdmin($admin);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin = Admin::find($id);
        return view('admin.admin-creation.edit')->withAdmin($admin);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);

        $this->validate($request, array(
            'name' => 'required|min:6|max:35',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ));

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = $request->password;
        $admin->save();

        return redirect()->route('admin.dashboard');
    }

    public function delete($id){
        $admin = Admin::find($id);
        return view('admin.admin-creation.delete')->withAdmin($admin);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = Admin::find($id);
        $admin->delete();

        return redirect()->route('admin.dashboard');
    }
}
