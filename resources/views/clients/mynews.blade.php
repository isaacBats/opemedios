@extends('layouts.home')
@section('title', " - Mi contenido")
@section('content')
    @include('components.clientHeading')
    <!--Page Content -->
{{--    <div class="uk-padding op-content-mt main-content" style="background: rgba(184,165,165,0.6);">--}}
    <div class="uk-padding op-content-mt main-content">
        <div  id="list-news">
{{--            <div class="uk-background-muted">--}}
                <div class="uk-card uk-card-default uk-card-body" style="background: rgb(188,183,188);" uk-sticky>
                    <form type="GET" action="{{ route('client.mynews', ['company' => $company]) }}" class="uk-grid-small" uk-grid>
                        <div class="uk-widh-1-4@s">
                            <label class="uk-text-uppercase">Palabra:</label>
                            <input type="text" class="uk-input" name="word" value="{{ old('word') }}">
                        </div>
                        <div class="uk-width-1-4@s">
                            <label class="uk-text-uppercase">Tema:</label>
                            <select id="select-themes" class="uk-select uk-width-large" name="theme_id">
                                <option value="">**Todos**</option>
                                @foreach($company->themes as $theme)
                                <option value="{{ $theme->id }}" {{  old('theme_id') == $theme->id ? 'selected' : '' }}>{{ $theme->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="uk-width-1-4@s">
                            <label for="" class="uk-text-uppercase">Fecha inicio:</label>
                            <input type="date" class="uk-input" name="start_date" value="{{ old('start_date') }}">
                        </div>
                        <div class="uk-width-1-4@s">
                            <label for="" class="uk-text-uppercase">Fecha fin:</label>
                            <input type="date" class="uk-input" name="end_date" value="{{ old('end_date') }}">
                        </div>
                        <div class="uk-width-1-4@s">
                            <label for="" class="uk-text-uppercase">Medio:</label>
                            <select class="uk-select" name="mean" id="select-report-mean">
                                <option value="">** Todos **</option>
                                @foreach(App\Means::all() as $mean)
                                    <option value="{{ $mean->id }}" {{ (old('mean') == $mean->id ? 'selected' : '' ) }}>{{ $mean->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="uk-width-1-4@s" id="div-select-report-sources"></div>
                        <div class="uk-width-1-6@s">
                            <label for="" class="uk-text-uppercase">Paginación:</label>
                            <select class="uk-select" name="pagination" >
                                <option value="25" {{  old('pagination') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{  old('pagination') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{  old('pagination') == 100 ? 'selected' : '' }}>100</option>
                                <option value="150" {{  old('pagination') == 150 ? 'selected' : '' }}>150</option>
                            </select>
                        </div>
                        <div class="uk-width-1-6@s ">
                            <label for="" class="uk-text-uppercase">.</label>
                            <input type="submit" class="uk-input uk-button uk-button-default" value="Buscar">
                        </div>
                    </form>
                </div>
{{--            </div>--}}

            <div class="loader uk-container">Cargando...</div>

            <div id="news-by-theme">
                @include('components/listNews')
            </div>
        </div>
    </div>
    <!-- /.container -->
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('lib/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/jquery-ui/jquery-ui.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('lib/jquery/jquery.js') }}"></script>
    <script src="{{ asset('lib/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('lib/select2/select2.js') }}"></script>
    <script type="text/javascript">
         $(document).ready(function(){
            $('#select-report-mean').on('change', function(event) {
                getHTMLSources(event.target.value);
            });

            $('#select-themes').css('width', '100%').select2();

            function getHTMLSources(noteType) {
                $.post('{{ route('api.getsourceshtml') }}', { "_token": $('meta[name="csrf-token"]').attr('content'), 'mean_id': noteType }, function(res){
                    var divSelectSources = $('#div-select-report-sources').html(res);
                    divSelectSources.find('label.col-form-label').removeClass().addClass('uk-form-label');
                    divSelectSources.find('div.col-sm-10.col-md-11.col-lg-11').removeClass();
                    divSelectSources.find('#select-fuente').css('width', '100%').select2({
                        minimumInputLength: 3,
                        ajax: {
                            type: 'POST',
                            url: "{{ route('api.getsourceajax') }}",
                            dataType: 'json',
                            data: function(params, noteType) {
                                return {
                                    q: params.term,
                                    mean_id: $('select#select-report-mean').val(),
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
                    });
                }).fail(function(res){
                    const divSelectSources = $('#div-select-report-sources').html(`<p>No se pueden obtener las fuentes</p>`)
                    console.error(`Error-Sources: ${res.responseJSON.message}`)
                });
            }
         });
    </script>
@endsection
