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
            
            <!-- Article main content -->
            <article class="col-sm-9 maincontent">
                <header class="page-header">
                    <h1 class="page-title">Contactanos</h1>
                </header>
                
                <p>
                    Nos encantaría saber de usted. Interesados en trabajar juntos? Rellene el siguiente formulario con algo de información sobre su proyecto y yo pondremos en contacto con usted tan pronto como pueda. Por favor espere de un par de días para que responda.
                </p>
                <br>
                    <form class="f-contact">
                        <div class="row">
                            <div class="col-sm-4">
                                <input class="form-control" type="text" placeholder="Nombre">
                            </div>
                            <div class="col-sm-4">
                                <input class="form-control" type="text" placeholder="Email">
                            </div>
                            <div class="col-sm-4">
                                <input class="form-control" type="text" placeholder="Teléfono">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <textarea placeholder="Escribanos un mensaje..." class="form-control" rows="9"></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <!-- <div class="col-sm-6">
                                <label class="checkbox"><input type="checkbox"> Sign up for newsletter</label>
                            </div> -->
                            <div class="col-sm-12 text-right">
                                <input class="btn btn-action" type="submit" value="Enviar mensaje">
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
                        +52 1 55 5584-6410
                    </address>
                </div>

            </aside>
            <!-- /Sidebar -->

        </div>
    </div>  <!-- /container -->

    <section class="container-full top-space f-map">
        <div id="maps"></div>
    </section>
@endsection