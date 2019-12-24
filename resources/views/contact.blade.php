@extends('layouts.home2')
@section('title', ' - Contacto')
@section('content')
    <!-- container -->
    <div class="container op-content-mt">

        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">Inicio</a></li>
            <li class="active">Contacto</li>
        </ol>

        <div class="row">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            
            <!-- Article main content -->
            <article class="col-sm-9 maincontent">
                <header class="page-header">
                    <h1 class="page-title">Contactanos</h1>
                </header>
                
                <p>
                    Nos encantaría saber de usted. Interesados en trabajar juntos? Rellene el siguiente formulario con algo de información sobre su proyecto y yo pondremos en contacto con usted tan pronto como pueda. Por favor espere de un par de días para que responda.
                </p>
                <br>
                    <form id="form-contact" class="f-contact" method="POST" action="{{ route('form.contact') }}">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <input class="form-control" type="text" name="name" placeholder="*Nombre" required>
                            </div>
                            <div class="col-sm-4">
                                <input class="form-control" type="email" name="email" placeholder="*Email" required>
                            </div>
                            <div class="col-sm-4">
                                <input class="form-control" type="text" name="phone" placeholder="Teléfono">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <textarea name="message" placeholder="Escribanos un mensaje..." class="form-control" rows="9" required></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <!-- <div class="col-sm-6">
                                <label class="checkbox"><input type="checkbox"> Sign up for newsletter</label>
                            </div> -->
                            <div class="col-sm-12 text-right">
                                <input id="btn-send-form-contact" class="btn btn-action" type="submit" value="Enviar mensaje">
                            </div>
                        </div>
                    </form>

            </article>
            <!-- /Article -->
            
            <!-- Sidebar -->
            <aside class="col-sm-3 sidebar sidebar-right">

                <div class="widget">
                    <h4>Direccion</h4>
                    <address>
                        Ures 69, Col. Roma Sur CP. 06760, México, DF, Del. Cuauhtémoc
                    </address>
                    <h4>Teléfono:</h4>
                    <address>
                        <a href="tel:5555846410" target="_blank">55-5584-64-10</a>
                    </address>
                </div>

            </aside>
            <!-- /Sidebar -->

        </div>
    </div>  <!-- /container -->

    <section class="container-full top-space f-map">
        <div id="map"></div>
    </section>
@endsection
@section('scripts')
    <script type="text/javascript">
        // TODO: crear el javascript para el formulario de contacto
        // $(document).ready(function() {
        //     $('#btn-send-form-contact').on('click', function(event) {
        //         event.preventDefault()
        //         console.log('con que quieres enviar este formukario he!!!')
        //     })
        // })
    </script>
@endsection