@extends('layouts.admin')
@section('admin-title', '- Reportes por cliente')
@section('content')
    <div class="row">
        <div class="col-sm-12 people-list">
            <div class="people-options clearfix">
                <div class="btn-toolbar">
                    <form action="{{ route('admin.report.byclient') }}" method="GET">
                        <div class="row">
                            <div class="col-md-2 form-group">
                                <select name="company" class="form-control mt-2" id="report-select-company" style="width: 100%;">
                                    <option value="">Selecciona un cliente</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 form-group">
                                <select class="form-control select-select2" style="width: 100%;" name="" id="">
                                    <option value="">Sector</option>
                                    @foreach(App\Sector::all() as $sector)
                                        <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 form-group">
                                <select class="form-control select-select2" style="width: 100%;" name="" id="">
                                    <option value="">Genero</option>
                                    @foreach(App\Genre::all() as $genre)
                                        <option value="{{ $genre->id }}"> {{ $genre->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 form-group">
                                <select class="form-control select-select2" style="width: 100%;" name="" id="">
                                    <option value="">Fuente</option>
                                </select>
                            </div>
                            <div class="col-md-2 form-group">
                                <select class="form-control select-select2" style="width: 100%;" name="" id="">
                                    <option value="">Medio</option>
                                    @foreach(App\Means::all() as $mean)
                                        <option value="{{ $mean->id }}">{{ $mean->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 form-group">
                                <label for="" class="text-muted">Fecha inicio</label>
                                <div class="input-group">
                                    <input type="date" name="fstart" class="form-control">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-calendar"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="" class="text-muted">Fecha fin</label>
                                <div class="input-group">
                                    <input type="date" name="fend" class="form-control">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 form-group">
                                <button type="submit" class="btn btn-primary"> Buscar</button>
                            </div>
                        </div>
                    </form>

                </div>
                {{-- <div class="btn-group pull-right">
                    <a href="" class="btn btn-warning">Exportar</a>
                </div> --}}

                <div class="btn-group pull-right people-pager" id="btns-paginate">
                    <button type="button" class="btn btn-default"><i class="fa fa-chevron-left"></i></button>
                    <button type="button" class="btn btn-default"><i class="fa fa-chevron-right"></i></button>
                </div>
                <span id="span-count-info" class="people-count pull-right">Mostrando <strong id="num-rows-info">0 de 0</strong> noticias</span>
            </div><!-- people-options -->
            <div id="div-table-notes">
                
            </div>
        </div>
    </div>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('lib/select2/select2.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('lib/select2/select2.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            $('#report-select-company').select2();
            $('.select-select2').select2();
            
            // select news by company
            $('#report-select-company').on('change', function(event){
                var optionSelected = event.target.value;

                $.get('{{ route('admin.report.byclient') }}', { "_token": $('meta[name="csrf-token"]').attr('content'), 'company': optionSelected }, function(res){
                    var btnPaginates = $('ul.pagination');
                    var finalNum = res.firstitem + res.count -1;

                    $('#div-table-notes').html(res.render);
                    $('#num-rows-info').text(`${res.firstitem}-${finalNum}`);
                    $('#btns-paginate').html(btnPaginates);
                });
            });

            // pagination
            $(document).on('click', '.pagination a', function (e) {
                getPosts($(this).attr('href').split('page=')[1]);
                e.preventDefault();
            });

            function getPosts(page) {
                var company = $('#report-select-company').val();

                $.ajax({
                    type: 'GET',
                    url : `/panel/reportes/por-cliente?page=${page}`,
                    data: {
                        '_token': $('meta[name=csrf-token]').attr('content'),
                        'company': company
                    },
                }).done(function (data) {

                    var finalNum = data.firstitem + data.count - 1;

                    $('#div-table-notes').html(data.render);
                    $('#num-rows-info').text(`${data.firstitem}-${finalNum}`);
                    location.hash = page;
                }).fail(function () {
                    alert('Posts could not be loaded.');
                });
            }
        });
        
    </script>
@endsection