@extends('layouts.home')
@section('title', ' - Operadora de medios Informativos')
@section('content')

<section class="uk-height-large uk-background-cover uk-overflow-hidden uk-dark uk-flex uk-flex-top expertos" style="background-image: url('{{ asset('images/home/tecnologia.jpg') }}');" uk-height-viewport="min-height: 100vh">
    <div class="uk-container uk-margin-auto-vertical">
        <div class="uk-width-5-6@s uk-width-2-3@m">
            <h1>Expertos en monitoreo</h1>
            <h2>Tus ojos y oídos para tu toma de decisiones</h2>
            <p>Somos una empresa especializada en el monitoreo de medios y análisis de información en radio, televisión, periódicos, revistas, sitios web y redes sociales; con más veinte años de experiencia.</p>
            <ul class="uk-iconnav uk-ligth">
                <li><i class="fas fa-microphone fa-2x"></i></li>
                <li><i class="fas fa-tv fa-2x"></i></li>
                <li><i class="far fa-newspaper fa-2x"></i></li>
                <li><i class="fas fa-laptop fa-2x"></i></li>
            </ul>
        </div>
    </div>
</section>

<section class="uk-background-cover uk-overflow-hidden uk-light uk-flex uk-flex-top uk-padding-large hacemos-por-ti" style="background-image: url('{{ asset('images/home/network.jpg') }}');">
    <div class="uk-container uk-margin-auto-vertical">
        <h2 class="uk-padding uk-padding-large uk-padding-remove-horizontal">Lo qué podemos hacer por ti</h2>
        <ul class="uk-grid-divider uk-child-width-expand@s uk-text-center uk-grid-large" uk-grid>
            <li>Monitoreo de medios<br> 24 x 7 x 365</li>
            <li>Evidencia en<br> formato digital</li>
            <li>Reportes generales y<br> personalizados</li>
            <li>Envío de<br> notificaciones</li>
        </ul>
    </div>
</section>

<section class="servicio-personalizado uk-container">
    <div class="uk-child-width-expand@s " uk-grid>
        <div class="uk-width-1-3 uk-padding">
            <img src="{{ asset('images/home/graph.png') }}"/>
        </div>
        <div class="uk-padding uk-padding-large uk-padding-remove-right">
            <h2>Nos distinguimos por nuestro servicio personalizado.</h2>
            <p>Somos una empresa líder en el monitoreo y análisis de medios. Nuestro capital y talento humano está conformado por profesionales especializados en el área de la comunicación. Contamos con personal altamente calificado, mediante el cual estaremos atentos a cualquier información directa o indirecta de su empresa, así como el comportamiento de su competencia.</p>
        </div>
    </div>
</section>

<section class="servicios-medios" style="background-image: url({{ asset('images/network.jpg') }});">
    <div class="">
        <ul class="accordion-h uk-light">
            <li class="accordion-open uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle uk-flex-column uk-padding-large" style="background-image: url({{ asset('images/radio.jpg') }});">
                <a class="accordion-title" href="javascript:void(0);"><h3 >Radio</h3><span uk-icon="icon: chevron-up; ratio: 1.5;" class="icon-r"></span><span uk-icon="icon: chevron-down; ratio: 1.5;" class="icon-l"></span></a>
                <p class="uk-container-small">Durante los 365 días del año, las 24 horas, grabamos de manera continua 48 estaciones de radio en las frecuencias de AM y FM. Monitoreamos los programas más importantes de noticias, opinión, salud, espectáculos, cultura, finanzas, deportes.</p>
            </li>
            <li class="uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" style="background-image: url({{ asset('images/tv.jpg') }});">
                <a class="accordion-title" href="javascript:void(0);"><h3>Televisión</h3><span uk-icon="icon: chevron-up; ratio: 1.5;" class="icon-r"></span><span uk-icon="icon: chevron-down; ratio: 1.5;" class="icon-l"></span></a>
                <p class="uk-container-small">Grabamos las 24 horas, de lunes a domingo, los 365 días del año, 25 canales de televisión de señales abiertas y del servicio de paga. Monitoreamos los programas más importantes de noticias, opinión, salud, espectáculos, cultura, finanzas, deportes.</p>
            </li>
            <li class="uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" style="background-image: url({{ asset('images/newspapper.jpg') }});">
                <a class="accordion-title" href="javascript:void(0);"><h3>Periódicos y Revistas</h3><span uk-icon="icon: chevron-up; ratio: 1.5;" class="icon-r"></span><span uk-icon="icon: chevron-down; ratio: 1.5;" class="icon-l"></span></a>
                <p class="uk-container-small">Búsqueda de información en los principales diarios y revistas de circulación nacional como Reforma, El Universal, Milenio, La Jornada, Excélsior, Economista, El Financiero; Unomásuno, El Sol de México, La Crónica de Hoy, revistas de diferentes cortes: política, moda, espectáculos, salud, deportes, turismo, entretenimiento, arte, entre otras</p>
            </li>
            <li class="uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" style="background-image: url({{ asset('images/websites.jpg') }});">
                <a class="accordion-title" href="javascript:void(0);"><h3>Sitios Web y Redes Sociales</h3><span uk-icon="icon: chevron-up; ratio: 1.5;" class="icon-r"></span><span uk-icon="icon: chevron-down; ratio: 1.5;" class="icon-l"></span></a>
                <p class="uk-container-small">Búsqueda de información de temas encomendados en muchos portales existentes de información general y especializados en temas como política, moda, espectáculos, cultura, salud, deportes, por mencionar algunos. Rankeo integral (tu posicionamiento y el de tus competidores ante búsquedas), análisis estratégico.</p>
            </li>
        </ul>
    </div>
</section>

<section class="uk-height-large uk-background-cover uk-overflow-hidden uk-light uk-flex uk-flex-top analisis" style="background-image: url('{{ asset('images/home/analysis.jpg') }}');">
    <div class="uk-container uk-margin-auto-vertical">
        <div class="uk-child-width-expand@s uk-grid-divider uk-grid-large" uk-grid>
            <div>
                <h4>Análisis de Contenido</h3>
                <p>Nuestros análisis se realizan en función de lo que tú necesitas; para ello, se hace un estudio con el que, entre otras variables, se determina la cantidad de notas positivas, negativas, neutras; el rating de los programas en los cuales se transmitió, el tipo de público al que se impactó, costos-beneficios, del propio y de la competencia. Se elaboran gráficas para la mejor comprensión del estudio.</p>
            </div>
            <div>
                <h4>Análisis de Cobertura Mediática</h3>
                <p>Estos estudios están centrados básicamente en los medios de impacto visual como la televisión, periódicos, revistas e internet. El objetivo central es determinar los momentos y espacios en que aparece el objeto del estudio para finalmente evaluar los costos por esas publicidades que no generaron costos directos.</p>
            </div>
        </div>
    </div>
</section>

<section class="clientes uk-container uk-padding-large">
    <div class="uk-child-width-expand@s uk-grid-divider uk-grid-large" uk-grid>
        <h1 class="uk-width-auto@s">Algunos de<br> Nuestros Clientes</h1>
        <div class="uk-width-expand@s">
            <figure id="img_client" class="uk-grid-large uk-child-width-1-2 uk-child-width-1-4@s uk-child-width-1-5@m" uk-grid>
                <img src="{{ asset('images/clientes/1.jpg') }}" width="auto" height="auto" alt="MTV">
                <img src="{{ asset('images/clientes/2.jpg') }}" width="auto" height="auto" alt="OCESA">
                <img src="{{ asset('images/clientes/3.jpg') }}" width="auto" height="auto" alt="MUSEO FRANZ MAYER">
                <img src="{{ asset('images/clientes/4.jpg') }}" width="auto" height="auto" alt="VIDEOCINE">
                <img src="{{ asset('images/clientes/5.jpg') }}" width="auto" height="auto" alt="FEDERACIÓN MEXICANA DE FÚTBOL">
                <img src="{{ asset('images/clientes/6.jpg') }}" width="auto" height="auto" alt="NFL
        ">
                <img src="{{ asset('images/clientes/7.jpg') }}" width="auto" height="auto" alt="FÓRMULA UNO">
                <img src="{{ asset('images/clientes/8.jpg') }}" width="auto" height="auto" alt="SONY PICTURES">
                <img src="{{ asset('images/clientes/9.jpg') }}" width="auto" height="auto" alt="FOX NETWORKS  GROUP MÉXICO">
                <img src="{{ asset('images/clientes/10.jpg') }}" width="auto" height="auto" alt="JAFRA
        ">
                <img src="{{ asset('images/clientes/11.jpg') }}" width="auto" height="auto" alt="PARTIDO NUEVA ALIANZA">
                <img src="{{ asset('images/clientes/12.jpg') }}" width="auto" height="auto" alt="DOCUMENTAL AMBULANTE">
                <img src="{{ asset('images/clientes/13.jpg') }}" width="auto" height="auto" alt="ACADEMIA MEXICANA DE ARTES Y CIENCIAS CINEMATOGRÁFICAS (AMACC)">
                <img src="{{ asset('images/clientes/14.jpg') }}" width="auto" height="auto" alt="AGROBIO MÉXICO">
            </figure>
        </div>
    </div>
</section>
@endsection
