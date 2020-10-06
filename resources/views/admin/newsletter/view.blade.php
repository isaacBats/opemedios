@extends('layouts.admin')
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
                        <h4 class="panel-title" style="padding: 12px 0;">Bienvenido al newsletter de {{ $newsletter->company->name }}</h4>
                    </div>
                    <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12 text-right">
                        <button id="btn-create-nwlt" class="btn btn-success btn-quirk"><i class="fa fa-plus-circle"></i> {{ __('Nuevo') }}</button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-newsletters">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                            <th>Enviar</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $newsletters_send = $newsletter->newsletter_send()->orderBy('id', 'DESC')->paginate(25);
                        @endphp
                        @forelse($newsletters_send as $oneNewsletter)
                            <tr>
                                <th>{{ ($newsletters_send->currentPage() - 1) * $newsletters_send->perPage() + $loop->iteration }}</th>
                                <th>{{ $oneNewsletter->created_at->diffForHumans() }}</th>
                                <th>
                                    @if($oneNewsletter->status)
                                        @for($i = 0; $i < $oneNewsletter->status; $i++)
                                            @if($oneNewsletter->status > 5)
                                                @component('components.checks')
                                                    {{ $oneNewsletter->status - 5 }}
                                                @endcomponent
                                                @break
                                            @else
                                                <span class="text-primary"><i class="fa fa-check-circle"></i><span>
                                            @endif
                                        @endfor
                                    @else
                                        <span class="text-warning"><i class="fa fa-pause-circle"></i><span>
                                    @endif
                                </th>
                                <th>
                                    <a href="{{ route('admin.newsletter.edit.send', ['id' => $oneNewsletter->id]) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    <a href="{{ route('admin.newsletter.preview.send', ['id' => $oneNewsletter->id]) }}" target="_blank"><button type="button" class="btn btn-primary"><i class="fa fa-eye"></i></button></a>
                                    <button type="button" class="btn btn-primary send-mail-manual" data-id="{{ $oneNewsletter->id }}"><i class="fa fa-envelope-open"></i></button>
                                    <button type="button" class="btn btn-danger delete-newsletter" data-id="{{$oneNewsletter->id }}"><i class="fa fa-trash"></i></button>
                                </th>
                                <th>
                                    <a href="{{ route('admin.newsletter.send', ['sendid' => $oneNewsletter->id]) }}" class="btn btn-primary btn-send-newsletter"><i class="fa fa-envelope"></i></a>
                                </th>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No hay elementos para mostrar</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            // crate news newsletter for send
            $('#btn-create-nwlt').on('click', function(){
                var form = $('#modal-default-form')
                var urlAction = `{{ route('admin.newsletter.newforsend', ['id' => $newsletter->id]) }}`

                form.attr('action', urlAction)
                form.attr('method', 'POST')
                form.submit()
                // $.post(`{{-- route('admin.newsletter.newforsend', ['id' => $newsletter->id]) --}}`, { "_token": $('meta[name="csrf-token"]').attr('content') })
            })
        })

            // envio manual
        $('#table-newsletters').on('click', 'a.btn-send-newsletter', function(event) {
            event.preventDefault()
            var newsletterId = "{{ $newsletter->id }}"
            var action = $(this).attr('href')
            var modal = $('#modal-default')
            var form = $('#modal-default-form')

            form.attr('method', 'POST')
            form.attr('action', action)
            
            modal.find('.modal-title').text('Enviar Newsletter')
            modal.find('.modal-body').html(`
                <p>Vas a enviar el newsletter a los siguientes correos</p>
                <ul>
                    @foreach($newsletter->newsletter_users as $item)
                    <li>{{ $item->email }}</li>
                    @endforeach
                </ul>
            `)
            modal.find('#md-btn-submit').val('Enviar')
            modal.modal('show')
        })
        //
        //     // borrar newsletter
        //     $('#table-newsletters').on('click', 'button.delete-newsletter', function(event) {
        //         event.preventDefault()
        //         var id = $(this).data('id')
        //         var modal = $('#modalDeleteNewsletter')
        //         var form = $('#form-modal-delete-newsletter')
        //
        //         form.attr('action', `/newsletter/borrar/${id}`)
        //         modal.modal('show')
        //     })
        // })
    </script>
@endsection
