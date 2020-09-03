@extends('layouts.admin')
@section('admin-title', ' - Configuración newsletters')
@section('content')
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<div class="col-md-12">
  <div class="panel">
    <div class="panel-heading">
      <div class="row">
          <div class="col-lg-6 col-md-8 col-sm-6 col-xs-12">
            <h4 class="panel-title" style="padding: 12px 0;">Lista de configuración newsletters</h4>
          </div>
          <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12 text-right">
              <a href="{{ route('admin.newsletter.create') }}" class="btn btn-success btn-quirk"><i class="fa fa-plus-circle"></i> Nuevo newsletter</a>
          </div>
      </div>
    </div>
    <div class="panel-body">
      <div class="table-responsive">
        <table id="table-newsletters" class="table table-bordered table-inverse table-striped nomargin">
          <thead>
            <tr>
              <th class="text-center">
                <label class="ckbox">
                  <input type="checkbox"><span></span>
                </label>
              </th>
              <th class="text-center">#</th>
              <th class="text-center">Nombre</th>
              <th class="text-center">Compañia</th>
              <th class="text-center">Activo</th>
              <th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($newsletters as $newsletter)
                <tr>
                  <td class="text-center">
                    <label class="ckbox">
                      <input type="checkbox"><span></span>
                    </label>
                  </td>
                  <td class="text-center" >{{ ($newsletters->currentPage() - 1) * $newsletters->perPage() + $loop->iteration }}</td>
                  <td class="text-left" >{{ $newsletter->name }}</td>
                  <td class="text-left">{{ $newsletter->company->name }}</td>
                  <td class="text-center">
                      <input type="checkbox" {{ ($newsletter->active == 1 ? 'checked' : '') }} data-toggle="toggle" data-onstyle="success" data-id="{{ $newsletter->id }}" data-href="{{ route('admin.newsletter.status', ['id' => $newsletter->id]) }}" class="btn-status">
                  </td>
                  <td class="table-options">
                      <li><a href="{{ route('admin.newsletter.config', ['id' => $newsletter->id]) }}"><i class="fa fa-gear"></i></a></li>
                      <li><a href="{{ route('admin.newsletter.view', ['id' => $newsletter->id]) }}"><i class="fa fa-eye"></i></a></li>
                      <li><a href="{{ route('admin.newsletter.remove', ['id' => $newsletter->id]) }}"><i class="fa fa-trash"></i></a></li>
                  </td>
                </tr>
            @endforeach
          </tbody>
        </table>
        <div>
          {{ $newsletters->links() }}
        </div>
      </div><!-- table-responsive -->
    </div>
  </div><!-- panel -->
</div>
@endsection
@section('styles')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('scripts')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            // status of the newsletter
            $('#table-newsletters').on('change', '.btn-status', function (){
                var newsletterId = $(this).data('id')
                var action = $(this).data('href')

                if($(this).is(':checked')) {
                    $.post(`${action}`, { "_token": $('meta[name="csrf-token"]').attr('content'), 'status': 1 }, function(res){
                        $.gritter.add({
                            title: 'Newsletter Activo',
                            text: res.message,
                            class_name: 'with-icon check-circle success'
                        })
                    }).fail(function(res){
                        $.gritter.add({
                            title: 'Error al cambiar el estatus del newsletter',
                            text: res.error,
                            class_name: 'with-icon times-circle danger'
                        })
                    })
                }
                else{
                    $.post(`${action}`, { "_token": $('meta[name="csrf-token"]').attr('content'), 'status': 0 }, function(res){
                        $.gritter.add({
                            title: 'Newsletter Inactivo',
                            text: res.message,
                            class_name: 'with-icon check-circle success'
                        })
                    }).fail(function(res){
                        $.gritter.add({
                            title: 'Error al cambiar el estatus del newsletter',
                            text: res.error,
                            class_name: 'with-icon times-circle danger'
                        })
                    })
                }
            })
        })
    </script>

@endsection
