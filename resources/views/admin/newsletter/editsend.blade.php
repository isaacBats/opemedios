@extends('layouts.admin')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="col-lg-6 col-md-8 col-sm-6 col-xs-12">
                    <h3 class="panel-title">Newsletter #{{ $newsletterSend->id }} para {{ $newsletterSend->newsletter->name }}</h3>
                </div>
                <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12 text-right">
                    <a id="btn-add-note" href="javascript:void(0)" class="btn btn-success btn-quirk"><i class="fa fa-plus-circle"></i> {{ __('Agregar Nota') }}</a>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <ul class="media-list">
                        @foreach($newsletterSend->newsletter->company->themes as $theme)
                            <li>
                                <h2 class="block-title">{{ $theme->name }}</h2>
                                <hr>
                                <ul class="media-list">
                                    @forelse($newsletterSend->newsletter_theme_news as $ntn)
                                        @if($ntn->newsletter_theme_id == $theme->id)
                                            <li class="media">
                                                <div class="media-left">
                                                    <img class="media-object" src="https://ui-avatars.com/api/?name={{ $loop->iteration }}&size=32&background=0D8ABC&color=fff" alt="...">
                                                </div>
                                                <div class="media-body">
                                                    <u><a class="" href="{{ route('admin.new.show', ['id' => $ntn->news->id]) }}" target="_blank"><h4 class="media-heading">{{ $ntn->news->title }}</h4></a></u>
                                                    <p>
                                                        <small><strong>{{ "OPE-{$ntn->news->id}" }}</strong></small> <br />
                                                        {!! Illuminate\Support\Str::limit($ntn->news->synthesis, 120) !!}
                                                    </p>
                                                    <p class="text-right">
                                                        <a href="" class="text-danger"><i class="fa fa-times"></i> {{ __('Remover') }}</a>
                                                    </p>
                                                </div>
                                            </li>
                                        @endif
                                    @empty
                                        <li class="media"><p>{{ __('No hay noticias en este tema') }}</p></li>
                                    @endforelse
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-12 text-right mt-1">
                    <a href="{{ route('admin.newsletter.edit.send', ['id' => $newsletterSend->id]) }}" class="btn btn-primary btn-lg">{{ __('Guardar') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $('#btn-add-note').on('click', function (event) {
                event.preventDefault()
                var modal = $('#modal-default')
                var form = $('#modal-default-form')

                form.attr('action', '{{ route('api.news.getnotesbyidortitle') }}')
                form.addClass('form-horizontal')
                form.attr('method', 'POST')

                modal.find('.modal-title').text('Buscar noticia')
                modal.find('.modal-body').html(`
                    <div class="form-group">
                        <label for="newsid" class="col-sm-3 control-label">Buscar por ID: OPE-</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="newsid" id="newsid" placeholder="346">
                        </div>
                        @error('newsid')
                            <label class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="newstitle" class="col-sm-3 control-label text-right">Buscar por título</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="newstitle" id="newstitle" placeholder="Título de la noticia">
                        </div>
                        @error('newstitle')
                            <label class="error" role="alert">
                                <strong>{{ $message }}</strong>
                            </label>
                        @enderror
                    </div>
                    <input type="hidden" name="newssend" value={{ $newsletterSend->id }} >
                `)
                modal.find('#md-btn-submit').val('Buscar')
                modal.modal('show')
            })
            
            // submit form for add news
            $('#modal-default').on('click', '#md-btn-submit', function(event) {
                event.preventDefault()
                var form = $('#modal-default-form')
                $.post(form.attr('action'), form.serialize(), function (req){
                    if(req.status == 'OK') {
                        var modal = $('#modal-default')
                        var formsec = $('#modal-default-form')
                        var divSelect = $('<div class="form-group">')
                        var divItems = $('<div id="div-items-form">')
                        var selectThemes = $('<select class="form-control" name="themeid">')
                        var defaultOption = $('<option>', {
                            value: '',
                            text: 'Selecciona un Tema'
                        })

                        selectThemes.append(defaultOption)
                        $.each(req.themes, function (index, theme){
                            selectThemes.append($('<option>',{
                                value: theme.id,
                                text: theme.name
                            }))
                        })
                        divSelect.append($('<label>', {
                            class: 'col-sm-3 control-label text-right',
                            text: 'Tema'
                        })).append($('<div class="col-sm-8">').append(selectThemes))



                        if(req.note) {
                            var divNote = getItemForNoteTemplate(req.note)
                            divItems.append(divNote)
                                .append(divSelect)
                                .append($('<input>', {
                                    type: 'hidden',
                                    name: 'multi',
                                    value: false
                                }))
                            modal.find('.modal-title').text('Agregar noticia')
                            formsec.attr('action', '{{ route('api.newslettersend.addnote') }}')
                            formsec.addClass('form-horizontal')
                            formsec.attr('method', 'POST')

                            modal.find('.modal-body').html(`
                                <input type="hidden" name="newssend" value={{ $newsletterSend->id }} >
                                <input type="hidden" name="newsletterid" value={{ $newsletterSend->newsletter->id }} >
                            `).append(divItems)
                            modal.find('#md-btn-submit').val('Agregar')
                        } else if(req.notes) {
                            $.each(req.notes, function(index, note) {

                            })
                        }
                    }
                })
            })

            function getItemForNoteTemplate (note) {
                return $('<div class="form-group" >')
                    .append($('<label>', {
                        class: 'col-sm-3 control-label text-right',
                        text: 'Titulo'
                    }))
                    .append($('<input>', {
                        type: 'hidden',
                        name: 'news_id',
                        value: note.id
                    }))
                    .append($('<div>', {
                        class: 'col-sm-8'
                        })
                        .append($('<input>', {
                            type: 'text',
                            class: 'form-control',
                            value: note.title,
                            disabled: true
                        }))
                    )
            }
        })
    </script>
@endsection
