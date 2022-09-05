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
                            <th>Fecha de envío</th>
                            <th>Etiqueta</th>
                            <th>Estatus</th>
                            <th>Link</th>
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
                                <td>{{ ($newsletters_send->currentPage() - 1) * $newsletters_send->perPage() + $loop->iteration }}</td>
                                <td>{{ $oneNewsletter->date_sending }}</td>
                                <td>
                                    {{ $oneNewsletter->label }}
                                </td>
                                <td>
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
                                </td>
                                <td>
{{--                                    <input type="hidden" value="{{ route('front.newsletter.see', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$oneNewsletter->id}-{$oneNewsletter->newsletter->company->id}")]) }}">--}}
{{--                                    <button class="btn btn-primary btn-copy-link" >--}}
{{--                                        Copiar link para whatsapp--}}
{{--                                    </button>--}}

                                    <button class="btn btn-copy-link" data-clipboard-text="{{ route('front.newsletter.see', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$oneNewsletter->id}-{$oneNewsletter->newsletter->company->id}")]) }}">
                                        Copiar link para whatsapp
                                    </button>
                                </td>
                                <td>
                                    <a href="{{ route('admin.newsletter.edit.send', ['id' => $oneNewsletter->id]) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    <a href="{{ route('admin.newsletter.preview.send', ['newsletterSend' => $oneNewsletter]) }}" target="_blank"><button type="button" class="btn btn-primary"><i class="fa fa-eye"></i></button></a>
                                    <button class="btn btn-primary send-mail-manual" data-href="{{ route('admin.newsletter.send', ['sendid' => $oneNewsletter->id]) }}" data-id="{{ $oneNewsletter->id }}"><i class="fa fa-envelope-open"></i></button>
                                    <button class="btn btn-danger delete-newsletter" data-href="{{ route('admin.newsletter.delete', ['sendid' => $oneNewsletter->id]) }}"><i class="fa fa-trash"></i></button>
                                </td>
                                <td>
                                    <a href="{{ route('admin.newsletter.send', ['sendid' => $oneNewsletter->id]) }}" class="btn btn-primary btn-send-newsletter"><i class="fa fa-envelope"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No hay elementos para mostrar</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    {!! $newsletters_send->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.10/clipboard.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            // crate news newsletter for send
            $('#btn-create-nwlt').on('click', function(){
                var form = $('#modal-default-form');
                var urlAction = `{{ route('admin.newsletter.newforsend', ['id' => $newsletter->id]) }}`;
                var modal = $('#modal-default');
                var form = $('#modal-default-form');

                form.attr('action', urlAction);
                form.attr('method', 'POST');

                modal.find('.modal-title').text('Crear Newsletter')
                modal.find('.modal-body').html(`
                    <div class="form-group">
                        <label>Nombre del newsletter</label>
                        <input class="form-control" name="nwl-name" placeholder="Default" type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Fecha de envío</label>
                        <input class="form-control" name="date-sending"  type="date" required>
                    </div>
                `);

                modal.find('#md-btn-submit').val('Crear');
                modal.modal('show');
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

            // envio manual con correos
            $('#table-newsletters').on('click', 'button.send-mail-manual', function(event) {
                event.preventDefault()
                var action = $(this).data('href')
                var modal = $('#modal-default')
                var form = $('#modal-default-form')

                form.attr('method', 'POST')
                form.attr('action', action)

                modal.find('.modal-title').text('Ingresa los correos a los que se enviara el newsletter')
                modal.find('.modal-body').html(`
                    <div class="form-group">
                        <label for="emails">Emails</label>
                        <span id="helpBlock" class="help-block">{{ __('Multiples correos separados por coma y sin espacios ejemplo@mail.com,ejemplo@mail.com.') }}</span>
                        <textarea name="emails" id="emails" rows="10" class="form-control"></textarea>
                    </div>
                `)
                modal.find('#md-btn-submit').val('Enviar')
                modal.modal('show')
            })

            // borrar newsletter
            $('#table-newsletters').on('click', 'button.delete-newsletter', function(event) {
                event.preventDefault()
                var action = $(this).data('href')
                var modal = $('#modal-default')
                var form = $('#modal-default-form')

                form.attr('method', 'POST')
                form.attr('action', action)

                modal.find('.modal-title').text('Borrar Newsletter')
                modal.find('.modal-body').html(`
                    <p>¿Estas seguro que quieres borrar este Newsletter?</p>
                `)
                modal.find('#md-btn-submit').val('Eliminar').removeClass('btn-primary').addClass('btn-danger')
                modal.modal('show')
            })

            var clipboard = new ClipboardJS('.btn-copy-link');
            clipboard.on('success', function (e) {
                // console.log(e);
                alert('Se ha copiado el link al portapapeles.');
            });
        });

    </script>
@endsection
