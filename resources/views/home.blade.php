@extends('layouts.home')
@section('title', ' - Operadora de medios Informativos')
@section('content')
    <section class="op-hero text-center" id="video">
        <div class="container">
            <div class="row">
                <div class="hero-content">
                    <h1>Expertos en monitoreo</h1>
                    <div></div>
                    <h2>Somos una empresa especializada en el monitoreo de medios y análisis de información,<br> con más veinte años de experiencia.</h2>
                </div>
            </div>
        </div>
    </section>
    <section class="op-icons">
        <div class="container">
            <div class="row">
                <div class="col-6 col-sm-3">
                    <div class="item go-0">
                        <i class="fas fa-microphone fa-2x"></i>
                        <div class="icon">Radio</div>
                    </div>
                </div>
                <div class="col-6 col-sm-3">
                    <div class="item go-1">
                        <i class="fas fa-tv fa-2x"></i> 
                        <div class="icon">Televisión</div>
                    </div>
                </div>
                <div class="col-6 col-sm-3">
                    <div class="item go-2">
                        <i class="far fa-newspaper fa-2x"></i>
                        <div class="icon">Periódicos y Revistas</div>
                    </div>
                </div>
                <div class="col-6 col-sm-3">
                    <div class="item go-3">
                        <i class="fas fa-laptop fa-2x"></i>
                    <div class="icon">Sitios Web y Redes Sociales</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="op-services">
        <div class="container">
            <div class="owl-one owl-carousel  owl-theme">
                <div class="item">
                    <article>
                        <figure class="bg-0">
                            <div>
                                <i class="fas fa-microphone fa-2x"></i>
                            </div>
                        </figure>
                        <h3>Radio</h3>
                        <div></div>
                        <p>Durante los 365 días del año, las 24 horas, grabamos de manera continua 48 estaciones de radio en las frecuencias de AM y FM. Monitoreamos los programas más importantes de noticias, opinión, salud, espectáculos, cultura, finanzas, de portes. </p>
                    </article>
                </div>
                <div class="item">
                    <article>
                        <figure class="bg-1">
                            <div>
                                <i class="fas fa-tv fa-2x"></i> 
                            </div>
                        </figure>
                        <h3>Televisión</h3>
                        <div></div>
                        <p>Grabamos las 24 horas, de lunes a domingo, los 365 días del año, 25 canales de televisión de señales abiertas y del servicio de paga. Monitoreamos los programas más importantes de noticias, opinión, salud, espectáculos, cultura, finanzas, deportes.</p>
                    </article>
                </div>

                <div class="item">
                    <article>
                        <figure class="bg-2">
                            <div>
                                <i class="far fa-newspaper fa-2x"></i>
                            </div>
                        </figure>
                        <h3>Periódicos y Revistas</h3>
                        <div></div>
                        <p>Búsqueda de información en los principales diarios y revistas de circulación nacional como Reforma, El Universal, Milenio, La Jornada, Excélsior, Economista, El Financiero; Unomásuno, El Sol de México, La Crónica de Hoy, revistas de diferentes cortes: política, moda, espectáculos, salud, deportes, turismo, entretenimiento, arte, entre otras</p>
                    </article>
                </div>
                <div class="item">
                    <article>
                        <figure class="bg-3">
                            <div>
                                <i class="fas fa-laptop fa-2x"></i>
                            </div>
                        </figure>
                        <h3>Sitios Web y Redes Sociales</h3>
                        <div></div>
                        <p>Búsqueda de información de temas encomendados en muchos portales existentes de información general y especializados en temas como política, moda, espectáculos, cultura, salud, deportes, por mencionar algunos. Rankeo integral (tu posicionamiento y el de tus competidores ante búsquedas), análisis estratégico.</p>
                    </article>
                </div>
            </div>
        </div>
    </section>
    <section class="op-we">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h3>NUESTRO EQUIPO</h3>
                    <p>Contamos con personal altamente calificado, mediante el cual estaremos atentos a cualquier información directa o indirecta de su empresa, así como el comportamiento de su competencia.</p>
                    <button class="btn-white" onclick="location.href='http://opemedios.mx/quienes-somos'">ACERCA DE NOSOTROS</button>
                </div>
                <div class="col-md-6 adjust">
                    <img src="{{ asset('images/site-img01.png') }}" class="img-fluid">
                </div>
            </div>
        </div>
    </section>
    <section class="op-analysis">
        <div class="container">
            <div class="row">
                <div div class="col-md-6">
                    <h4>Análisis de Contenido</h3>
                    <div></div>
                    <p>Nuestros análisis se realizan en función de lo que tú necesitas; para ello, se hace un estudio con el que, entre otras variables, se determina la cantidad de notas positivas, negativas, neutras; el rating de los programas en los cuales se transmitió, el tipo de público al que se impactó, costos-beneficios, del propio y de la competencia. Se elaboran gráficas para la mejor comprensión del estudio.</p>
                </div>
                <div div class="col-md-6">
                    <h4>Análisis de Cobertura Mediática</h3>
                    <div></div>
                    <p>Estos estudios están centrados básicamente en los medios de impacto visual como la televisión, periódicos, revistas e internet. El objetivo central es determinar los momentos y espacios en que aparece el objeto del estudio para finalmente evaluar los costos por esas publicidades que no generaron costos directos.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="op-icons-mark text-center">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-6">
                    <div class="item go-0">
                        <i class="fas fa-map-marker-alt fa-lg"></i>
                        <div class="icon">Ures 69, Col. Roma Sur CP. 06760, México, DF, Del. Cuauhtémoc</div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="item go-1">
                        <i class="far fa-envelope fa-lg"></i>   
                        <div class="icon">atencion@opemedios.mx</div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="item go-2">
                        <i class="fas fa-phone fa-lg"></i>
                        <div class="icon">52 1 55 55846410</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="map">
    </section>
@endsection