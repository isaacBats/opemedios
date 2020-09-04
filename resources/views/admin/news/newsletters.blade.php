@extends('layouts.admin')
@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="col-sm-12 col-md-12">
        <div class="panel" id="panel-show-newsletters">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-6 col-xs-12">
                        <h4 class="panel-title" style="padding: 12px 0;">{{ __('Newsletters para esta noticia') }}</h4>
                    </div>
                    <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12 text-right">
                        <a href="javascript:void(0)" class="btn btn-success btn-quirk" id="btn-show-form-newsletter"><i class="fa fa-plus-circle"></i> {{ __('Agregar esta nota al un newsletter') }}</a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-inverse table-striped nomargin" id="table-newsletters">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-center">{{ __('Newsletter') }}</th>
                            <th class="text-center">{{ __('Tema') }}</th>
                            <th class="text-center">{{ __('Para enviar en') }}</th>
                            <th class="text-center">{{ __('Acciones') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($note->newsletters as $newsletter)
                            @php
                                $newsletter = $newsletter->where('news_id', $note->id)->first();
                            @endphp
                            <tr>
                                <td class="text-center" >{{ $loop->iteration }}</td>
                                <td class="text-left">{{ $newsletter->newsletter->name }}</td>
                                <td class="text-left">{{ $newsletter->theme->name }}</td>
                                <td class="text-center">{{ $newsletter->newsletter_send->created_at->format('d-m-Y') }}</td>
                                <td class="table-options">
                                    <a href="{{ route('admin.new.newletter.remove', ['id' => $note->id]) }}" data-name="{{ $newsletter->newsletter->name }}" data-newsletter="{{ $newsletter->id }}" class="btn-remove-newsletter"><i class="fa fa-remove"></i> {{ __('Remover') }}</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3"><p class="text-center" >Esta nota no pertenece a ningun newsletter</p></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel" style="display: none" id="panel-add-to-newsletter">
            <div class="panel-heading">
                <h4 class="panel-title">{{ __('Incluir en Newsletter') }}</h4>
                <hr>
            </div>
            <div class="panel-body">
                <div class="row">
                    <form action="{{ route('admin.new.newletter.include', ['id' => $note->id]) }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 col-md-3 col-lg-1 col-form-label" for="select-newsletter">{{ __('Newsletter') }}:</label>
                            <div class="col-sm-9 col-md-9 col-lg-11">
                                <select class="form-control" id="select-newsletter" name="newsletter_id">
                                    <option value="">{{ __('Selecciona un bloque de noticias') }}</option>
                                    @foreach($newsletters as $newsletterC)
                                        <option value="{{ $newsletterC->id }}" {{ (old('newsletter_id') == $newsletterC->id ? 'selected' : '' ) }} >{{ $newsletterC->name }}</option>
                                    @endforeach
                                </select>
                                @error('newsletter_id')
                                    <label class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row" id="div-select-nesletter-themes"></div>
                        <div class="form-group row" id="div-select-nesletter-sends"></div>
                        <hr>
                        <div class="form-group text-right">
                            <button class="btn btn-danger btn-lg" id="btn-cancel">{{ __('Cancelar') }}</button>
                            <input type="submit" class="btn btn-primary btn-lg" value="{{ __('Incluir') }}">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('lib/select2/select2.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            //show form
            $('#btn-show-form-newsletter').on('click', function(event) {
                event.preventDefault()
                $('#panel-add-to-newsletter').show('slow')
                $('#panel-show-newsletters').hide('fast')
            })

            //hide form
            $('#btn-cancel').on('click', function(event){
                event.preventDefault()
                $('#panel-add-to-newsletter').hide('fast')
                $('#panel-show-newsletters').show('slow')
            })

            $('#select-newsletter').on('change', function () {
                var newsletterId = $(this).val()
                $.post("{{ route('api.getnewsletterthemeshtml') }}", { '_token': $('meta[name="csrf-token"]').attr('content'), 'newsletter_id': newsletterId }, function(res){
                    var divSelectThemes = $('#div-select-nesletter-themes').html(res)
                    divSelectThemes.find('#select-newsletter-themes').select2()
                }).fail(function(res){
                    var divSelectThemes = $('#div-select-nesletter-themes').html(`<p>No se pueden obtener los temas del bloque</p>`)
                    console.error(`Error-Sections: ${res.responseJSON.message}`)
                })

                // get newsletters for send
                $.post("{{ route('api.getnewslettersendhtml') }}", { '_token': $('meta[name="csrf-token"]').attr('content'), 'newsletter_id': newsletterId }, function(res){
                    var divSelectSends = $('#div-select-nesletter-sends').html(res)
                    divSelectSends.find('#select-newsletter-sends').select2()
                }).fail(function(res){
                    var divSelectSends = $('#div-select-nesletter-sends').html(`<p>No se pueden obtener los templates para enviar notas</p>`)
                    console.error(`Error-Sections: ${res.responseJSON.message}`)
                })
            })

            $('#table-newsletters').on('click', '.btn-remove-newsletter', function(event) {
                event.preventDefault()
                var newsletterThemeNewsId = $(this).data('newsletter')
                var newsletterName = $(this).data('name')
                var action = $(this).attr('href')
                var modal = $('#modal-default')
                var form = modal.find('#modal-default-form')

                if($('#input-newslletter-theme').length > 0){
                    var input = $("#input-newslletter-theme").val(newsletterThemeNewsId)
                } else {
                    form.prepend($('<input>',{
                        type: 'hidden',
                        value: newsletterThemeNewsId,
                        name: 'newsletter_theme_news_id',
                        id: 'input-newslletter-theme'
                    }))
                }

                form.attr({
                    action: action,
                    method: 'POST'
                }).find('#md-btn-submit')
                    .addClass('btn-danger')
                    .val('Remover')

                modal.find('.modal-title').text('Remover noticia de Newsletter')
                modal.find('.modal-body').html(`<p>¿Estas seguro que quieres <strong>remover esta noticia del newsletter ${newsletterName}</strong>?<\p>`)

                modal.modal('show')
            })
        })
    </script>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('lib/select2/select2.css') }}">
@endsection
