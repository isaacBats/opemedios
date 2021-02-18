@extends('layouts.signin')
@section('title-section', ' - Administrador de sesiones')
@section('content')
    <div class="panel signin">
  <div class="panel-heading">
    <h1><a href="{{ url('/') }}">{{ config('app.name') }}</a></h1>
    <h4 class="panel-title">Administrador de accesos</h4>
  </div>
  <div class="panel-body">
    <form method="POST" action="{{ route('front.manageraccess.login') }}" aria-label="Acceso">
        @csrf
        <input type="hidden" name="access" value="true">
        <input type="hidden" name="email" value="{{ $credentials['email'] }}">
        <input type="hidden" name="password" value="{{ $credentials['password'] }}">
        <div class="form-group">
            <select class="form-control" name="access_type" id="select-access-type">
                <option value="">¿Cómo quieres entrar?</option>
                <option value="admin">Panel de administración</option>
                <option value="client">Panel de cliente</option>
            </select>
        </div>
        <div class="form-group" style="display: none;" id="div-select-client">
            <select name="client_id" id="select-client-id" class="form-control">
                <option value="">Selecciona la cuenta con la que quieres entrar.</option>
                @foreach($user->companies as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <button type="submit" id="btn-submit" class="btn btn-success btn-quirk btn-block" disabled="true">Entrar</button>
        </div>
    </form>
  </div>
</div><!-- panel -->
@endsection
@section('scripts')}
    <script type="text/javascript" src="{{ asset('lib/jquery/jquery.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            // Select
            $('select#select-access-type').on('change', function(){
                var accessType = $(this).val();
                var button = $('#btn-submit');
                var divSelectClient = $('#div-select-client');
                button.attr('disabled', true)

                if( accessType == 'admin' ) {
                    button.attr('disabled', false);
                    divSelectClient.hide('fast');
                    divSelectClient.find('#select-client-id').attr('disabled', true);
                } else if( accessType == 'client') {
                    divSelectClient.find('#select-client-id').attr('disabled', false);
                    divSelectClient.show('slow');
                    divSelectClient.find('#select-client-id').on('change', function(){
                        var clientSelected = $(this).val();
                        button.attr('disabled', true);
                        
                        if( clientSelected != "") {
                            button.attr('disabled', false);
                        } 
                    })
                } 
            })

        })
    </script>
@endsection
