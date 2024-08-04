@extends('layouts.admin')
@section('admin-title', ' - Empresas')
@section('styles')
    <link rel="stylesheet" href="{{ asset('lib/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dragula.min.css') }}" />

    <style>
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
            padding: 16px 60px;
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
                            <li>
                                <a class="btnCollapse" role="button" data-id="collapseClientes">Clientes</a>
                            </li>
                            <li>
                                <a class="collapsed btnCollapse" role="button" data-id="collapsePeliculas">Peliculas</a>
                            </li>
                            <li>
                                <a class="collapsed btnCollapse" role="button" data-id="collapseArtistas">Artistas</a>
                            </li>
                            <li>
                                <a class="collapsed btnCollapse" role="button" data-id="collapseLibros">Libros</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="collapseClientes" class="collapse in">
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
                                {{-- <div class="column-button">
                                    <button class="button delete-button" onclick="emptyTrash()">Delete</button>
                                </div> --}}
                            </li>
                            @endhasanyrole
                        </ul>
                    </div>
                </div>
            </div><!-- panel -->
        </div>
        <div id="collapsePeliculas" class="collapse byAjaxPeliculas">
            <div class="panel">
                <div calass="panel-body">
                    <div class="well well-asset-options clearfix">
                        <div class="btn-toolbar btn-toolbar-media-manager pull-left" role="toolbar">
                            <div class="col-md-4 form-group">
                                <div class="btn-group" role="group">
                                    @hasanyrole('manager|admin')
                                    <button id="btn-add-pelicula" class="btn btn-success btn-quirk"
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
                                    <button id="btn-add-artist" class="btn btn-success btn-quirk"
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
                                    <button id="btn-add-libro" class="btn btn-success btn-quirk"
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
    </div>

    <!-- modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-tasks">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Modal title</h4>
                </div>
                <div class="modal-body">
                    <p>One fine body&hellip;</p>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@section('scripts')
    <script src="{{ asset('lib/select2/select2.js') }}"></script>
    <script src="{{ asset('js/dragula.min.js') }}"></script>
    <script type="text/javascript">
    
        function build(res, type = 1){

            var html = '';

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
                        '<a href="#" class="btn-delete-company" onclick="' + (type == 1 ? 'editaPelicula' : (type == 2 ? 'editaLibro' : 'editaArtista')) + '(\''+itm.name+'\',\''+itm.company_id+'\',\''+itm.id+'\',\''+itm.description+'\',\''+means_id+'\')"><i class="fa fa-pencil fa-2x text-info"></i></a>' +
                    '</td>' +
                    '<td>' +
                        '<a href="#" class="btn-delete-company" onclick="' + (type == 1 ? 'deletePelicula' : (type == 2 ? 'deleteLibro' : 'deleteArtista')) + '(\''+itm.id+'\')"><i class="fa fa-trash fa-2x text-info"></i></a>' +
                    '</td>';
                @endhasanyrole

                html += '</tr>';
            })
            @hasanyrole('manager|admin')
            html = '<div class="table-responsive"><table class="table table-bordered table-primary table-striped nomargin"><thead><tr><th>' + (type == 1 ? 'Peliculas' : (type == 2 ? 'Libro' : 'Artista')) + '</th><th>Compañia</th><th>Medios</th><th>Editar</th><th>Eliminar</th></tr></thead><tbody>' + html +'</tbody></table></div>'
            @else
            html = '<div class="table-responsive"><table class="table table-bordered table-primary table-striped nomargin"><thead><tr><th>' + (type == 1 ? 'Peliculas' : (type == 2 ? 'Libro' : 'Artista')) + '</th><th>Compañia</th><th>Medios</th></tr></thead><tbody>' + html +'</tbody></table></div>'
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
                    console.log(el.dataset.id);
                    console.group("el");
                    console.log(el);
                    console.groupEnd();
                    console.group("target");
                    console.log(target);
                    console.groupEnd();
                    console.group("source");
                    console.log(source);
                    console.groupEnd();
                    console.group("sibling");
                    console.log(sibling);
                    console.groupEnd();
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


            $('#table-company-list').on('click', '.btn-delete-company', function(event) {
                event.preventDefault()
                var companyName = $(this).data('name')
                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var urlAction = $(this).attr('href')

                form.attr('action', urlAction)
                form.attr('method', 'POST')

                modal.find('.modal-title').text(`Eliminar Empresa`)
                modal.find('#md-btn-submit').removeClass('btn-primary').addClass('btn-danger').val(
                    "{{ __('Eliminar') }}")
                modal.find('.modal-body').html(`¿{{ __('Estas seguro que quieres eliminar a ') }}<strong>${companyName}</strong>?
                    <br />
                    <p>Si eliminas la empresa ${companyName} tambien se van a borrar las cuentas y los temas asociados a la empresa.</p>
                `)
                modal.modal('show')
            });

            $(".btnCollapse").on("click", function() {
                var currentItem = $(this).data('id');
                var sections = ["collapseClientes", "collapseTemas", "collapsePeliculas",
                    "collapseArtistas", "collapseLibros"
                ];

                sections.forEach(function(item) {

                    if (currentItem != item) $('#' + item).collapse('hide');
                    else $('#' + item).collapse('show');

                });

            });


            loadArtistas();
            loadPeliculas();
            loadLibros();

            $('.opModalTask').on('click', function() {
                var modal = $('#modal-tasks')
                var modalBody = modal.find('.modal-body')

                modal.find('.modal-title').html($(this).data("titulo"));
                modalBody.html($(this).data("task"))
                modal.modal('show')
            });


            $('#btn-add-artist').on('click', function() {
                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var modalBody = modal.find('.modal-body')

                form.attr('method', 'POST')
                form.attr('action', '/panel/artista/nuevo')
                form.addClass('form-horizontal')

                modal.find('.modal-title').html('Crear un nuevo artista');
                modal.find('#md-btn-submit').val('Crear')
                modalBody.html(getTemplateForCreateArtista())

                $('#select-company').select2({
                    dropdownParent: modal
                });

                modal.modal('show')
            })

            $('#btn-add-pelicula').on('click', function() {
                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var modalBody = modal.find('.modal-body')

                form.attr('method', 'POST')
                form.attr('action', '/panel/pelicula/nuevo')
                form.addClass('form-horizontal')

                modal.find('.modal-title').html('Crear un nueva pelicula');
                modal.find('#md-btn-submit').val('Crear')
                modalBody.html(getTemplateForCreatePelicula())

                $('#select-company').select2({
                    dropdownParent: modal
                });

                modal.modal('show')
            })

            $('#btn-add-libro').on('click', function() {
                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var modalBody = modal.find('.modal-body')

                form.attr('method', 'POST')
                form.attr('action', '/panel/libro/nuevo')
                form.addClass('form-horizontal')

                modal.find('.modal-title').html('Crear un nuevo libro');
                modal.find('#md-btn-submit').val('Crear')
                modalBody.html(getTemplateForCreateLibro())

                $('#select-company').select2({
                    dropdownParent: modal
                });

                modal.modal('show')
            })

            $("#md-btn-submit").on("click", function(e) {
                e.preventDefault();

                $.post($("#modal-default-form").attr("action"), $("#modal-default-form").serialize(), function(
                res) {
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
        }
            
        function deleteLibro(id){
            $.post('{{ route('clientes.remove_libros') }}', {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
            }, function(res) {
                reloadAll()
            });
        }

        function deletePelicula(id){
            $.post('{{ route('clientes.remove_peliculas') }}', {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "id": id,
            }, function(res) {
                reloadAll()
            });
        }

        function deleteArtista(id){
            $.post('{{ route('clientes.remove_artistas') }}', {
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
        
        function editaArtista(name, company_id, id, meansId){
                
            var modal = $('#modal-default')
            var form = $('#modal-default-form')
            var modalBody = modal.find('.modal-body')


            form.attr('method', 'POST')
            form.attr('action', '/panel/artista/edit/' + id)
            form.addClass('form-horizontal')

            modal.find('.modal-title').html('Editar artista');
            modal.find('#md-btn-submit').val('Guardar')
            modalBody.html(getTemplateForCreateArtista(name, company_id, meansId))

            $('#select-company').select2({
                dropdownParent: modal
            });

            modal.modal('show')
        }

        function editaPelicula(name, company_id, id, description, meansId){
                
            var modal = $('#modal-default')
            var form = $('#modal-default-form')
            var modalBody = modal.find('.modal-body')


            form.attr('method', 'POST')
            form.attr('action', '/panel/pelicula/edit/' + id)
            form.addClass('form-horizontal')

            modal.find('.modal-title').html('Editar pelicula');
            modal.find('#md-btn-submit').val('Guardar')
            modalBody.html(getTemplateForCreatePelicula(name, company_id, description, meansId))

            $('#select-company').select2({
                dropdownParent: modal
            });

            modal.modal('show')
        }

        function editaLibro(name, company_id, id, description, meansId){
            
            var modal = $('#modal-default')
            var form = $('#modal-default-form')
            var modalBody = modal.find('.modal-body')


            form.attr('method', 'POST')
            form.attr('action', '/panel/libro/edit/' + id)
            form.addClass('form-horizontal')

            modal.find('.modal-title').html('Editar libro');
            modal.find('#md-btn-submit').val('Guardar')
            modalBody.html(getTemplateForCreateLibro(name, company_id, description, meansId))

            $('#select-company').select2({
                dropdownParent: modal
            });

            modal.modal('show')
        }
        
        function getTemplateForCreateArtista(name = '', id = '', meansId = []) {
            return `
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Compañia</label>
                        <div class="col-sm-8">
                            <select id="select-company" name="company_id" class="form-control" style="width: 100%;" required>
                                <option value="">Seleccionan una compañia</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}" ` + (id == {{ $company->id }} ? 'selected' : '' ) + `>{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Artista</label>
                        <div class="col-sm-8">
                            <input id="input-name-artist" type="text" name="name" class="form-control" value="`+name+`"/>
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
                </div>
            `
        }
        function getTemplateForCreatePelicula(name = '', id = '', descripcion = '', meansId = []) {
            return `
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Compañia</label>
                        <div class="col-sm-8">
                            <select id="select-company" name="company_id" class="form-control" style="width: 100%;" required>
                                <option value="">Selecciona una compañia</option>
                                @foreach ($companies_peliculas as $company)
                                    <option value="{{ $company->id }}" ` + (id == {{ $company->id }} ? 'selected' : '' ) + `>{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Pelicula</label>
                        <div class="col-sm-8">
                            <input id="input-name-pelicula" type="text" placeholder="Pelicula" name="name" class="form-control" value="`+name+`" onkeydown="if (event.keyCode == 13) document.getElementById('md-btn-submit').click()"/>
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
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Descripción</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="descripcion" placeholder="Descripción" onkeydown="if (event.keyCode == 13) document.getElementById('md-btn-submit').click()">`+descripcion+`</textarea>
                        </div>
                    </div>
                </div>
            `
        }
        function getTemplateForCreateLibro(name = '', id = '', descripcion = '', meansId = []) {
            return `
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Compañia</label>
                        <div class="col-sm-8">
                            <select id="select-company" name="company_id" class="form-control" style="width: 100%;" required>
                                <option value="">Seleccionan una compañia</option>
                                @foreach ($companies_libros as $company)
                                    <option value="{{ $company->id }}" ` + (id == {{ $company->id }} ? 'selected' : '' ) + `>{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Libro</label>
                        <div class="col-sm-8">
                            <input id="input-name-libro" type="text" placeholder="Libro" name="name" class="form-control" value="`+name+`" onkeydown="if (event.keyCode == 13) document.getElementById('md-btn-submit').click()"/>
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
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Descripción</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="descripcion" placeholder="Descripción" onkeydown="if (event.keyCode == 13) document.getElementById('md-btn-submit').click()">`+descripcion+`</textarea>
                        </div>
                    </div>
                </div>
            `
        }

    </script>
@endsection
