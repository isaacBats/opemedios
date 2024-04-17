@extends('layouts.admin')
@section('admin-title', ' - Empresas')
@section('styles')
<style>
    .menu-ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        background-color: #333333;
    }
    
    .menu-ul > li {
        float: left;
    }

    .menu-ul >li a {
        display: block;
        color: white;
        text-align: center;
        padding: 16px 60px;
        text-decoration: none;
    }

    .menu-ul > li a:hover {
        background-color: #111111;
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
                                    @foreach(App\Models\Turn::all() as $turn)
                                        <option
                                            value="{{ $turn->id }}" {{ request()->get('turn') == $turn->id ? 'selected' : '' }}>{{ $turn->name }}</option>
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
                                @if(request()->has('name') || request()->has('turn') )
                                    <a href="{{ route('companies') }}" class="btn btn-warning ml-2"
                                       style="margin-left: .8em"> Limpiar filtros </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
                <span id="span-count-info" class="people-count pull-right">Mostrando <strong id="num-rows-info">{{ $companies->count() }} de {{ $companies->total() }}</strong> empresas</span>
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
            </div> */ ?>
            <div class="panel-body">
                <div class="table-responsive">
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

                </div><!-- table-responsive -->
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
                                    <button id="btn-add-artist" class="btn btn-success btn-quirk" type="button">{{ __('Agregar Artista') }}</button>
                                </div>
                            </div>
                        </div>
                           
                        <div class="col-md-8 pull-right" role="toolbar">
                            <div class="col-md-offset-4 col-md-4 form-group">
                                <label for="input-sector-name" class="text-muted">Nombre</label>
                                <input type="text" name="name" class="form-control" id="input-artist-name" value="{{ request()->get('name') }}">
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
                                @if(request()->has('name'))
                                    <a href="#" class="btn btn-warning ml-2" style="margin-left: .8em" id=""> Limpiar filtros </a>
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
    <script type="text/javascript">
        $(document).ready(function () {
            // Modal for delete a company
            $('#table-company-list').on('click', '.btn-delete-company', function (event) {
                event.preventDefault()
                var companyName = $(this).data('name')
                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var urlAction = $(this).attr('href')

                form.attr('action', urlAction)
                form.attr('method', 'POST')

                modal.find('.modal-title').text(`Eliminar Empresa`)
                modal.find('#md-btn-submit').removeClass('btn-primary').addClass('btn-danger').val("{{ __('Eliminar') }}")
                modal.find('.modal-body').html(`¿{{ __('Estas seguro que quieres eliminar a ') }}<strong>${companyName}</strong>?
                    <br />
                    <p>Si eliminas la empresa ${companyName} tambien se van a borrar las cuentas y los temas asociados a la empresa.</p>
                `)
                modal.modal('show')
            });
            
            $(".btnCollapse").on("click", function(){
                var currentItem = $(this).data('id');
                var sections = ["collapseClientes", "collapseTemas", "collapsePeliculas", "collapseArtistas", "collapseLibros"];

                sections.forEach(function(item){

                    if(currentItem != item) $('#' + item).collapse('hide');
                    else $('#' + item).collapse('show');

                });

            });

            $.post('{{route('clientes.get_libros')}}', { "_token": $('meta[name="csrf-token"]').attr('content') }, function(res){
                $("#sectLibros").html(res);
                loadI();
            })
            
            $.post('{{route('clientes.get_peliculas')}}', { "_token": $('meta[name="csrf-token"]').attr('content') }, function(res){
                $("#sectPeliculas").html(res);
                loadP();
            })

            function loadI()
            {
                $(".byAjaxLibros .page-link").on("click", function(e){
                    e.preventDefault();

                    var d_href = $(this).attr("href");
                    console.log(d_href);
                    $.post(d_href, { "_token": $('meta[name="csrf-token"]').attr('content') }, function(res){
                        $("#sectLibros").html(res);
                        loadI();
                    });
                });
            }
            
            function loadP()
            {
                $(".byAjaxPeliculas .page-link").on("click", function(e){
                    e.preventDefault();

                    var d_href = $(this).attr("href");
                    console.log(d_href);
                    $.post(d_href, { "_token": $('meta[name="csrf-token"]').attr('content') }, function(res){
                        $("#sectPeliculas").html(res);
                        loadP();
                    });
                });
            }
            
            
            //create theme
            $('#btn-add-artist').on('click', function(){
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
                                    @foreach($companies as $company)
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

            $.post('{{route('clientes.get_artistas')}}', {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "search" :  $("#input-artist-name").val(),
                "paginate": $("#paginate_artista").val()
            }, function(res){
                $("#sectArtistas").html(res);
                loadArt();
            })

            function loadArt()
            {
                $(".byAjaxArtistas .page-link").on("click", function(e){
                    e.preventDefault();

                    var d_href = $(this).attr("href");
                    console.log(d_href);
                    $.post(d_href, { "_token": $('meta[name="csrf-token"]').attr('content'),
                        "search" :  $("#input-artist-name").val(),
                        "paginate": $("#paginate_artista").val()
                    }, function(res){
                        $("#sectArtistas").html(res);
                        loadArt();
                    });
                });
            }

            $("#md-btn-submit").on("click", function(e){
                e.preventDefault();

                $.post('{{route('artist.create')}}', $("#modal-default-form").serialize(), function(res){
                    var modal = $('#modal-default')
                    modal.modal('hide'); 
                    
                    $.post('{{route('clientes.get_artistas')}}', { "_token": $('meta[name="csrf-token"]').attr('content'),
                        "search" :  $("#input-artist-name").val(),
                        "paginate": $("#paginate_artista").val()
                    }, function(res){
                        $("#sectArtistas").html(res);
                        loadArt();
                    })
                });
            });

            $("#btnBuscarArtista").on("click", function(e){
                e.preventDefault();
                
                $.post('{{route('clientes.get_artistas')}}', { "_token": $('meta[name="csrf-token"]').attr('content'),
                    "search" :  $("#input-artist-name").val(),
                    "paginate": $("#paginate_artista").val()
                }, function(res){
                    $("#sectArtistas").html(res);
                    loadArt();
                })
            });
        })
    </script>
@endsection
