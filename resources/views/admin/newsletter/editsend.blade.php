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
                    <a id="btn-add-note" href="{{ route('admin.newsletter.send.add.note', ['id' => $newsletterSend->id]) }}" class="btn btn-success btn-quirk"><i class="fa fa-plus-circle"></i> {{ __('Agregar Nota') }}</a>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-md-8">
                    <form action="{{ route('api.news.getnotesbyidortitle') }}" class="form-horizontal" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="newsid" class="col-sm-3 control-label">Buscar por ID: OPE-</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="newsid" id="newsid" placeholder="346">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="newstitle" class="col-sm-3 control-label text-right">Buscar por título</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="newstitle" id="newstitle" placeholder="Título de la noticia">
                            </div>
                        </div>
                        <input type="hidden" name="newssend" value={{ $newsletterSend->id }} >
                        <div class="col-sm-2 col-sm-offset-9 text-right">
                            <input type="submit" id="btn-form-search-news" class="btn btn-info" value="Buscar"> 
                        </div>
                    </form>
                </div>
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

                modal.find('.modal-title').text('Buscar noticia')
                modal.modal('show')
            })
            //
            // $('ul#sections').on('click', 'li.list-group-item.section-view div.btns a.btn-data-delete', function (event) {
            //     event.preventDefault()
            //
            //     var sectionId = $(this).data('sectionid')
            //     var form = $('#form-modal-delete-section')
            //     var modal = $('#modalDeleteSection')
            //
            //     form.attr('action', `/newsletter/seccion/delete/${sectionId}`)
            //
            //     modal.modal('show')
            //
            // })
        })
    </script>
@endsection
