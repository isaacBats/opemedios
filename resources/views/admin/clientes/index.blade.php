@extends('layouts.admin')
@section('admin-title', ' - Empresas')
@section('styles')
    <link rel="stylesheet" href="{{ asset('lib/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dragula.min.css') }}" />

    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: #000;
        }
        .menu-ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333333;
        }

        .menu-ul>li {
            float: left;
        }

        .menu-ul>li a {
            display: block;
            color: white;
            text-align: center;
            padding: 16px 40px;
            text-decoration: none;
        }

        .menu-ul>li a:hover {
            background-color: #111111;
        }


        .add-task-container {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            width: 40rem;
            height: 5.3rem;
            margin: auto;
            background: #a8a8a8;
            border: #000013 0.2rem solid;
            border-radius: 0.2rem;
            padding: 0.4rem;
        }

        .main-container {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
        }

        .columns {
            width: 100%;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: start;
            -ms-flex-align: start;
            align-items: flex-start;
            margin: 1.6rem auto;
        }

        .column {
            width: 33%;
            margin: 0 0.6rem;
            background: #a8a8a8;
            border: #000013 0.2rem solid;
            border-radius: 0.2rem;
        }

        .column-header {
            padding: 0.1rem;
            border-bottom: #000013 0.2rem solid;
        }

        .column-header h4 {
            text-align: center;
        }

        .to-do-column .column-header {
            background: #ff872f;
        }

        .doing-column .column-header {
            background: #13a4d9;
        }

        .done-column .column-header {
            background: #15d072;
        }

        .trash-column .column-header {
            background: #ff4444;
        }

        .task-list {
            min-height: 3rem;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        li {
            list-style-type: none;
        }

        .column-button {
            text-align: center;
            padding: 0.1rem;
        }

        .button {
            font-family: "Arimo", sans-serif;
            font-weight: 700;
            border: #000013 0.14rem solid;
            border-radius: 0.2rem;
            color: #000013;
            padding: 0.6rem 1rem;
            margin-bottom: 0.3rem;
            cursor: pointer;
        }

        .delete-button {
            background-color: #ff4444;
            margin: 0.1rem auto 0.6rem auto;
        }

        .delete-button:hover {
            background-color: #fa7070;
        }

        .add-button {
            background-color: #ffcb1e;
            padding: 0 1rem;
            height: 2.8rem;
            width: 10rem;
            margin-top: 0.6rem;
        }

        .add-button:hover {
            background-color: #ffdd6e;
        }

        .task {
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            vertical-align: middle;
            list-style-type: none;
            background: #fff;
            -webkit-transition: all 0.3s;
            transition: all 0.3s;
            margin: 0.4rem;
            border: #000013 0.15rem solid;
            border-radius: 0.2rem;
            cursor: move;
            text-align: center;
            vertical-align: middle;
        }

        .task p {
            margin: auto;
            padding: 15px;
        }

        .gu-mirror {
            position: fixed !important;
            margin: 0 !important;
            z-index: 9999 !important;
            opacity: 0.8;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
            filter: alpha(opacity=80);
        }

        .gu-hide {
            display: none !important;
        }

        .gu-unselectable {
            -webkit-user-select: none !important;
            -moz-user-select: none !important;
            -ms-user-select: none !important;
            user-select: none !important;
        }

        .gu-transit {
            opacity: 0.2;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=20)";
            filter: alpha(opacity=20);
        }
        .mb-2{
            margin-bottom: 5px;
        }
    </style>
@endsection
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="col-md-12 people-list">
        <div class="row">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <ul class="menu-ul">
                            <li><a class="btnCollapse" role="button" data-id="collapseOrdenesTrabajo">Ordenes de trabajo</a></li>
                            <li><a class="collapsed btnCollapse" role="button" data-id="collapseClientes">Clientes</a></li>
                            <li><a class="collapsed btnCollapse" role="button" data-id="collapsePeliculas">Peliculas</a></li>
                            <li><a class="collapsed btnCollapse" role="button" data-id="collapseArtistas">Artistas</a></li>
                            <li><a class="collapsed btnCollapse" role="button" data-id="collapseLibros">Libros</a></li>
                            <li><a class="collapsed btnCollapse" role="button" data-id="collapseSeries">Series</a></li>
                            <li><a class="collapsed btnCollapse" role="button" data-id="collapseFestivales">Festivales</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="collapseOrdenesTrabajo" class="collapse in">
            <div class="panel">
                <div class="panel-body">

                    @hasanyrole('manager|admin')
                    <div class="row mb-2">
                        <div class="col-md-7">
                            <input type="text" id="title" class="form-control" placeholder="Titulo">
                        </div>
                        <div class="col-md-5">
                            <select name="company_id" id="select-task-company" class="form-control" multiple>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <textarea class="form-control" id="taskText" placeholder="Nueva tarea..." onkeydown="if (event.keyCode == 13) document.getElementById('add').click()"></textarea>
                        </div>
                        <div class="col-md-5 text-center">
                            <button id="add" class="btn btn-success" onclick="addTask()" style="width: 200px">Agregar nueva tarea</button>
                        </div>
                    </div>
                    @endhasanyrole

                    <div class="main-container">
                        <ul class="columns">

                            <li class="column to-do-column">
                                <div class="column-header">
                                    <h4>Por realizar</h4>
                                </div>
                                <ul class="task-list" id="to-do" data-column_id="1">
                                    @foreach($por_realizar as $itm)
                                    <li class="task opModalTask" data-titulo="{{$itm->titulo}}" data-task="{{$itm->task}}" data-id="{{$itm->id}}">
                                        <div class="row">
                                            <div class="col-12">
                                                @foreach(\App\Models\Company::whereIn('id', $itm->company_id)->get() as $company)
                                                <label style="font-size:9.5px;">{{ $company->name }}</label> - 
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <p>{{$itm->titulo}}</p>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>

                            <li class="column doing-column">
                                <div class="column-header">
                                    <h4>Tareas fijas</h4>
                                </div>
                                <ul class="task-list" id="doing" data-column_id="2">
                                    @foreach($fijas as $itm)
                                    <li class="task opModalTask" data-titulo="{{$itm->titulo}}" data-task="{{$itm->task}}"  data-id="{{$itm->id}}">
                                        <div class="row">
                                            <div class="col-12">
                                                @foreach(\App\Models\Company::whereIn('id', $itm->company_id)->get() as $company)
                                                <label style="font-size:9.5px;">{{ $company->name }}</label> - 
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <p >{{$itm->titulo}}</p>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>

                            
                            @hasanyrole('manager|admin')
                            <li class="column done-column">
                                <div class="column-header">
                                    <h4>Finalizadas</h4>
                                </div>
                                <ul class="task-list" id="done" data-column_id="3">
                                    @foreach($realizadas as $itm)
                                    <li class="task opModalTask" data-titulo="{{$itm->titulo}}" data-task="{{$itm->task}}"  data-id="{{$itm->id}}">
                                        <div class="row">
                                            <div class="col-12">
                                                @foreach(\App\Models\Company::whereIn('id', $itm->company_id)->get() as $company)
                                                <label style="font-size:9.5px;">{{ $company->name }}</label> - 
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <p >{{$itm->titulo}}</p>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>

                            <li class="column trash-column" style="display: none;">
                                <div class="column-header">
                                    <h4>Eliminadas</h4>
                                </div>
                                <ul class="task-list" id="trash" data-column_id="4">
                                    @foreach($trash as $itm)
                                    <li class="task opModalTask" data-titulo="{{$itm->titulo}}" data-task="{{$itm->task}}"  data-id="{{$itm->id}}">
                                        <div class="row">
                                            <div class="col-12">
                                                @foreach(\App\Models\Company::whereIn('id', $itm->company_id)->get() as $company)
                                                <label style="font-size:9.5px;">{{ $company->name }}</label> - 
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <p >{{$itm->titulo}}</p>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @endhasanyrole
                        </ul>
                    </div>
                </div>
            </div><!-- panel -->
        </div>
        <div id="collapseClientes" class="collapse byAjaxClientes">
            <div class="panel">
                <div calass="panel-body">
                    <div class="well well-asset-options clearfix">
                        <div class="col-md-8 pull-right" role="toolbar">
                            <div class="col-md-offset-4 col-md-4 form-group">
                                <label for="input-clientes-name" class="text-muted">Nombre</label>
                                <input type="text" name="name" class="form-control" id="input-clientes-name">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="select-user-page" class="text-muted">Por p&aacute;gina</label>
                                <select class="form-control" name="paginate" id="paginate_cliente">
                                    <option value="5" {{ $paginate == 5 ? 'selected' : '' }}>5</option>
                                    <option value="10" {{ $paginate == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ $paginate == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ $paginate == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ $paginate == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                            <div class="col-md-2 form-group" style="margin-top: 20px">
                                <button class="btn btn-primary btn-lg byAjaxClientes" id="btnBuscarClientes" href="{{route('clientes.get_clientes')}}"> Buscar</button>
                            </div>
                        </div><!-- btn-toolbar -->
                    </div>
                    <div class="fm-sidebar" id="sectClientes"></div>
                </div>
            </div>
        </div>
        <div id="collapsePeliculas" class="collapse byAjaxPeliculas">
            <div class="panel">
                <div calass="panel-body">
                    <div class="well well-asset-options clearfix">
                        <div class="btn-toolbar btn-toolbar-media-manager pull-left" role="toolbar">
                            <div class="col-md-4 form-group">
                                <div class="btn-group" role="group">
                                    @hasanyrole('manager|admin')
                                    <button id="btn-add-pelicula" data-type="pelicula" class="btn btn-success btn-quirk btn-add"
                                        type="button">{{ __('Agregar Pelicula') }}</button>
                                    @endhasanyrole
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 pull-right" role="toolbar">
                            <div class="col-md-offset-4 col-md-4 form-group">
                                <label for="input-peliculas-name" class="text-muted">Nombre</label>
                                <input type="text" name="name" class="form-control" id="input-peliculas-name">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="select-user-page" class="text-muted">Por p&aacute;gina</label>
                                <select class="form-control" name="paginate" id="paginate_pelicula">
                                    <option value="5" {{ $paginate == 5 ? 'selected' : '' }}>5</option>
                                    <option value="10" {{ $paginate == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ $paginate == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ $paginate == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ $paginate == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                            <div class="col-md-2 form-group" style="margin-top: 20px">
                                <button class="btn btn-primary btn-lg byAjaxLibros" id="btnBuscarPeliculas" href="{{route('clientes.get_peliculas')}}"> Buscar</button>
                            </div>
                        </div><!-- btn-toolbar -->
                    </div>
                    <div class="fm-sidebar" id="sectPeliculas"></div>
                </div>
            </div>
        </div>
        <div id="collapseArtistas" class="collapse byAjaxArtistas">
            <div class="panel">
                <div calass="panel-body">
                    <div class="well well-asset-options clearfix">
                        <div class="btn-toolbar btn-toolbar-media-manager pull-left" role="toolbar">
                            <div class="col-md-4 form-group">
                                <div class="btn-group" role="group">
                                    @hasanyrole('manager|admin')
                                    <button id="btn-add-artist" data-type="artista" class="btn btn-success btn-quirk btn-add"
                                        type="button">{{ __('Agregar Artista') }}</button>
                                    @endhasanyrole
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8 pull-right" role="toolbar">
                            <div class="col-md-offset-4 col-md-4 form-group">
                                <label for="input-sector-name" class="text-muted">Nombre</label>
                                <input type="text" name="name" class="form-control" id="input-artist-name">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="select-user-page" class="text-muted">Por p&aacute;gina</label>
                                <select class="form-control" name="paginate" id="paginate_artista">
                                    <option value="5" {{ $paginate == 5 ? 'selected' : '' }}>5</option>
                                    <option value="10" {{ $paginate == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ $paginate == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ $paginate == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ $paginate == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                            <div class="col-md-2 form-group" style="margin-top: 20px">
                                <button class="btn btn-primary btn-lg" id="btnBuscarArtista"> Buscar</button>
                                @if (request()->has('name'))
                                    <a href="#" class="btn btn-warning ml-2" style="margin-left: .8em"
                                        id=""> Limpiar filtros </a>
                                @endif
                            </div>
                        </div><!-- btn-toolbar -->
                    </div>
                    <div id="sectArtistas"></div>
                </div>
            </div>
        </div>
        <div id="collapseLibros" class="collapse byAjaxLibros">
            <div class="panel">
                <div calass="panel-body">
                    <div class="well well-asset-options clearfix">
                        <div class="btn-toolbar btn-toolbar-media-manager pull-left" role="toolbar">
                            <div class="col-md-4 form-group">
                                <div class="btn-group" role="group">
                                    @hasanyrole('manager|admin')
                                    <button id="btn-add-libro" data-type="libro" class="btn btn-success btn-quirk btn-add"
                                        type="button">{{ __('Agregar Libro') }}</button>
                                    @endhasanyrole
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8 pull-right" role="toolbar">
                            <div class="col-md-offset-4 col-md-4 form-group">
                                <label for="input-libros-name" class="text-muted">Nombre</label>
                                <input type="text" name="name" class="form-control" id="input-libros-name">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="select-user-page" class="text-muted">Por p&aacute;gina</label>
                                <select class="form-control" name="paginate" id="paginate_libro">
                                    <option value="5" {{ $paginate == 5 ? 'selected' : '' }}>5</option>
                                    <option value="10" {{ $paginate == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ $paginate == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ $paginate == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ $paginate == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                            <div class="col-md-2 form-group" style="margin-top: 20px">
                                <button class="btn btn-primary btn-lg" id="btnBuscarLibros" href="{{route('clientes.get_libros')}}"> Buscar</button>
                            </div>
                        </div><!-- btn-toolbar -->
                    </div>
                    <div class="fm-sidebar" id="sectLibros"></div>
                </div>
            </div>
        </div>
        <div id="collapseSeries" class="collapse byAjaxSeries">
            <div class="panel">
                <div calass="panel-body">
                    <div class="well well-asset-options clearfix">
                        <div class="btn-toolbar btn-toolbar-media-manager pull-left" role="toolbar">
                            <div class="col-md-4 form-group">
                                <div class="btn-group" role="group">
                                    @hasanyrole('manager|admin')
                                    <button id="btn-add-serie" data-type="serie" class="btn btn-success btn-quirk btn-add"
                                        type="button">{{ __('Agregar Serie') }}</button>
                                    @endhasanyrole
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8 pull-right" role="toolbar">
                            <div class="col-md-offset-4 col-md-4 form-group">
                                <label for="input-series-name" class="text-muted">Nombre</label>
                                <input type="text" name="name" class="form-control" id="input-series-name">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="select-user-page" class="text-muted">Por p&aacute;gina</label>
                                <select class="form-control" name="paginate" id="paginate_serie">
                                    <option value="5" {{ $paginate == 5 ? 'selected' : '' }}>5</option>
                                    <option value="10" {{ $paginate == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ $paginate == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ $paginate == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ $paginate == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                            <div class="col-md-2 form-group" style="margin-top: 20px">
                                <button class="btn btn-primary btn-lg" id="btnBuscarSeries" href="{{route('clientes.get_series')}}"> Buscar</button>
                            </div>
                        </div><!-- btn-toolbar -->
                    </div>
                    <div class="fm-sidebar" id="sectSeries"></div>
                </div>
            </div>
        </div>
        <div id="collapseFestivales" class="collapse byAjaxFestivales">
            <div class="panel">
                <div calass="panel-body">
                    <div class="well well-asset-options clearfix">
                        <div class="btn-toolbar btn-toolbar-media-manager pull-left" role="toolbar">
                            <div class="col-md-4 form-group">
                                <div class="btn-group" role="group">
                                    @hasanyrole('manager|admin')
                                    <button id="btn-add-festival" data-type="festival" class="btn btn-success btn-quirk btn-add"
                                        type="button">{{ __('Agregar Festival') }}</button>
                                    @endhasanyrole
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8 pull-right" role="toolbar">
                            <div class="col-md-offset-4 col-md-4 form-group">
                                <label for="input-festivales-name" class="text-muted">Nombre</label>
                                <input type="text" name="name" class="form-control" id="input-festivales-name">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="select-user-page" class="text-muted">Por p&aacute;gina</label>
                                <select class="form-control" name="paginate" id="paginate_festival">
                                    <option value="5" {{ $paginate == 5 ? 'selected' : '' }}>5</option>
                                    <option value="10" {{ $paginate == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ $paginate == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ $paginate == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ $paginate == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                            <div class="col-md-2 form-group" style="margin-top: 20px">
                                <button class="btn btn-primary btn-lg" id="btnBuscarFestivales" href="{{route('clientes.get_festivales')}}"> Buscar</button>
                            </div>
                        </div><!-- btn-toolbar -->
                    </div>
                    <div class="fm-sidebar" id="sectFestivales"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-tasks">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@section('scripts')
    <script src="{{ asset('lib/select2/select2.js') }}"></script>
    <script src="{{ asset('js/dragula.min.js') }}"></script>
    <script type="text/javascript">
        var companies           = [@foreach ($companies as $company){"id": "{{ $company->id }}", "name": "{{ $company->name }}"},@endforeach];
        var companies_libros           = [@foreach ($companies_libros as $company){"id": "{{ $company->id }}", "name": "{{ $company->name }}"},@endforeach];
        var companies_peliculas           = [@foreach ($companies_peliculas as $company){"id": "{{ $company->id }}", "name": "{{ $company->name }}"},@endforeach];
    
        function buildThemes(res){

            var html = '';

            var typeN = 'cliente';
            var typeNa = 'Cliente';

            jQuery.each(res.items.data, function(i, itm) {
                html += 
                '<tr>\
                    <td>'+
                        itm.name +
                    '</td>';
                    
                var themes = itm.temas;
                themes_id = [];
                html += '<td>\
                            <ul >';
                    jQuery.each(themes, function(i, theme) {
                        themes_id.push({"id": theme.id, "name": theme.name});
                        html += 
                            '<li>' +
                                theme.name +
                            '</li>';
                    });
                html += '</ul></td>';

                localStorage.setItem("theme_" + itm.id, JSON.stringify(themes_id));

                @hasanyrole('manager|admin')
                html +=
                    '<td>' +
                        '<a href="#" onclick="editarCompany(\''+itm.name+'\',\''+itm.id+'\')"><i class="fa fa-pencil fa-2x text-info"></i></a>' +
                    '</td>' +
                    '<td>' +
                        '<a href="#" onclick="deleteCompany(\''+itm.id+'\')"><i class="fa fa-trash fa-2x text-info"></i></a>' +
                    '</td>';
                @endhasanyrole

                html += '</tr>';
            })
            @hasanyrole('manager|admin')
            html = '<div class="table-responsive"><table class="table table-bordered table-primary table-striped nomargin"><thead><tr><th>' + typeNa + '</th><th>Temas</th><th>Editar</th><th>Eliminar</th></tr></thead><tbody>' + html +'</tbody></table></div>'
            @else
            html = '<div class="table-responsive"><table class="table table-bordered table-primary table-striped nomargin"><thead><tr><th>' + typeNa + '</th><th>Temas</th></tr></thead><tbody>' + html +'</tbody></table></div>'
            @endhasanyrole
            html += res.pagination;

            return html;
        }

        function build(res, type = 1){

            var html = '';

            var typeN = (type == 1 ? 'pelicula' : (type == 2 ? 'libro' : (type == 3 ? 'artista' : (type == 4 ? 'festival' : (type == 5 ? 'serie' : 'cliente')))))
            var typeNa = (type == 1 ? 'Peliculas' : (type == 2 ? 'Libro' : (type == 3 ? 'Artista' : (type == 4 ? 'Festival' : (type == 5 ? 'Serie' : 'Cliente')))))

            jQuery.each(res.items.data, function(i, itm) {
                html += 
                '<tr>\
                    <td>'+
                        itm.name +
                    '</td>\
                    <td>'+
                        itm.company.name +
                    '</td>';

                means_id = [];
                html += '<td>\
                            <ul >';
                    jQuery.each(itm.means, function(i, mean) {
                        means_id.push(mean.id);
                        html += 
                            '<li>' +
                                mean.name +
                            '</li>';
                    });

                @hasanyrole('manager|admin')
                html += '</ul></td>' +
                    '<td>' +
                        '<a href="#" onclick="editar(\'' + typeN + '\',\''+itm.name+'\',\''+itm.company_id+'\',\''+itm.id+'\',\''+means_id+'\',\''+itm.description+'\')"><i class="fa fa-pencil fa-2x text-info"></i></a>' +
                    '</td>' +
                    '<td>' +
                        '<a href="#" onclick="deleteItem(\'' + typeN + '\',\''+itm.id+'\')"><i class="fa fa-trash fa-2x text-info"></i></a>' +
                    '</td>';
                @endhasanyrole

                html += '</tr>';
            })
            @hasanyrole('manager|admin')
            html = '<div class="table-responsive"><table class="table table-bordered table-primary table-striped nomargin"><thead><tr><th>' + typeNa + '</th><th>Compañia</th><th>Medios</th><th>Editar</th><th>Eliminar</th></tr></thead><tbody>' + html +'</tbody></table></div>'
            @else
            html = '<div class="table-responsive"><table class="table table-bordered table-primary table-striped nomargin"><thead><tr><th>' + typeNa + '</th><th>Compañia</th><th>Medios</th></tr></thead><tbody>' + html +'</tbody></table></div>'
            @endhasanyrole
            html += res.pagination;

            return html;
        }

        function loadPeliculas(d_href = '{{ route('clientes.get_peliculas') }}'){
            $.post(d_href, {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "search": $("#input-peliculas-name").val(),
            }, function(res) {
                var html = build(res);
                $("#sectPeliculas").html(html);
                loadActionsPeliculas();
            })
        }

        function loadLibros(d_href = '{{ route('clientes.get_libros') }}'){
            $.post(d_href, {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "search": $("#input-libros-name").val(),
            }, function(res) {
                var html = build(res, 2);
                $("#sectLibros").html(html);
                loadActionsLibros();
            });
        }

        function loadArtistas(d_href = '{{ route('clientes.get_artistas') }}'){
            $.post(d_href, {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "search": $("#input-artist-name").val(),
                "paginate": $("#paginate_artista").val()
            }, function(res) {
                var html = build(res, 3);
                $("#sectArtistas").html(html);
                loadActionsArtistas();
            })
        }

        function loadClientes(d_href = '{{ route('clientes.get_clientes') }}'){
            $.post(d_href, {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "search": $("#input-clientes-name").val(),
                "paginate": $("#paginate_cliente").val()
            }, function(res) {
                var html = buildThemes(res);
                $("#sectClientes").html(html);
                loadActionsClientes();
            })
        }

        function loadFestivales(d_href = '{{ route('clientes.get_festivales') }}'){
            $.post(d_href, {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "search": $("#input-festival-name").val(),
                "paginate": $("#paginate_festival").val()
            }, function(res) {
                var html = build(res, 4);
                $("#sectFestivales").html(html);
                loadActionsFestivales();
            })
        }

        function loadSeries(d_href = '{{ route('clientes.get_series') }}'){
            $.post(d_href, {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "search": $("#input-serie-name").val(),
                "paginate": $("#paginate_serie").val()
            }, function(res) {
                var html = build(res, 5);
                $("#sectSeries").html(html);
                loadActionsSeries();
            })
        }

        
        function loadActionsLibros() {
            $(".byAjaxLibros .page-link, #btnBuscarLibros").on("click", function(e) {
                e.preventDefault();

                var d_href = $(this).attr("href");
                loadLibros(d_href);
            });
        }

        function loadActionsPeliculas() {
            $(".byAjaxPeliculas .page-link, #btnBuscarPeliculas").on("click", function(e) {
                e.preventDefault();

                var d_href = $(this).attr("href");
                loadPeliculas(d_href);
            });
        }

        function loadActionsArtistas() {
            $(".byAjaxArtistas .page-link").on("click", function(e) {
                e.preventDefault();

                var d_href = $(this).attr("href");
                loadArtistas(d_href);
            });
        }

        function loadActionsClientes() {
            $(".byAjaxClientes .page-link, #btnBuscarClientes").on("click", function(e) {
                e.preventDefault();

                var d_href = $(this).attr("href");
                loadClientes(d_href);
            });
        }

        function loadActionsFestivales() {
            $(".byAjaxFestivales .page-link").on("click", function(e) {
                e.preventDefault();

                var d_href = $(this).attr("href");
                loadFestivales(d_href);
            });
        }
        
        function loadActionsSeries() {
            $(".byAjaxSeries .page-link").on("click", function(e) {
                e.preventDefault();

                var d_href = $(this).attr("href");
                loadSeries(d_href);
            });
        }

        $(document).ready(function(){
            $('#select-task-company').select2();

            dragula([
                    document.getElementById("to-do"),
                    document.getElementById("doing"),
                    document.getElementById("done"),
                    document.getElementById("trash")
                ], {
                    removeOnSpill: false
                })
                .on("drag", function(el, container) {
                    el.className.replace("ex-moved", "");
                })
                .on("drop", function(el, target, source, sibling) {
                    el.className += "ex-moved";

                    task_id = el.dataset.id;
                    new_section = target.dataset.column_id
                    bottom_task = sibling != null ? sibling.dataset.id : null

                    $.post('{{ route('task.update') }}', {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "task_id": task_id,
                        "new_section": new_section,
                        "bottom_task": bottom_task
                    }, function(res) {
                        
                    })
                })
                .on("over", function(el, container) {
                    container.className += "ex-over";
                })
                .on("out", function(el, container) {
                    container.className.replace("ex-over", "");
                });

            $(".btnCollapse").on("click", function() {
                var currentItem = $(this).data('id');
                var sections = ["collapseOrdenesTrabajo", "collapseClientes", "collapseTemas", "collapsePeliculas", "collapseArtistas", "collapseLibros", "collapseSeries", "collapseFestivales"];
                sections.forEach(function(item) {
                    if (currentItem != item) $('#' + item).collapse('hide');
                    else $('#' + item).collapse('show');
                });
            });


            loadArtistas();
            loadClientes();
            loadPeliculas();
            loadLibros();
            loadFestivales();
            loadSeries();

            $('.opModalTask').on('click', function() {
                var modal = $('#modal-tasks')
                var modalBody = modal.find('.modal-body')

                modal.find('.modal-title').html($(this).data("titulo"));
                modalBody.html($(this).data("task"))
                modal.modal('show')
            });

            $('.btn-add').on('click', function() {
                var type = $(this).data("type");
                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var modalBody = modal.find('.modal-body')

                form.attr('method', 'POST')
                form.attr('action', '/panel/'+type+'/nuevo')
                form.addClass('form-horizontal')

                modal.find('.modal-title').html('Crear un nuevo ' + type);
                modal.find('#md-btn-submit').val('Crear')
                modalBody.html(getTemplateForCreate(type))

                $('#select-company').select2({
                    dropdownParent: modal
                });

                modal.modal('show')
            })

            $("#md-btn-submit").on("click", function(e) {
                e.preventDefault();

                $.post($("#modal-default-form").attr("action"), $("#modal-default-form").serialize(), function(res) {
                    var modal = $('#modal-default')
                    modal.modal('hide');

                    $.post('{{ route('clientes.get_artistas') }}', {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "search": $("#input-artist-name").val(),
                        "paginate": $("#paginate_artista").val()
                    }, function(res) {
                        loadArtistas();
                        loadLibros();
                        loadPeliculas();
                        loadFestivales();
                        loadSeries();
                        loadClientes();
                    })
                });
            });

            $("#btnBuscarArtista").on("click", function(e) {
                e.preventDefault();
                loadArtistas();
            });
        })


        function reloadAll(){
            loadPeliculas();
            loadLibros();
            loadArtistas();
            loadFestivales();
            loadSeries();
            loadClientes();
        }
        
        function deleteCompany(id){
            var url = '{{ route('clientes.remove_company') }}';

            $.post(url, {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
            }, function(res) {
                reloadAll()
            });
        }

        function deleteItem(type, id){
            var url = '{{ route('clientes.remove_artistas') }}';
            if(type == 'libro') url = '{{ route('clientes.remove_libros') }}';
            else if(type == 'pelicula') url = '{{ route('clientes.remove_peliculas') }}';

            $.post(url, {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
            }, function(res) {
                reloadAll()
            });
        }

        function addTask() {
            var inputTask = document.getElementById("taskText").value;
            
            
            if($("#title").val() == ''){
                alert('Agregue un título a la tarea');
                return;
            }
            if(inputTask == ''){
                alert('Agregue una descripción de la tarea');
                return;
            }
            var select_company = $("#select-task-company").val();
            if(select_company == '' || select_company == undefined || select_company == null){
                alert('Sebe seleccionar una compañia');
                return;
            }

            $.post('{{ route('task.save') }}', {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "company_id": $("#select-task-company").val(),
                "titulo": $("#title").val(),
                "task": inputTask
            }, function(res) {
            
                document.getElementById("to-do").innerHTML +=
                    "<li class='task' data-id='" + res.id + "'>" +
                        "<div class=\"row\">" +
                            "<div class=\"col-12\">" +
                                "<label style=\"font-size:9.5px;\">" + $("#select-task-company option:selected").text() + "</label>" +
                            "</div>" +
                        "</div>" +
                        "<div class=\"row\">" +
                            "<div class=\"col-12\">" +
                                "<p>" + inputTask + "</p>" +
                            "</div>" +
                        "</div></li>";

                document.getElementById("title").value = "";
                document.getElementById("select-task-company").value = "";
                $("#select-task-company").trigger("change");
                document.getElementById("taskText").value = "";
                
            })
        }

        function emptyTrash() {
            document.getElementById("trash").innerHTML = "";
        }
        
        function editar(type, name, company_id, id, meansId, description = ''){
            var url_action = '/panel/'+type+'/edit/' + id;

            var modal = $('#modal-default')
            var form = $('#modal-default-form')
            var modalBody = modal.find('.modal-body')

            form.attr('method', 'POST')
            form.attr('action', url_action)
            form.addClass('form-horizontal')

            modal.find('.modal-title').html('Editar ' + type);
            modal.find('#md-btn-submit').val('Guardar')
            modalBody.html(getTemplateForCreate(type, name, company_id, meansId))

            $('#select-company').select2({
                dropdownParent: modal
            });

            modal.modal('show')
        }

        function editarCompany(name, id){
            var url_action = '/panel/cliente/edit/' + id;

            var modal = $('#modal-default')
            var form = $('#modal-default-form')
            var modalBody = modal.find('.modal-body')

            form.attr('method', 'POST')
            form.attr('action', url_action)
            form.addClass('form-horizontal')

            modal.find('.modal-title').html('Editar cliente');
            modal.find('#md-btn-submit').val('Guardar')
            
            
            modalBody.html(getTemplateForCreate('cliente', name))

            
            $('.js-data-example-ajax').
                    select2({
                        width: 'resolve',
                        multiple: true,
                        tags: true,
                        tokenSeparators: [','],
                        dropdownParent: modal,
                        ajax: {
                            url: '{{route('clientes.get_themes')}}',
                            dataType: 'json',
                            processResults: function (data) {
                            // Transforms the top-level key of the response object from 'items' to 'results'
                            return {
                                results: data.items
                            };
                            }
                            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                        }
                    });

            var themesId = JSON.parse(localStorage.getItem("theme_" + id));
            var themeSelect = $('.js-data-example-ajax');

            for(var i = 0; i < themesId.length; i++){
                var option = new Option(themesId[i].name, themesId[i].id, true, true);
                themeSelect.append(option).trigger('change');
            }

            themeSelect.trigger({
                type: 'select2:select',
                // params: {
                //     data: data
                // }
            });

            modal.modal('show')
        }

        function getTemplateForCreate(type, name = '', id = '', descripcion = '', meansId = []) {
            var html_company = '';
            var title = '';

            var html_desc = 
                    `<div class="form-group">
                        <label class="col-sm-3 control-label">Descripción</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="descripcion" placeholder="Descripción" onkeydown="if (event.keyCode == 13) document.getElementById('md-btn-submit').click()">`+descripcion+`</textarea>
                        </div>
                    </div>`;

            if(type == 'libro'){
                title = 'Libro';
                for(var k in companies_libros) html_company += `<option value="`+companies_libros[k].id+`" ` + (id == companies_libros[k].id ? 'selected' : '' ) + `>`+companies_libros[k].name+`</option>`;
            }else if(type == 'pelicula'){
                title = 'Pelicula';
                for(var k in companies_peliculas) html_company += `<option value="`+companies_peliculas[k].id+`" ` + (id == companies_peliculas[k].id ? 'selected' : '' ) + `>`+companies_peliculas[k].name+`</option>`;
            }else if(type == 'cliente'){
                title = 'Cliente';
            }else{
                for(var k in companies) html_company += `<option value="`+companies[k].id+`" ` + (id == companies[k].id ? 'selected' : '' ) + `>`+companies[k].name+`</option>`;
                if(type == 'serie')
                    title = 'Serie';
                else if(type == 'festival')
                    title = 'Festival';
                else{
                    title = 'Artista';
                    html_desc = '';
                }
            }

            var html_p = '';
            if(type == 'cliente'){
                html_p = `
                    <div class="row">
                        <div class="form-group">
                            <label class="col-sm-5 control-label">`+name+`</label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Temas</label>
                            <div class="col-sm-8" style="display: grid;">
                                <select name="themes_id[]" class="js-data-example-ajax w-100"></select>
                            </div>
                        </div>
                    </div>
                `;

            }else{
                html_p = `
                    <div class="row">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Compañia</label>
                            <div class="col-sm-8">
                                <select id="select-company" name="company_id" class="form-control" style="width: 100%;" required>
                                    <option value="">Seleccionan una compañia</option>
                                    ` + html_company + `
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">` + title + `</label>
                            <div class="col-sm-8">
                                <input id="input-name-` + type + `" type="text" placeholder="` + title + `" name="name" class="form-control" value="`+name+`" onkeydown="if (event.keyCode == 13) document.getElementById('md-btn-submit').click()"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Medios</label>
                            <div class="col-sm-8">
                                @foreach ($means as $mean)
                                    <label><input type="checkbox" name="means_id[]" value="{{ $mean->id }}" ` + (meansId.includes('{{ $mean->id }}') ? 'checked' : '' ) + `>{{ $mean->name }}</label>
                                @endforeach
                            </div>
                        </div>
                        ` + html_desc + `
                    </div>
                `;
            }
            return html_p;
        }

    </script>
@endsection
