<?php
    //Pega o nome do condomínio
    use App\Config;

    $configs = Config::all();

    if($configs->isEmpty()){
      $configs = null;
    }

    $resident_registry = $configs[0] ? $configs[0]->resident_registry : "null";
    
?>

@if(Auth::guard('admin')->check())

<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="{{route('admin.dashboard')}}">
          <img src="/images/logo.png" height="30" class="logo d-inline-block align-top" alt="">
      {{$configs ? " | " . $configs[0]->system_name : ""}}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse ml-auto" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
          <li class="nav-item {{Route::currentRouteName() == 'admin.dashboard' ? "active" : ""}}">
          <a class="nav-link" href="{{route('admin.dashboard')}}">Home <span class="sr-only">(current)</span></a>
        </li>
  
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
  
        <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle {{Route::currentRouteName() == 'morador.create' || Route::currentRouteName() == 'morador.index' || Route::currentRouteName() == 'morador.show' || Route::currentRouteName() == 'morador.delete' || Route::currentRouteName() == 'morador.edit' || Route::currentRouteName() == 'veiculo_morador.index' || Route::currentRouteName() == 'veiculo_morador.create' || Route::currentRouteName() == 'veiculo_morador.show' || Route::currentRouteName() == 'veiculo_morador.delete' || Route::currentRouteName() == 'veiculo_morador.edit' ? "active" : ""}}" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Moradores
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{route('morador.create')}}">Criar Morador</a>
                <a class="dropdown-item" href="{{route('morador.index')}}">Consultar Morador</a>
                @if($resident_registry == 1)
                    <a class="dropdown-item" href="{{route('veiculo_morador.index')}}">Consultar Veículos</a>
                @endif
              </div>
          </li>
  
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Configuração e Apartamentos
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{route('admin.config.edit')}}">Editar Configuração</a>
                <a class="dropdown-item" href="{{route('admin.config.index')}}">Consultar Apartamentos</a>
              </div>
          </li>
  
          <li class="nav-item">
              <a class="nav-link" href="{{route('admin.logout')}}">Logout<span class="sr-only">(current)</span></a>
          </li>
      </ul>
    </div>
</nav>

@elseif(Auth::guard('web')->check())

<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="{{route('main')}}">
          <img src="/images/logo.png" height="30" class="logo d-inline-block align-top" alt="">
      {{$configs ? " | " . $configs[0]->system_name : ""}}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse ml-auto" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
          <li class="nav-item {{Route::currentRouteName() == 'user.dashboard' ? "active" : ""}}">
          <a class="nav-link" href="{{route('user.dashboard')}}">Home <span class="sr-only">(current)</span></a>
        </li>
  
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle {{Route::currentRouteName() == 'vst.main' || Route::currentRouteName() == 'vst.index' || Route::currentRouteName() == 'vst.create' || Route::currentRouteName() == 'vst.edit' || Route::currentRouteName() == 'vst.delete' || Route::currentRouteName() == 'vst.show' || Route::currentRouteName() == 'visita.create' || Route::currentRouteName() == 'visita.index' || Route::currentRouteName() == 'visita.show' || Route::currentRouteName() == 'visita.edit'  ? "active" : ""}}" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Visitas
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{route('vst.main')}}">Nova Visita</a>
            <a class="dropdown-item" href="{{route('visita.index')}}">Buscar Visitas</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{route('vst.index')}}">Buscar Visitantes</a>
          </div>
        </li>
  
        @if($resident_registry == 1)
        <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle {{Route::currentRouteName() == 'entrada.create' || Route::currentRouteName() == 'entrada.index' || Route::currentRouteName() == 'entrada.show' || Route::currentRouteName() == 'entrada.confirm' ? "active" : ""}}" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Moradores
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{route('entrada.create')}}">Nova Entrada</a>
                <a class="dropdown-item" href="{{route('entrada.index')}}">Buscar Entradas</a>
              </div>
        </li>
        @endif
  
          <li class="nav-item">
              <a class="nav-link" href="{{route('user.logout')}}">Logout<span class="sr-only">(current)</span></a>
          </li>
      </ul>
    </div>
</nav>

@elseif(Auth::guard('web')->check() == 0 && Auth::guard('admin')->check() == 0)
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="{{route('main')}}">
          <img src="/images/logo.png" height="30" class="logo d-inline-block align-top" alt="">
      {{$configs ? " | " . $configs[0]->system_name : ""}}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
</nav>
@endif