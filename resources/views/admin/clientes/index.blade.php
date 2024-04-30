@extends('layouts.admin')
@section('admin-title', ' - Empresas')
@section('styles')
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
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: start;
            -ms-flex-align: start;
            align-items: flex-start;
            margin: 1.6rem auto;
        }

        .column {
            width: 20rem;
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
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            vertical-align: middle;
            list-style-type: none;
            background: #fff;
            -webkit-transition: all 0.3s;
            transition: all 0.3s;
            margin: 0.4rem;
            height: 8rem;
            border: #000013 0.15rem solid;
            border-radius: 0.2rem;
            cursor: move;
            text-align: center;
            vertical-align: middle;
        }

        #taskText {
            background: #fff;
            border: #000013 0.15rem solid;
            border-radius: 0.2rem;
            text-align: center;
            font-family: "Roboto Slab", serif;
            height: 4rem;
            width: 7rem;
            margin: auto 0.8rem auto 0.1rem;
        }

        .task p {
            margin: auto;
        }

        /* Dragula CSS Release 3.2.0 from: https://github.com/bevacqua/dragula */

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
                                <a class="btnCollapse" role="button" data-id="collapseClientes">
                                    Clientes
                                </a>
                            </li>
                            <li>
                                <a class="collapsed btnCollapse" role="button" data-id="collapsePeliculas">
                                    Peliculas
                                </a>
                            </li>
                            <li>
                                <a class="collapsed btnCollapse" role="button" data-id="collapseArtistas">
                                    Artistas
                                </a>
                            </li>
                            <li>
                                <a class="collapsed btnCollapse" role="button" data-id="collapseLibros">
                                    Libros
                                </a>
                            </li>
                        </ul>



                    </div>
                </div>
            </div>



        </div>
        <div id="collapseClientes" class="collapse in">
            <div class="panel">
                <div class="people-options clearfix"> <!-- filter-options -->
                    <div class="btn-toolbar">
                        <form action="{{ route('companies') }}" method="GET">
                            <div class="row">
                                <div class="col-md-2 form-group">
                                    <label for="input-company-name" class="text-muted">Nombre</label>
                                    <input type="text" name="name" class="form-control" id="input-company-name"
                                        value="{{ request()->get('name') }}">
                                </div>
                                <div class="col-md-2 form-group">
                                    <label for="select-company-turn" class="text-muted">Giro</label>
                                    <select class="form-control" name="turn">
                                        <option value="">Giro</option>
                                        @foreach (App\Models\Turn::all() as $turn)
                                            <option value="{{ $turn->id }}"
                                                {{ request()->get('turn') == $turn->id ? 'selected' : '' }}>
                                                {{ $turn->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label for="select-user-page" class="text-muted">Por p&aacute;gina</label>
                                    <select class="form-control" name="paginate">
                                        <option value="5" {{ $paginate == 5 ? 'selected' : '' }}>5</option>
                                        <option value="10" {{ $paginate == 10 ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ $paginate == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ $paginate == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ $paginate == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group" style="margin-top: 20px">
                                    <button class="btn btn-primary btn-lg"> Buscar</button>
                                    @if (request()->has('name') || request()->has('turn'))
                                        <a href="{{ route('companies') }}" class="btn btn-warning ml-2"
                                            style="margin-left: .8em"> Limpiar filtros </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                    <span id="span-count-info" class="people-count pull-right">Mostrando <strong
                            id="num-rows-info">{{ $companies->count() }} de {{ $companies->total() }}</strong>
                        empresas</span>
                </div><!-- filter-options -->
                <?php /*<div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-6 col-md-8 col-sm-6 col-xs-12">
                            <h4 class="panel-title" style="padding: 12px 0;">Administrador de empresas</h4>
                        </div>
                        <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12 text-right">
                            <a href="{{ route('company.create') }}" class="btn btn-danger btn-quirk btn-lg"><i
                                    class="fa fa-plus-circle"></i> Nueva empresa</a>
                        </div>
                    </div>
                </div> */
                ?>
                <div class="panel-body">



                    <div class="add-task-container">
                        <input type="text" maxlength="12" id="taskText" placeholder="Nueva tarea..."
                            onkeydown="if (event.keyCode == 13)
                          document.getElementById('add').click()">
                        <button id="add" class="button add-button" onclick="addTask()" style="width: 200px">Agregar
                            nueva tarea</button>
                    </div>

                    <div class="main-container">
                        <ul class="columns">

                            <li class="column to-do-column">
                                <div class="column-header">
                                    <h4>Por realizar</h4>
                                </div>
                                <ul class="task-list" id="to-do">
                                    <li class="task" data-id="65">
                                        <p>Estar pendiente de artista</p>
                                    </li>
                                    <li class="task">
                                        <p>Buscar un libro</p>
                                    </li>
                                    <li class="task">
                                        <p>Enviar informacion</p>
                                    </li>
                                    <li class="task">
                                        <p>Mas tareas</p>
                                    </li>
                                </ul>
                            </li>

                            <li class="column doing-column">
                                <div class="column-header">
                                    <h4>Tareas fijas</h4>
                                </div>
                                <ul class="task-list" id="doing">
                                    <li class="task">
                                        <p>Enviar diario reporte</p>
                                    </li>
                                    <li class="task">
                                        <p>Tarea</p>
                                    </li>
                                    <li class="task">
                                        <p>Tarea</p>
                                    </li>
                                </ul>
                            </li>

                            <li class="column done-column">
                                <div class="column-header">
                                    <h4>Finalizadas</h4>
                                </div>
                                <ul class="task-list" id="done">
                                    <li class="task">
                                        <p>Tarea</p>
                                    </li>
                                    <li class="task">
                                        <p>Tarea</p>
                                    </li>
                                </ul>
                            </li>

                            <li class="column trash-column" style="display: none;">
                                <div class="column-header">
                                    <h4>Trash</h4>
                                </div>
                                <ul class="task-list" id="trash">
                                    <li class="task">
                                        <p>Interviews</p>
                                    </li>
                                    <li class="task">
                                        <p>Research</p>
                                    </li>

                                </ul>
                                <div class="column-button">
                                    <button class="button delete-button" onclick="emptyTrash()">Delete</button>
                                </div>
                            </li>

                        </ul>
                    </div>


                    <?php /*<div class="table-responsive">
                    <table class="table table-bordered table-primary table-striped nomargin" id="table-company-list">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Giro</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($companies as $company)
                            <tr>
                                <td class="text-center">{{ ($companies->currentPage() - 1) * $companies->perPage() + $loop->iteration }}</td>
                                <td class="text-left">
                                    <a href="{{ route('company.show', ['company' => $company->id]) }}">
                                        <div class="td-select-all">
                                            {{ $company->name }}
                                        </div>
                                    </a>
                                </td>
                                <td class="text-left">
                                    <a href="{{ route('company.show', ['company' => $company->id]) }}">
                                        <div class="td-select-all">
                                            {{ $company->turn->name }}
                                        </div>
                                    </a>
                                </td>
                                <td class="table-options">
                                    <a href="{{ route('admin.company.delete', ['id' => $company->id]) }}"
                                       class="btn-delete-company" data-name="{{ $company->name }}"><i
                                            class="fa fa-trash fa-2x text-danger"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    
                    {!! $companies->links() !!}

                </div><!-- table-responsive -->*/
                    ?>
                </div>
            </div><!-- panel -->
        </div>
        <div id="collapsePeliculas" class="collapse byAjaxPeliculas">
            <div class="panel">
                <div calass="panel-body">
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
                                    <button id="btn-add-artist" class="btn btn-success btn-quirk"
                                        type="button">{{ __('Agregar Artista') }}</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8 pull-right" role="toolbar">
                            <div class="col-md-offset-4 col-md-4 form-group">
                                <label for="input-sector-name" class="text-muted">Nombre</label>
                                <input type="text" name="name" class="form-control" id="input-artist-name"
                                    value="{{ request()->get('name') }}">
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
                    <div id="sectArtistas">
                    </div>
                </div>
            </div>
        </div>
        <div id="collapseLibros" class="collapse byAjaxLibros">
            <div class="panel">
                <div calass="panel-body">
                    <div class="fm-sidebar" id="sectLibros"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('lib/select2/select2.js') }}"></script>
    <script src="{{ asset('js/dragula.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            /* Custom Dragula JS */
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
                })
                .on("over", function(el, container) {
                    container.className += "ex-over";
                })
                .on("out", function(el, container) {
                    container.className.replace("ex-over", "");
                });



            // Modal for delete a company
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

            $.post('{{ route('clientes.get_libros') }}', {
                "_token": $('meta[name="csrf-token"]').attr('content')
            }, function(res) {
                $("#sectLibros").html(res);
                loadI();
            })

            $.post('{{ route('clientes.get_peliculas') }}', {
                "_token": $('meta[name="csrf-token"]').attr('content')
            }, function(res) {
                $("#sectPeliculas").html(res);
                loadP();
            })

            function loadI() {
                $(".byAjaxLibros .page-link").on("click", function(e) {
                    e.preventDefault();

                    var d_href = $(this).attr("href");
                    console.log(d_href);
                    $.post(d_href, {
                        "_token": $('meta[name="csrf-token"]').attr('content')
                    }, function(res) {
                        $("#sectLibros").html(res);
                        loadI();
                    });
                });
            }

            function loadP() {
                $(".byAjaxPeliculas .page-link").on("click", function(e) {
                    e.preventDefault();

                    var d_href = $(this).attr("href");
                    console.log(d_href);
                    $.post(d_href, {
                        "_token": $('meta[name="csrf-token"]').attr('content')
                    }, function(res) {
                        $("#sectPeliculas").html(res);
                        loadP();
                    });
                });
            }


            //create theme
            $('#btn-add-artist').on('click', function() {
                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var modalBody = modal.find('.modal-body')


                form.attr('method', 'POST')
                form.attr('action', '/panel/artista/nuevo')
                form.addClass('form-horizontal')

                modal.find('.modal-title').html('Crear un nuevo artista');
                modal.find('#md-btn-submit').val('Crear')
                modalBody.html(getTemplateForCreateTheme())

                $('#select-company').select2();

                modal.modal('show')
            })

            function getTemplateForCreateTheme() {
                return `
                    <div class="row">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Compañia</label>
                            <div class="col-sm-8">
                                <select id="select-company" name="company_id" class="form-control" style="width: 100%;">
                                    <option value="">Seleccionan una compañia</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Artista</label>
                            <div class="col-sm-8">
                                <input id="input-name-artist" type="text" name="name" class="form-control" />
                            </div>
                        </div>
                    </div>
                `
            }

            $.post('{{ route('clientes.get_artistas') }}', {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "search": $("#input-artist-name").val(),
                "paginate": $("#paginate_artista").val()
            }, function(res) {
                $("#sectArtistas").html(res);
                loadArt();
            })

            function loadArt() {
                $(".byAjaxArtistas .page-link").on("click", function(e) {
                    e.preventDefault();

                    var d_href = $(this).attr("href");
                    console.log(d_href);
                    $.post(d_href, {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "search": $("#input-artist-name").val(),
                        "paginate": $("#paginate_artista").val()
                    }, function(res) {
                        $("#sectArtistas").html(res);
                        loadArt();
                    });
                });
            }

            $("#md-btn-submit").on("click", function(e) {
                e.preventDefault();

                $.post('{{ route('artist.create') }}', $("#modal-default-form").serialize(), function(
                res) {
                    var modal = $('#modal-default')
                    modal.modal('hide');

                    $.post('{{ route('clientes.get_artistas') }}', {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "search": $("#input-artist-name").val(),
                        "paginate": $("#paginate_artista").val()
                    }, function(res) {
                        $("#sectArtistas").html(res);
                        loadArt();
                    })
                });
            });

            $("#btnBuscarArtista").on("click", function(e) {
                e.preventDefault();

                $.post('{{ route('clientes.get_artistas') }}', {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    "search": $("#input-artist-name").val(),
                    "paginate": $("#paginate_artista").val()
                }, function(res) {
                    $("#sectArtistas").html(res);
                    loadArt();
                })
            });
        })


        /* Vanilla JS to add a new task */
        function addTask() {
            /* Get task text from input */
            var inputTask = document.getElementById("taskText").value;
            /* Add task to the 'To Do' column */
            document.getElementById("to-do").innerHTML +=
                "<li class='task'><p>" + inputTask + "</p></li>";
            /* Clear task text from input after adding task */
            document.getElementById("taskText").value = "";
        }

        /* Vanilla JS to delete tasks in 'Trash' column */
        function emptyTrash() {
            /* Clear tasks from 'Trash' column */
            document.getElementById("trash").innerHTML = "";
        }
    </script>
@endsection
