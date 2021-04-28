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
                    <h3 class="panel-title">Newsletter #{{ $newsletterSend->id }} para {{ $newsletterSend->newsletter->name }} - {{ $newsletterSend->label }}</h3>
                </div>
                <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12 text-right" id="btn-search-note">
                    <a id="btn-add-note" href="javascript:void(0)" class="btn btn-success btn-quirk"><i class="fa fa-plus-circle"></i> {{ __('Agregar Nota') }}</a>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-md-12" id="panel-body-form" style="display: none;">
                    <form action="{{ route('api.news.getnotesbyidortitle') }}" class="form-horizontal" method="POST" id="form-search-note">
                        @csrf
                        <input type="hidden" name="newssend" value="{{ $newsletterSend->id }}" >
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
                        <div class="col-md-2 col-md-offset-10">
                            <button class="btn btn-default" id="btn-cancel-submit-form-search-note">Cancelar</button>
                            <input type="submit" value="Buscar" id="btn-submit-form-search-note" class="btn btn-success">
                        </div>
                    </form>
                </div>
                <div class="col-md-12" id="panel-body-response"></div>
                <div class="col-md-12" id="panel-body-list">
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
                                                    <img class="media-object" src="https://ui-avatars.com/api/?name={{ $theme->name }}&size=32&background=0D8ABC&color=fff" alt="...">
                                                </div>
                                                <div class="media-body">
                                                    <u><a class="" href="{{ route('admin.new.show', ['id' => $ntn->news->id]) }}" target="_blank"><h4 class="media-heading">{{ $ntn->news->title }}</h4></a></u>
                                                    <p>
                                                        <small><strong>{{ "OPE-{$ntn->news->id}" }}</strong></small> <br />
                                                        {!! Illuminate\Support\Str::limit($ntn->news->synthesis, 120) !!}
                                                    </p>
                                                    <p class="text-right">
                                                        <a href="javascript:void(0);" class="text-danger btn-newssend-remove" data-theme="{{ $theme->name }}" data-title="{{ $ntn->news->title }}" data-ntn="{{ $ntn->id }}"><i class="fa fa-times"></i> {{ __('Remover') }}</a>
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
                    <a id="btn-return" href="{{ route('admin.newsletter.view', ['id' => $newsletterSend->newsletter->id]) }}" class="btn btn-primary btn-lg">{{ __('Regresar') }}</a>
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
                var divForm = $('#panel-body-form')
                var form = $('#form-search-note')
                var divListNewsletter = $('#panel-body-list')
                var button = $(this)
                var buttonReturn = $('#btn-return')

                button.hide('fast')
                buttonReturn.hide('fast')
                divListNewsletter.hide('fast')
                divForm.show('slow')  
            })

            $('#btn-cancel-submit-form-search-note').on('click', function(event) {
                event.preventDefault()
                var divForm = $('#panel-body-form')
                var form = $('#form-search-note')
                var divListNewsletter = $('#panel-body-list')
                var buttonAddNote = $('#btn-add-note')
                var buttonReturn = $('#btn-return')

                buttonAddNote.show('slow')
                buttonReturn.show('slow')
                divListNewsletter.show('slow')
                divForm.hide('fast')  
            })
            
            // submit form for get news
            $('#panel-body-form').on('click', '#btn-submit-form-search-note', function(event) {
                event.preventDefault()
                var form = $('#form-search-note')
                var divResult = $('#panel-body-response')
                
                $.post(form.attr('action'), form.serialize(), function (req){
                    var divForm = $('#panel-body-form')
                    if(req.status == 'OK') {
                        divForm.hide('fast')
                        divResult.html(req.html)
                        divResult.append($('<a href="javascript:window.location.reload(true);" style="font-size: 20px; display: block; ">Regresar</a>'))
                    } else {
                        divForm.hide('fast')
                        divResult.html(`<p>No se encontraron resultados...</p>`)
                        divResult.append($('<a href="javascript:window.location.reload(true);" style="font-size: 20px; display: block; ">Regresar</a>'))
                    }
                })

            })

            // submit add news
            $('#panel-body-response').on('click', '.btn-send-news-form-newsletter', function(event) {
                event.preventDefault()
                var form = $(this).parent().parent('form')
                $.post(form.attr('action'), form.serialize(), function(res){
                    var divAdded = form.parent('div')
                    $.gritter.add({
                        title: 'Nueva noticia',
                        text: res.message,
                        class_name: 'with-icon check-circle success'
                    })
                    divAdded.hide('slow')
                }).fail(function (){
                    $.gritter.add({
                        title: 'Nueva noticia',
                        text: 'El tema es requerido. Selecciona un tema',
                        class_name: 'with-icon times-circle danger'
                    })
                    return 0;
                })
                reloadPage()
            })
            
            function reloadPage() {
                var notes = $('#panel-body-response > div:not([style*="display: none"])').length -1
                if( notes == 0) {
                    window.location.reload()
                }
            }

            // remove note 
            $('#panel-body-list').on('click', '.btn-newssend-remove', function(event) {
                event.preventDefault()
                var ntnId = $(this).data('ntn')
                var title = $(this).data('title')
                var theme = $(this).data('theme')
                var modal = $('#modal-default')
                var form = $('#modal-default-form')
                var btnSubmit = form.find('#md-btn-submit')
                var nodeParent = $(this).parent().parent().parent('li')
                nodeParent.attr('id', 'remove-element')

                modal.find('.modal-title').text('Eliminar nota')
                modal.find('.modal-body').html(`<p>Vas a eliminar la nota <strong>${title}</strong> del tema <strong>${theme}</strong>>.</p>
                <p class="text-center" style="font-size: 16px; "><strong>¿Estas seguro?</strong></p>`)
                form.attr('action', "{{ route('admin.newsletter.send.remove.note') }}")
                form.attr('method', 'POST')
                form.append($('<input>', {type: 'hidden', name: 'ntn', value: ntnId}))
                btnSubmit.val('Eliminar')

                modal.modal('show')

            })

            $('#md-btn-submit').on('click', function(event) {
                event.preventDefault()
                var form = $('#modal-default-form')
                var modal = $('#modal-default')
                var element = $('#remove-element')
                
                modal.modal('hide')

                $.post(form.attr('action'), form.serialize(), function(res) {
                    $.gritter.add({
                        title: 'Eliminar nota',
                        text: res.message,
                        class_name: 'with-icon check-circle success'
                    })
                    element.hide("slow", function(){ $(this).remove() })

                }).fail(function(){
                    $.gritter.add({
                        title: 'Eliminar nota',
                        text: 'No es posible eliminar esta nota!',
                        class_name: 'with-icon times-circle danger'
                    })
                })

            })
        })
    </script>
@endsection
