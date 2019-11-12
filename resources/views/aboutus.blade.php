@extends('layouts.home2')
@section('content')
    <header id="head" class="secondary"></header>
    <!-- container -->
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/">Inicio</a></li>
            <li class="active">Quiénes Somos</li>
        </ol>

        <div class="row">
            
            <!-- Article main content -->
            <article class="col-sm-12 maincontent">
                <header class="page-header">
                    <h1 class="page-title">Quiénes Somos</h1>
                </header>
                <h3>Quiénes Somos :</h3>
                <p><img src="{{ asset('images/mac.jpg') }}" alt="" class="img-rounded pull-right" width="300" > Somos una empresa líder en el monitoreo y análisis de medios. Nuestro capital y talento humano está conformado por profesionales especializados en el área de la comunicación.</p>
                
                <h3>Misión:</h3>
                <p>Convertirnos en tus ojos y oídos para tu toma de decisiones.</p>
                <h3>Visión:</h3>
                <p>Seguir brindando un servicio personalizado, lo que nos ha caracterizado en los casi 20 años de trayectoria</p>
                <h3>Nuestros Valores:</h3>
                <ul>
                    <li><span>Comunicación: </span>Estar en estrecho contacto contigo.</li>
                    <li><span>Servicio: </span>Responder con responsabilidad y eficiencia las particularidades que tú necesitas.</li>
                    <li><span>Sensibilidad: </span>Inherente a la actividad que realizamos.</li>
                </ul>
                <div class="jumbotron top-space">
                        <h4>En OPEMEDIOS nos distinguimos por nuestro servicio personalizado.</h4>
                    </div>
            </article>
            <!-- /Article -->
            
            <!-- Sidebar -->
            <!-- <aside class="col-sm-4 sidebar sidebar-right">

                <div class="widget">
                    <div class="jumbotron top-space">
                        <h4>En OPEMEDIOS nos distinguimos por nuestro servicio personalizado.</h4>
                    </div>                  
                </div>

            </aside> -->
            <!-- /Sidebar -->

        </div>
    </div>  <!-- /container -->
@endsection