@extends('layouts.admin')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @elseif(session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif
    <div class="row">
        {{-- <div class="panel"> --}}
            {{-- <div class="panel-body"> --}}
                <nav class="navbar navbar-inverse nav-margin-bt">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu-cloud-opemedios" aria-expanded="false">
                                <span class="sr-only">{{ __('Toggle navigation') }}</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a href="javascript:void(0);" class="navbar-brand">{{ __('Gestor de archivos') }}</a>
                        </div>
                        <div class="collapse navbar-collapse" id="menu-cloud-opemedios">
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="javascript:void(0)" id="btn-create-folder">{{ __('Crear Folder') }}</a></li>
                                <li><a href="#">Link 2</a></li>
                                <li><a href="#">Link 3</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
                {{-- <div class="panel"> --}}
                    {{-- <div class="panel body"> --}}
                        <div class="row filemanager">
                            <div class="col-md-3">
                                <nav class="nav-sidebar nav-sidebar-custom">
                                    <ul class="nav-custom">
                                        @forelse($folders as $folder)
                                            <li><i class="fa fa-folder-o"></i> {{ $folder->name }}</li>
                                        @empty
                                            <li>{{ __('No hay elementos que mostrar') }}</li>
                                        @endforelse
                                        {{-- <li class="active"><i class="fa fa-folder-o"></i> Documentos</li>
                                        <li><i class="fa fa-folder-open-o"></i> Documentos
                                            <ul class="nav-custom">
                                                <li><i class="fa fa-folder-o"></i> Documents _ 1</li>
                                            </ul>
                                        </li>
                                        <li><i class="fa fa-folder-o"></i> Documentos</li> --}}
                                    </ul>
                                </nav>
                            </div>
                            <div class="col-md-9">
                                {{-- <div class="row"> --}}
                                    <div class="col-md-12">
                                        <ol class="breadcrumb" id="cfm-breadcrumb">
                                            <li>{{ __('Cloud') }}</li>
                                        </ol>
                                    </div>
                                {{-- </div> --}}
                                @forelse($folders as $folder)
                                    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 folder">
                                        <div class="thmb">
                                            {{-- <label class="ckbox">
                                                <input type="checkbox"><span></span>
                                            </label> --}}
                                            <div class="btn-group fm-group">
                                                <button type="button" class="btn btn-default dropdown-toggle fm-toggle" data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu pull-right fm-menu" role="menu">
                                                    {{-- <li><a href="#"><i class="fa fa-share"></i> Share</a></li> --}}
                                                    <li><a href="#"><i class="fa fa-pencil"></i> {{ __('Cambiar Nombre') }}</a></li>
                                                    {{-- <li><a href="#"><i class="fa fa-download"></i> Download</a></li> --}}
                                                    <li><a href="#"><i class="fa fa-trash-o"></i> {{ __('Eliminar') }}</a></li>
                                                </ul>
                                            </div><!-- btn-group -->
                                            <div class="thmb-prev">
                                                <a href="javascript:void(0)" data-folder="{{ $folder->name }}" class="img-folder-click"><img src="{{ asset('images/folder.png') }}" class="img-responsive" alt="" /></a>
                                                {{-- <i class="fa fa-folder-o fa-14x img-responsive"></i> --}}
                                            </div>
                                            <h5 class="fm-title"><a href="">{{ $folder->name }}</a></h5>
                                            {{-- <small class="text-muted">Added: July 1, 2015</small> --}}
                                        </div><!-- thmb -->
                                    </div><!-- col-xs-6 -->
                                @empty
                                    <p>{{ __('No hay elementos que mostrar') }}</p>
                                @endforelse
                            </div>
                        </div>
                    {{-- </div> --}}
                {{-- </div> --}}
            {{-- </div> --}}
        {{-- </div> --}}
    </div>
@endsection
@section('styles')
    <style>
        .fa-14x {
            font-size: 14rem;
        }

        .folder .filemanager .thmb-prev {
            /*background-color: none;*/
        }
        .nav-custom {
            list-style: none;
        }

        .nav-custom-second {
            list-style: none;
            margin-top: 4px;
        }

        .nav-custom li {
            margin-bottom: 4px;
        }
        .nav-sidebar-custom {
            background-color: #d8dce3;
            padding: 15px 0;
        }
        .nav-margin-bt {
            margin-bottom: unset !important;
        }

    </style>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){

            //Create folder function
            $('#btn-create-folder').on('click', function (event) {
                event.preventDefault()
                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var lastFolder = $('ol#cfm-breadcrumb > li:last-child')
                var cfmBreadcrumb = $('ol#cfm-breadcrumb')

                form.attr('method', 'POST')
                    .attr('action', '{{ route("cfm.create.folder") }}')
                    .addClass('form-horizontal')
                    .append($('<input>').attr({
                        type: 'hidden',
                        name: 'last-folder',
                        value: lastFolder.text()
                    }))
                    .append($('<input>').attr({
                        type: 'hidden',
                        name: 'level',
                        value: cfmBreadcrumb.children.length
                    }))

                modal.find('.modal-title').text('Carpeta Nueva')
                modal.find('.modal-body').html(`
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nombre de la carepeta</label>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control" placeholder="Carpeta" required />
                        </div>
                    </div>
                `)
                modal.find('#md-btn-submit').val('Crear')
                modal.modal('show')
            })

            // Click in folder
            $('.filemanager').on('click', '.img-folder-click', function(event){
                event.preventDefault()
                var folderName = $(this).data('folder')
                alert(`Estas dando click en el folder ${folderName}`)
            })
        })
        
    </script>
    <script>
        jQuery(document).ready(function(){
            'use strict';

            jQuery('.thmb').hover(function(){
                var t = jQuery(this);
                t.find('.ckbox').show();
                t.find('.fm-group').show();
            }, function() {
                var t = jQuery(this);
                if(!t.closest('.thmb').hasClass('checked')) {
                    t.find('.ckbox').hide();
                    t.find('.fm-group').hide();
                }
            });

            jQuery('.ckbox').each(function(){
                var t = jQuery(this);
                var parent = t.parent();
                if(t.find('input').is(':checked')) {
                    t.show();
                    parent.find('.fm-group').show();
                    parent.addClass('checked');
                }
            });


            jQuery('.ckbox').click(function(){
                var t = jQuery(this);
                if(!t.find('input').is(':checked')) {
                    t.closest('.thmb').removeClass('checked');
                    enable_itemopt(false);
                } else {
                    t.closest('.thmb').addClass('checked');
                    enable_itemopt(true);
                }
            });

            jQuery('#selectall').click(function(){
                if(jQuery(this).is(':checked')) {
                    jQuery('.thmb').each(function(){
                        jQuery(this).find('input').attr('checked',true);
                        jQuery(this).addClass('checked');
                        jQuery(this).find('.ckbox, .fm-group').show();
                    });
                    enable_itemopt(true);
                } else {
                    jQuery('.thmb').each(function(){
                        jQuery(this).find('input').attr('checked',false);
                        jQuery(this).removeClass('checked');
                        jQuery(this).find('.ckbox, .fm-group').hide();
                    });
                    enable_itemopt(false);
                }
            });

            function enable_itemopt(enable) {
                if(enable) {
                    jQuery('.itemopt').removeClass('disabled');
                } else {
                    // check all thumbs if no remaining checks
                    // before we can disabled the options
                    var ch = false;
                    jQuery('.thmb').each(function(){
                        if(jQuery(this).hasClass('checked'))
                            ch = true;
                    });

                    if(!ch)
                        jQuery('.itemopt').addClass('disabled');
                }
            }

            // jQuery("a[data-rel^='prettyPhoto']").prettyPhoto();
        });

    </script>
@endsection