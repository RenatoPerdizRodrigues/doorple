<?php
    //Pega o nome do condomínio
    use App\Config;

    $configs = Config::all();
    
?>

<nav class="navbar navbar-expand-lg navbar-dark">
  <a class="navbar-brand" href="{{route('main')}}">
        <img src="/images/logo.png" height="30" class="logo d-inline-block align-top" alt="">
    {{$configs[0]->system_name ? " | " . $configs[0]->system_name : ""}}</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item {{Route::currentRouteName() == 'admin.dashboard' ? "active" : ""}}">
        <a class="nav-link" href="{{route('admin.dashboard')}}">Home <span class="sr-only">(current)</span></a>
      </li>

      <!--Dropdown de Usuários-->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle {{Route::currentRouteName() == 'adm.create' || Route::currentRouteName() == 'adm.index' || Route::currentRouteName() == 'adm.show' || Route::currentRouteName() == 'adm.edit' || Route::currentRouteName() == 'admin.delete' || Route::currentRouteName() == 'usr.create' || Route::currentRouteName() == 'usr.index'  ? "active" : ""}}" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Usuários
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{route('adm.create')}}">Criar Admin</a>
          <a class="dropdown-item" href="{{route('adm.index')}}">Consultar Admin</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{route('usr.create')}}">Criar Usuário</a>
          <a class="dropdown-item" href="{{route('usr.index')}}">Consultar Usuário</a>
        </div>
      </li>

      <!--Dropdown de Moradores-->
      <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{Route::currentRouteName() == 'morador.create' || Route::currentRouteName() == 'morador.index' || Route::currentRouteName() == 'morador.show' || Route::currentRouteName() == 'morador.delete' || Route::currentRouteName() == 'morador.edit' || Route::currentRouteName() == 'veiculo_morador.index' || Route::currentRouteName() == 'veiculo_morador.create' || Route::currentRouteName() == 'veiculo_morador.show' || Route::currentRouteName() == 'veiculo_morador.delete' || Route::currentRouteName() == 'veiculo_morador.edit' ? "active" : ""}}" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Moradores
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{route('morador.create')}}">Criar Morador</a>
              <a class="dropdown-item" href="{{route('morador.index')}}">Consultar Morador</a>
              <a class="dropdown-item" href="{{route('veiculo_morador.index')}}">Consultar Veículos</a>
            </div>
        </li>

        <!--Dropdown de Configuração-->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Configuração e Apartamentos
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{route('admin.config.edit')}}">Editar Configuração</a>
              <a class="dropdown-item" href="{{route('admin.config.index')}}">Consultar Apartamentos</a>
            </div>
        </li>

        <!--Logout-->
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.logout')}}">Logout<span class="sr-only">(current)</span></a>
        </li>
    </ul>
  </div>
</nav>
