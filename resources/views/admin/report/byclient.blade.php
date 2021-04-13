@extends('layouts.admin')
@section('admin-title', '- Reportes por cliente')
@section('content')
    <div class="row">
        <div class="col-sm-12 people-list">
            <div class="people-options clearfix">
                <div class="btn-toolbar pull-left">
                    <select name="" class="form-control mt-2" id="report-select-company" style="width: 100%;">
                        <option value="">Selecciona un cliente</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="btn-group pull-right people-pager">
                    <button type="button" class="btn btn-default"><i class="fa fa-chevron-left"></i></button>
                    <button type="button" class="btn btn-default"><i class="fa fa-chevron-right"></i></button>
                </div>
                <span class="people-count pull-right">Showing <strong>1-10</strong> of <strong>34,404</strong> users</span>
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

            // select news by company
            $('#report-select-company').on('change', function(event){
                var optionSelected = event.target.value;

                $.post('{{ route('api.getnewsbyclient') }}', { "_token": $('meta[name="csrf-token"]').attr('content'), 'company': optionSelected }, function(res){
                    $('#div-table-notes').html(res)
                });

                console.log(`Has seleccionado el valor de ${optionSelected}`)
            });
        });
        
    </script>
@endsection