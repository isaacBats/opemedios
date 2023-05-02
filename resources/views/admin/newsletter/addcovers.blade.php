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
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        Guardar portadas y columnas para newsletters
                    </h4>
                    <span class="col-sm-2 col-sm-offset-10">
                        <a href="javascript:void(0);" id="newsletter_new_cover" class="btn btn-primary btn-quirk btn-wide" style="display: block;position: relative;">Nueva portada</a>
                    </span>
                </div>
                <div class="panel-body">
                    <hr>
                    <form action="{{ route('admin.newsletter.config.add.footer') }}" method="POST" class="form-horizontal">
                        @csrf
                        @foreach($covers as $cover)
                            <div class="form-group">
                                <label class="col-sm-3 control-label">{{ $cover->name }}<span class="text-danger">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" name="{{ $cover->slug }}" class="form-control" placeholder="https://..." value="{{ old($cover->slug) }}" required />
                                </div>
                                @error($cover->slug)
                                    <label class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </label>
                                @enderror
                            </div>
                        @endforeach
                        <hr>
                        <div class="form-group text-right">
                            <input type="submit" value="Guardar" class="btn btn-success btn-quirk btn-wide mr5">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#newsletter_new_cover').on('click', function(){
                event.preventDefault();
                var modal = $('#modal-default');
                var form = $('#modal-default-form');
                var modalBody = modal.find('.modal-body');

                form.attr('method', 'POST');
                form.attr('action', "{{ route('admin.newsletter.config.store.cover') }}");
                form.addClass('form-horizontal');

                modal.find('.modal-title').html('Crear nueva portada');
                modal.find('#md-btn-submit').val('Crear');
                modalBody.html(
                    `
                        <div class="row">
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Nombre</label>
                              <div class="col-sm-8">
                                <input id="input-name-cover" type="text" name="name" class="form-control" />
                              </div>
                          </div>
                        </div>
                    `
                );

                modal.modal('show')
            })
        });
    </script>
@endsection
