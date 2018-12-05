@if(Session::has('success'))
    <div class="col-md-4 offset-md-4">
        <div class="mensagens">
            <div class="alert alert-success" role="alert">
                {{Session::get('success')}}
            </div>
        </div>
    </div>
@endif

@if(Session::has('warning'))
    <div class="col-md-4 offset-md-4">
        <div class="mensagens">
            <div class="alert alert-warning" role="alert">
                {{Session::get('warning')}}
            </div>
        </div>
    </div>
@endif

@if (count($errors) > 0)
    <div class="col-md-4 offset-md-4">
        <div class="mensagens">
            <div class="alert alert-danger" role="alert">
                <ul>
                @foreach($errors->all() as $error)
                    Erro!
                    <li>{{$error}}</li>
                @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif