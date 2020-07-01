@extends('layouts.admin')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title" style="padding: 12px 0;">{{ __('Enviar noticia #:') }}<span>{{ "OPE-{$note->id}" }}</span></h4>
            </div>
            <div class="panel-body">
                {{-- <h4>{{ __("Noticia #:") }}<span style="color: #d9534f">{{ "OPE-{$note->id}" }}</span></h4> --}}
                <h2>{{ $note->title }}</h2>
                <p class="lead">{!! $note->synthesis!!}</p>
                <small>{{ "{$note->source->name}({$note->section->name})" }}</small>
                <br>
                <br>
                <p>
                    {{ __('Archivo principal: ') }}
                    @if($mainFile)
                        <a href="{{ $mainFile->path_filename }}" target="_blank">{{ $mainFile->original_name }}</a>
                    @else
                        {{ __('Esta nota no tiene archivos adjuntos, pueder agregar un archivo: ') }}<a href="{{ route('admin.new.adjunto.show', ['id' => $note->id]) }}">{{ __('Aquí') }}</a>
                    @endif
                </p>
                <p>
                    {{ __('Archivos secundarios: ') }}
                    <ol>
                        @forelse($note->files->where('main_file', '<>', 1) as $secondary)
                            <li><a href="{{ $secondary->path_filename }}" target="_blank">{{ $secondary->original_name }}</a></li>
                        @empty
                            <p>{{ __('No hay mas archivos') }}</p>
                        @endforelse
                    </ol>
                </p>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <label for="select-company">{{ __('Buscar cliente:') }}</label>
                        <select name="company_id" id="select-company" class="form-control"></select>
                    </div>
                    <div class="col-sm-12 col-md-6" id="div-select-theme"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6" id="div-accounts-list"></div>
            <div class="col-sm-12 col-md-6" id="div-send-news"></div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('lib/select2/select2.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            // Select company combo
            $('#select-company').select2({
                minimumInputLength: 3,
                ajax: {
                    type: 'POST',
                    url: "{{ route('api.getcompaniesajax') }}",
                    dataType: 'json',
                    data: function(params, noteType) {
                        return {
                            q: params.term,
                            "_token": $('meta[name="csrf-token"]').attr('content')
                        } 
                    },
                    processResults: function(data) {
                        return {
                            results: data.items
                        }
                    },
                    cache: true
                }
            })

            // show select with themes when channge a company
            $('#select-company').on('change', function(){
                var companyId = $(this).val()
                var divAccountsList = $('#div-accounts-list')
                divAccountsList.html('') 

                $.post('{{ route('api.getthemeshtml') }}', { "_token": $('meta[name="csrf-token"]').attr('content'), 'company_id': companyId }, function (res) {
                    var divSelectThemes = $('#div-select-theme')
                    divSelectThemes.html(res)
                })

                $.post('{{ route('api.company.getaccounts') }}', { "_token": $('meta[name="csrf-token"]').attr('content'), 'company_id': companyId }, function(res) {
                    var table = $('<table>').addClass('table table-bordered table-primary table-striped nomargin').html(
                        `<thead>
                            <tr>
                                <th class="text-center">
                                    <label class="ckbox ckbox-primary">
                                        <input type="checkbox" id="input-checkbox-select-all"><span></span>
                                    </label>
                                </th>
                                <th>Email</th>
                                <th>Nombre</th>
                            </tr>
                        </thead>`
                    )
                    var tableBody = table.append($('<tbody>', { id: 'tboby-account-list' }))
                    $.each(res, function (key, item){
                        tableBody.append($('<tr>').append(
                            $('<td>').addClass('text-center').append(
                                $('<label>').addClass('ckbox ckbox-primary')
                                    .append(
                                        $('<input>', {
                                            type: 'checkbox',
                                            name: 'accounts[]',
                                            value: item.id
                                        }).addClass('input-checkbox-account')
                                    )
                                    .append($('<span>'))
                            )
                        ).append(
                            $('<td>').text(item.email)
                        )
                        .append($('<td>').text(item.name)))
                    })
                    divAccountsList.append($('<div>', { id: 'div-panel-account-list' }).addClass('panel')
                        .append($('<div>').addClass('panel-heading').append($('<h4>').addClass('panel-title').text('Cuentas')))
                        .append($('<div>').addClass('panel-body').append($('<div>').addClass('table-responsive').append(table)))
                    )
                })
            })

            // Checkbox sellect all accounts
            $('#div-accounts-list').on('change','#input-checkbox-select-all', function() {
                var checkboxes = $('.input-checkbox-account')
                checkboxes.prop('checked', $(this).is(':checked'));
            })

            // show panel for send new
            $('#div-select-theme').on('change', '#select-theme', function(){
                var themeId = $(this).val()

                $.post('{{ route('api.theme.getaccounts') }}', { "_token": $('meta[name="csrf-token"]').attr('content'), 'theme_id': themeId }, function(res) {
                    var divSendNews = $('#div-send-news')
                    var emails = res.map(function(item) { 
                            return `<strong>${item.email}</strong> (${item.name})` 
                    })

                    var accountsIds = res.map(function(item) { 
                            return item.id 
                    })

                    var pEmailList = $('<p>').html(`La nota se enviara a los siguientes correos: ${emails}`)
                    var panelSendNews = $('#panel-send-news')
                    var btnSend = $('<input>', {
                        type: 'submit',
                        class: 'btn btn-primary',
                        value: 'Enviar'
                    })
                    
                    if(panelSendNews.length == 0) {
                        divSendNews.append($('<div>', { id: 'panel-send-news' }).addClass('panel')
                            .append($('<div>').addClass('panel-heading').append($('<h4>').addClass('panel-title').text('Enviar nota a:')))
                            .append($('<div>').addClass('panel-body')
                                .append($('<form>', {
                                    method: 'POST',
                                    action: '{{ route('admin.new.send.news') }}'
                                })
                                    .append($('<input>', {
                                        type: 'hidden',
                                        name: '_token',
                                        value: $('meta[name="csrf-token"]').attr('content')
                                    }))
                                    .append($('<input>', {
                                        type: 'hidden',
                                        name: 'theme_id',
                                        value: themeId
                                    }))
                                    .append($('<input>', {
                                        type: 'hidden',
                                        name: 'news_id',
                                        value: '{{ $note->id }}'
                                    }))
                                    .append($('<input>', {
                                        type: 'hidden',
                                        name: 'accounts_ids',
                                        value: accountsIds
                                    }))
                                    .append(pEmailList)
                                    .append(btnSend)
                        )))
                    } else {
                        panelSendNews.find('.panel-body').html(pEmailList)
                    }

                    panelSendNews.find('.panel-body').append(btnSend)

                    // vamos a ver como checkeamos los correos que estan en la lista de envios
                    var inputChecks = $('#tboby-account-list')
                })
            })
        })
    </script>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('lib/select2/select2.css') }}">
@endsection
