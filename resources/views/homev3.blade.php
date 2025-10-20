@extends('layouts.home-clientv3')
@section('content')
    <!--hero section start-->
    <section class="banner-area-wrap-v3">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-8 col-xl-8">
                    <div class="left-content-hero-v3">
                        <h1><strong>Expertos </strong>en monitoreo</h1>
                        <h2>Tus ojos y oídos para tu toma de decisiones</h2>
                        <p>Somos una empresa especializada en el monitoreo de medios y análisis de información en radio, televisión, periódicos, revistas, sitios web y redes sociales; con más veinte años de experiencia.</p>
                        <a href="#" class="btn btn-default">Comenzar</a>
                    </div><!--/.left-content-hero-->
                </div>
            </div>
        </div><!--/.container-->
        <span class="banner-frame-one"></span>
        <span class="banner-frame-two"></span>
        <span class="banner-frame-three v3"></span>
        <span class="banner-frame-four"></span>
    </section>
    <!--hero section end-->

    <!--how-work-v3 start-->
    <div class="how-work-v3 pt-120">
        <div class="container">
            <div class="row g-0">
                <div class="col-12">
                    <div class="sec-title text-center mb-50">
                        <h3><img src="assets/clientv3/img/icons/title-icon.svg" alt=""> Nuestros monitoreos</h3>
                        <h2 class="tag1">Trabajamos con!</h2>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row g-4 justify-content-center">
                        <div class="col-md-6 col-xl-4">
                            <div class="how-work-inner-v3" data-aos="flip-down" data-aos-delay="100">
                                <span class="number">01</span>
                                <div class="d-sm-flex">
                                    <div class="flex-grow-0">
                                        <div class="icon">
                                            <img style="width: 50%;" src="{{ asset('assets/clientv3/img/icons/icon-radio.png') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="flex-shrink-1">
                                        <h2>Radio y Televisión</h2>
                                        <p>Grabamos continuamente 48 estaciones de radio en AM y FM durante todo el año, monitoreando noticias, opinión, salud, espectáculos, cultura, finanzas y deportes. También registramos las 24 horas, los siete días de la semana, 25 canales de televisión de señal abierta y por cable, vigilando programas clave en diversas categorías.</p>
                                    </div>
                                </div>
                            </div><!--/.how-work-inner-v3-->
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="how-work-inner-v3" data-aos="flip-down" data-aos-delay="300">
                                <span class="number">02</span>
                                <div class="d-sm-flex">
                                    <div class="flex-grow-0">
                                        <div class="icon">
                                            <img style="width: 50%;" src="{{ asset('assets/clientv3/img/icons/icon-periodico.png') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="flex-shrink-1">
                                        <h2>Periódicos y Revistas</h2>
                                        <p>Búsqueda de información en los principales diarios y revistas de circulación nacional como Reforma, El Universal, Milenio, La Jornada, Excélsior, Economista, El Financiero; Unomásuno, El Sol de México, La Crónica de Hoy. También buscamos en revistas de diferentes cortes: política, moda, espectáculos, salud, deportes, turismo, entretenimiento, arte, entre otras.</p>
                                    </div>
                                </div>
                            </div><!--/.how-work-inner-v3-->
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="how-work-inner-v3" data-aos="flip-down" data-aos-delay="500">
                                <span class="number">03</span>
                                <div class="d-sm-flex">
                                    <div class="flex-grow-0">
                                        <div class="icon">
                                            <img style="width: 50%;" src="{{ asset('assets/clientv3/img/icons/icon-internet.png') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="flex-shrink-1">
                                        <h2>Sitios Web y Redes Sociales</h2>
                                        <p>Búsqueda de información de temas encomendados en muchos portales existentes de información general y especializados en temas como política, moda, espectáculos, cultura, salud, deportes, por mencionar algunos. Rankeo integral (tu posicionamiento y el de tus competidores ante búsquedas), análisis estratégico.</p>
                                    </div>
                                </div>
                            </div><!--/.how-work-inner-v3-->
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/.container-->
    </div>
    <!--how-work-v3 end-->

    <!--about ortency start-->
    <section class="about-ortency-v3 px-120">
        <div class="container">
            <div class="row gy-5 align-items-center">
                <div class="col-md-12 col-lg-5 col-xl-6">
                    <div class="right-content-about-v3">
                        <div class="sec-title">
                            <h3><img src="img/icons/title-icon.svg" alt=""> Sobre nuestra compañia</h3>
                            <h2 class="tag1">En OPEMEDIOS nos distinguimos por nuestro servicio personalizado.</h2>
                        </div>
                        <p>Somos una empresa líder en el monitoreo y análisis de medios. Nuestro capital y talento humano está conformado por profesionales especializados en el área de la comunicación.</p>
                        <ul>
                            <li>
                                <div class="icon">
                                    <img src="{{ asset('assets/clientv3/img/icons/about-icon-1.png') }}" alt="">
                                </div>
                                <div class="cont">
                                    <h3>Misión</h3>
                                    <p>Convertirnos en tus ojos y oídos.</p>
                                </div>
                            </li>
                            <li>
                                <div class="icon">
                                    <img src="{{ asset('assets/clientv3/img/icons/about-icon-2.png') }}" alt="">
                                </div>
                                <div class="cont">
                                    <h3>Visión</h3>
                                    <p>Brindamos un servicio personalizado.</p>
                                </div>
                            </li>
                        </ul>
                        <a href="#" class="btn btn-default">Leer más</a>
                    </div><!--/.right-content-about-->
                </div>
                <div class="col-md-12 col-lg-7 col-xl-6">
                    <div class="left-images-about-v3">
                        <div class="inner-imgs">
                            <img src="{{ asset('assets/clientv3/img/home3/mision.png') }}" class="img1" alt="">
                            <img src="{{ asset('assets/clientv3/img/home3/mision2.png') }}" class="img2" alt="">
                            <img src="{{ asset('assets/clientv3/img/home3/vision.png') }}" class="img3" alt="">
                            <img src="{{ asset('assets/clientv3/img/home3/vision2.png') }}" class="img4" alt="">
                            <div class="shape-one"></div>
                            <div class="banner-frame-two"></div>
                            <div class="shape-two"></div>
                            <div class="shape-three"></div>
                            <div class="shape-four"></div>
                            <div class="radius-1"></div>
                            <img src="{{ asset('assets/clientv3/img/home3/about-shape1.svg') }}" class="shape-bg-1" alt="">
                        </div>
                    </div><!--/.left-images-about-->
                </div>
            </div>
        </div>
    </section>
    <!--about ortency end-->

    <!--our services v3 start-->
    <div class="extra-margin-sec">
        <div class="our-services-v2 px-120">
            <div class="container">
                <div class="row gx-4 gx-xxl-0">
                    <div class="col-12">
                        <div class="sec-title text-center mb-50">
                            <h3><img src="{{ asset('assets/clientv3/img/icons/title-icon.svg') }}" alt=""> Nuestros Servicios</h3>
                            <h2 class="tag1">Algunos de nuestros servicios exclusivos</h2>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="single-service-inner_v3 aos-init aos-animate" data-aos="fade-up">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-md-3 d-none d-lg-inline-block">
                                            <h2>Monitoreo Integral de Medios</h2>
                                        </div>
                                        <div class="col-md-4 col-lg-3">
                                            <div class="imgs">
                                                <img src="{{ asset('assets/clientv3/img/pexels-servicio1.jpg') }}" alt="">
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-lg-4 col-xl-4 ">
                                            <div class="cont">
                                                <h2 class="d-lg-none">Social Media Marketing</h2>
                                                <p>Ofrecemos un servicio completo de monitoreo que abarca radio, televisión, periódicos, revistas, sitios web y redes sociales. Utilizando tecnologías avanzadas, rastreamos y recopilamos datos relevantes, proporcionando a nuestros clientes una visión completa de su presencia mediática.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-2 col-xl-2 text-end">
                                            <a href="#" class="btn style2">Leer más</a>
                                        </div>
                                    </div>
                                </div><!--/.single-service-inner_v2-->
                            </div>
                            <div class="col-12">
                                <div class="single-service-inner_v3 aos-init aos-animate" data-aos="fade-up">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-md-3 d-none d-lg-inline-block">
                                            <h2>Análisis Detallado de Temas o Palabras Clave</h2>
                                        </div>
                                        <div class="col-md-4 col-lg-3">
                                            <div class="imgs">
                                                <img src="{{ asset('assets/clientv3/img/pexels-servicio2.jpg') }}" alt="">
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-lg-4 col-xl-4 ">
                                            <div class="cont">
                                                <h2 class="d-lg-none">Website Development</h2>
                                                <p>Realizamos un análisis exhaustivo de los temas y palabras clave que usted elija monitorear en todos los medios disponibles. Nuestra tecnología avanzada de procesamiento de lenguaje natural identifica patrones, tendencias y cambios en la narrativa, brindándole información valiosa sobre cómo su marca o temas específicos están siendo abordados en los medios.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-2 col-xl-2 text-end">
                                            <a href="#" class="btn style2">Leer más</a>
                                        </div>
                                    </div>
                                </div><!--/.single-service-inner_v2-->
                            </div>
                            <div class="col-12">
                                <div class="single-service-inner_v3 aos-init aos-animate" data-aos="fade-up">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-md-3 d-none d-lg-inline-block">
                                            <h2>Informe de Competencia Mediática</h2>
                                        </div>
                                        <div class="col-md-4 col-lg-3">
                                            <div class="imgs">
                                                <img src="{{ asset('assets/clientv3/img/pexels-karolina-grabowska-7681091-servicio3.jpg') }}" alt="">
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-lg-4 col-xl-4 ">
                                            <div class="cont">
                                                <h2 class="d-lg-none">Digital SEO Marketing</h2>
                                                <p>Le proporcionamos un informe detallado sobre cómo se compara su presencia mediática con la de la competencia. Analizamos la cobertura en los medios, la frecuencia de menciones y otros factores clave para que pueda ajustar su estrategia y destacar en su industria.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-2 col-xl-2 text-end">
                                            <a href="#" class="btn style2">Leer más</a>
                                        </div>

                                    </div>
                                </div><!--/.single-service-inner_v2-->
                            </div>
                            <div class="col-12">
                                <div class="single-service-inner_v3 aos-init aos-animate" data-aos="fade-up">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-md-3 d-none d-lg-inline-block">
                                            <h2>Envío de Resúmenes, Notificaciones y Reportes Personalizados</h2>
                                        </div>
                                        <div class="col-md-4 col-lg-3">
                                            <div class="imgs">
                                                <img src="{{ asset('assets/clientv3/img/pexels-mikael-blomkvist-6483619-servicio4.jpg') }}" alt="">
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-lg-4 col-xl-4 ">
                                            <div class="cont">
                                                <h2 class="d-lg-none">Financial Audit Result</h2>
                                                <p>Personalizamos completamente la entrega de información para adaptarnos a sus necesidades. Reciba resúmenes diarios, notificaciones instantáneas sobre eventos relevantes y reportes periódicos que contienen análisis profundos de su presencia mediática. Nuestra flexibilidad garantiza que reciba la información que realmente importa de la manera que más le convenga.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-lg-2 col-xl-2 text-end">
                                            <a href="#" class="btn style2">Leer más</a>
                                        </div>
                                    </div>
                                </div><!--/.single-service-inner_v2-->
                            </div>
    
                        </div>
                    </div>
                </div>
            </div><!--/.container-->
        </div>
    </div>
    <!--our services v3 end-->


    <!--why choose us start-->
    <section class="why-choose-us-v3 pt-120">
        <div class="container-fluid">
            <div class="row g-4 ">
                <div class="col-lg-6">
                    <div class="left-img-choose-v3">
                        <img src="{{ asset('assets/clientv3/img/pexels-alena-darmel-7710155.jpg') }}" alt="">
                        <img src="{{ asset('assets/clientv3/img/home3/image-shape-choose.svg') }}" class="overlay" data-aos="flip-left" alt="">
                    </div><!--/.left-img-choose-v3-->
                </div>
                <div class="col-lg-6">
                    <div class="right-content-choose-v3">
                        <div class="sec-title">
                            <h3><img src="{{ asset('assets/clientv3/img/icons/title-icon.svg') }}" alt="">¿Por qué elegirnos?</h3>
                            <h2 class="tag1">Transformamos datos en conocimiento para potenciar tu marca</h2>
                        </div>
                        <ul class="our-qua-lists">
                            <li>
                                <div class="icon">
                                    <img src="{{ asset('assets/clientv3/img/home3/choose-icon1.png') }}" alt="">
                                </div>
                                <div class="cont">
                                    <h2>Servicios de calidad</h2>
                                    <p>Nuestros servicios de calidad destacan por su precisión, profundidad y atención meticulosa.</p>
                                </div>
                                <img src="{{ asset('assets/clientv3/img/home3/shape-down.svg') }}"  class="arrow-down" alt="">
                            </li>
                            <li>
                                <div class="icon">
                                    <img src="{{ asset('assets/clientv3/img/home3/choose-icon2.png') }}" alt="">
                                </div>
                                <div class="cont">
                                    <h2>Seguir el mejor proceso de trabajo</h2>
                                    <p>En Opemedios, nos destacamos al seguir el mejor proceso de trabajo en el análisis y gestión de información mediática.</p>
                                </div>
                                <img src="{{ asset('assets/clientv3/img/home3/shape-down.svg') }}"  class="arrow-down flip" alt="">
                            </li>
                            <li>
                                <div class="icon">
                                    <img src="{{ asset('assets/clientv3/img/home3/choose-icon1.png') }}" alt="">
                                </div>
                                <div class="cont">
                                    <h2>Amplia cobertura</h2>
                                    <p>Disfruta de una cobertura sin igual en el monitoreo de medios. Desde radio y televisión hasta periódicos, revistas, sitios web y redes sociales.</p>
                                </div>
                            </li>
                        </ul>
                    </div><!--/.right-content-choose-->
                </div>
            </div>
        </div>
    </section>
    <!--why choose us end-->

    <!--portfolio area start-->
    <section class="portfolio-sec-v3 pt-120">
        <div class="container">
            <div class="row g-4 align-items-center align-items-lg-end">
                <div class="col-lg-6">
                    <div class="sec-title text-center text-lg-start">
                        <h3><img src="{{ asset('assets/clientv3/img/icons/title-icon.svg') }}" alt=""> Our Project</h3>
                        <h2 class="tag1">Our Creative Portfolio</h2>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ul class="filter-option-portfolio">
                        <li><a class="active" href="javaScript:void(0)" data-category="all">ALL</a></li>
                        <li><a href="javaScript:void(0)" data-category="website_des">Website Design</a></li>
                        <li><a href="javaScript:void(0)" data-category="branding_des">Branding Design</a></li>
                        <li><a href="javaScript:void(0)" data-category="app_des">App Design</a></li>
                    </ul>
                </div>
            </div>
        </div><!--/.container-->
        
        <div class="slider-wrapper-portfolio">
            <ul class="portfolio-item-slider">
                <li data-match="website_des">
                    <div class="inner-portfolio-sing">
                        <img src="{{ asset('assets/clientv3/img/home3/portfolio1.jpg') }}" alt="">
                        <div class="overlay-content">
                            <div class="txt">
                                <h2>Smiley Colleagues Working Together</h2>
                                <p>Working successful</p>
                            </div>
                        </div>
                    </div><!--/.inner-portfolio-sing-->
                </li>
                <li data-match="website_des">
                    <div class="inner-portfolio-sing">
                        <img src="{{ asset('assets/clientv3/img/home3/portfolio2.png') }}" alt="">
                        <div class="overlay-content">
                            <div class="txt">
                                <h2>Smiley Colleagues Working Together</h2>
                                <p>Working successful</p>
                            </div>
                        </div>
                    </div><!--/.inner-portfolio-sing-->
                </li>
                <li data-match="website_des">
                    <div class="inner-portfolio-sing">
                        <img src="{{ asset('assets/clientv3/img/home3/portfolio1.jpg') }}" alt="">
                        <div class="overlay-content">
                            <div class="txt">
                                <h2>Smiley Colleagues Working Together</h2>
                                <p>Working successful</p>
                            </div>
                        </div>
                    </div><!--/.inner-portfolio-sing-->
                </li>
                <li data-match="branding_des">
                    <div class="inner-portfolio-sing">
                        <img src="{{ asset('assets/clientv3/img/home3/portfolio2.png') }}" alt="">
                        <div class="overlay-content">
                            <div class="txt">
                                <h2>Smiley Colleagues Working Together</h2>
                                <p>Working successful</p>
                            </div>
                        </div>
                    </div><!--/.inner-portfolio-sing-->
                </li>
                <li data-match="branding_des">
                    <div class="inner-portfolio-sing">
                        <img src="{{ asset('assets/clientv3/img/home3/portfolio2.png') }}" alt="">
                        <div class="overlay-content">
                            <div class="txt">
                                <h2>Smiley Colleagues Working Together</h2>
                                <p>Working successful</p>
                            </div>
                        </div>
                    </div><!--/.inner-portfolio-sing-->
                </li>
                <li data-match="branding_des">
                    <div class="inner-portfolio-sing">
                        <img src="{{ asset('assets/clientv3/img/home3/portfolio3.png') }}" alt="">
                        <div class="overlay-content">
                            <div class="txt">
                                <h2>Smiley Colleagues Working Together</h2>
                                <p>Working successful</p>
                            </div>
                        </div>
                    </div><!--/.inner-portfolio-sing-->
                </li>
                <li data-match="app_des">
                    <div class="inner-portfolio-sing">
                        <img src="{{ asset('assets/clientv3/img/home3/portfolio1.jpg') }}" alt="">
                        <div class="overlay-content">
                            <div class="txt">
                                <h2>Smiley Colleagues Working Together</h2>
                                <p>Working successful</p>
                            </div>
                        </div>
                    </div><!--/.inner-portfolio-sing-->
                </li>
                <li data-match="app_des">
                    <div class="inner-portfolio-sing">
                        <img src="{{ asset('assets/clientv3/img/home3/portfolio3.png') }}" alt="">
                        <div class="overlay-content">
                            <div class="txt">
                                <h2>Smiley Colleagues Working Together</h2>
                                <p>Working successful</p>
                            </div>
                        </div>
                    </div><!--/.inner-portfolio-sing-->
                </li>
                <li data-match="app_des">
                    <div class="inner-portfolio-sing">
                        <img src="{{ asset('assets/clientv3/img/home3/portfolio2.png') }}" alt="">
                        <div class="overlay-content">
                            <div class="txt">
                                <h2>Smiley Colleagues Working Together</h2>
                                <p>Working successful</p>
                            </div>
                        </div>
                    </div><!--/.inner-portfolio-sing-->
                </li>
            </ul>
            <div class="slider-controls"><span class="prevSlide"><i class='bx bx-arrow-back'></i></span><span class="nextSlide"><i class='bx bx-arrow-back bx-rotate-180' ></i></span></div>
        </div>
    </section>
    <!--portfolio area end-->

    <!--team area start-->
    <section class="team-area-sec-v3 px-120">
        <div class="container">
            <div class="row g-0">
                <div class="col-12">
                    <div class="sec-title text-center">
                        <h3><img src="{{ asset('assets/clientv3/img/icons/title-icon-infinity.svg') }}" alt=""> Team Member</h3>
                        <h2 class="tag1">Creative Team Member</h2>
                    </div>
                </div>
                <div class="col-12 mt-50">
                    <div class="row g-4">
                        <div class="col-md-6 col-lg-3">
                            <div class="team-member-inner v3" data-aos="flip-left" data-aos-delay="100">
                                <div class="imgs">
                                    <img src="{{ asset('assets/clientv3/img/team1.jpg') }}" alt="">
                                    <div class="socials_v3">
                                        <ul>
                                            <li><a href="#"><i class="bx bxl-facebook"></i></a></li>
                                            <li><a href="#"><i class="bx bxl-twitter"></i></a></li>
                                            <li><a href="#"><i class="bx bxl-linkedin"></i></a></li>
                                            <li><a href="#"><i class="bx bxl-youtube"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cont">
                                    <div class="name">
                                        <h2>Robert Sions</h2>
                                        <p>Business Consultant</p>
                                    </div>
                                </div>
                            </div><!--/.team-member-inner-->
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="team-member-inner v3" data-aos="flip-left" data-aos-delay="300">
                                <div class="imgs">
                                    <img src="{{ asset('assets/clientv3/img/team2.jpg') }}" alt="">
                                    <div class="socials_v3">
                                        <ul>
                                            <li><a href="#"><i class="bx bxl-facebook"></i></a></li>
                                            <li><a href="#"><i class="bx bxl-twitter"></i></a></li>
                                            <li><a href="#"><i class="bx bxl-linkedin"></i></a></li>
                                            <li><a href="#"><i class="bx bxl-youtube"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cont">
                                    <div class="name">
                                        <h2>Ross Bing</h2>
                                        <p>App Developer</p>
                                    </div>
                                    
                                </div>
                            </div><!--/.team-member-inner-->
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="team-member-inner v3" data-aos="flip-left" data-aos-delay="500">
                                <div class="imgs">
                                    <img src="{{ asset('assets/clientv3/img/team3.jpg') }}" alt="">
                                    <div class="socials_v3">
                                        <ul>
                                            <li><a href="#"><i class="bx bxl-facebook"></i></a></li>
                                            <li><a href="#"><i class="bx bxl-twitter"></i></a></li>
                                            <li><a href="#"><i class="bx bxl-linkedin"></i></a></li>
                                            <li><a href="#"><i class="bx bxl-youtube"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cont">
                                    <div class="name">
                                        <h2>Karikok Jahan</h2>
                                        <p>Executive Manager</p>
                                    </div>
                                </div>
                            </div><!--/.team-member-inner-->
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="team-member-inner v3" data-aos="flip-left" data-aos-delay="700">
                                <div class="imgs">
                                    <img src="{{ asset('assets/clientv3/img/team4.jpg') }}" alt="">
                                    <div class="socials_v3">
                                        <ul>
                                            <li><a href="#"><i class="bx bxl-facebook"></i></a></li>
                                            <li><a href="#"><i class="bx bxl-twitter"></i></a></li>
                                            <li><a href="#"><i class="bx bxl-linkedin"></i></a></li>
                                            <li><a href="#"><i class="bx bxl-youtube"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cont">
                                    <div class="name">
                                        <h2>Dickerson MH</h2>
                                        <p>Agency Analysis</p>
                                    </div>
                                </div>
                            </div><!--/.team-member-inner-->
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/.container-->
    </section>
    <!--team area end-->


    <!--promo text start-->
    <div class="promo-text-area ">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="promo-cont-with-social overflow-hidden">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-3">
                                <div class="foloow-content">
                                    <h2>Follow Us:</h2>
                                    <div class="social_links">
                                        <ul>
                                            <li><a href="#"><i class="bx bxl-facebook"></i></a></li>
                                            <li><a href="#"><i class="bx bxl-twitter"></i></a></li>
                                            <li><a href="#"><i class="bx bxl-linkedin"></i></a></li>
                                            <li><a href="#"><i class="bx bxl-youtube"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="inner-promo-txt" data-aos="fade-left">
                                    <div class="d-lg-flex justify-content-between align-items-center">
                                        <div class="sec-title">
                                            <h3 class="text-white"><img src="img/icons/title-icon-infinity.svg" alt=""> We Are Hire</h3>
                                            <h2 class="text-white tag1">Tell us About Your Business, We are Ready to Solve.</h2>
                                        </div>
                                        <div class="btn-area mt-3 mt-lg-0">
                                            <a href="contact.html" class="btn btn-default">Contact Us</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div><!--/.promo-cont-with-social-->
                </div>
            </div>
        </div><!--/.container-->
        <span class="banner-frame-one"></span>
        <span class="banner-frame-two"></span>
        <span class="banner-frame-three"></span>
        <span class="banner-frame-four"></span>
        <div class="shape-top-left" data-aos="fade-down" data-aos-delay="500"></div>
        <div class="shape-bottom-right" data-aos="fade-up"
        data-aos-anchor-placement="top-bottom" data-aos-delay="1000"></div>
    </div>
    <!--promo text end-->

    <!--testimonial_v3 area start-->
    <div class="testimonial-sec-v3 px-120">
        <div class="container">
            <div class="row g-4 align-items-center justify-content-center">
                
                <div class="col-xl-6 order-xl-2">
                    <div class="sec-title mb-50">
                        <h3><img src="img/icons/title-icon.svg" alt=""> Testimonial</h3>
                        <h2 class="tag1">What Our Client Say</h2>
                    </div>
                    <div class="testimonial-slider-v3">
                        <div class="single">
                            <div class="feedback-inner-single v3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="quote">
                                        <i class="bx bxs-quote-left"></i>
                                    </div>
                                    <div class="ratings d-flex">
                                        <i class="bx bxs-star"></i>
                                        <i class="bx bxs-star"></i>
                                        <i class="bx bxs-star"></i>
                                        <i class="bx bxs-star"></i>
                                        <i class="bx bxs-star"></i>
                                    </div>
                                </div>
                                <p>There are many variations of passages of Lorem as Ipsum the vaila the majority have suffered alteration in some form by injectes our, or rando word which don't look even slightly a believable. If you are going to use a passage of Lorem Ipsum.</p>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-0">
                                        <img src="img/testi1.png" alt="">
                                    </div>
                                    <div class="flex-shrink-1">
                                        <h2>John Waon</h2>
                                        <h5>App Designer</h5>
                                    </div>
                                </div>
                            </div><!--/.feedback-inner-single-->
                        </div>
                        <div class="single">
                            <div class="feedback-inner-single v3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="quote">
                                        <i class="bx bxs-quote-left"></i>
                                    </div>
                                    <div class="ratings d-flex">
                                        <i class="bx bxs-star"></i>
                                        <i class="bx bxs-star"></i>
                                        <i class="bx bxs-star"></i>
                                        <i class="bx bxs-star"></i>
                                        <i class="bx bxs-star"></i>
                                    </div>
                                </div>
                                <p>There are many variations of passages of Lorem as Ipsum the vaila the majority have suffered alteration in some form by injectes our, or rando word which don't look even slightly a believable. If you are going to use a passage of Lorem Ipsum.</p>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-0">
                                        <img src="img/testi2.jpg" alt="">
                                    </div>
                                    <div class="flex-shrink-1">
                                        <h2>John Waon</h2>
                                        <h5>App Designer</h5>
                                    </div>
                                </div>
                            </div><!--/.feedback-inner-single-->
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 order-xl-1">
                    <div class="left-images-about-v3">
                        <div class="inner-imgs fact">
                            <div class="fact-wrapper fact-one">
                                <h2 class="tag1">150 +</h2>
                                <p>Happy Clients</p>
                            </div>
                            <div class="fact-wrapper fact-two">
                                <h2 class="tag1">120 +</h2>
                                <p>Awards Win</p>
                            </div>
                            <div class="fact-wrapper fact-three">
                                <h2 class="tag1">95 +</h2>
                                <p>Professional Team</p>
                            </div>
                            <div class="fact-wrapper fact-four">
                                <h2 class="tag1">1500 +</h2>
                                <p>Project Complete</p>
                            </div>
                            <div class="shape-one"></div>
                            <div class="banner-frame-two"></div>
                            <div class="shape-two"></div>
                            <div class="shape-three"></div>
                            <div class="shape-four"></div>
                            <div class="radius-1"></div>
                            <img src="img/home3/about-shape1.svg" class="shape-bg-1" alt="">
                            <div class="arrows-teti">
                                <button class="prev-testim"><i class="bx bx-arrow-back"></i></button>
                                <button class="next-testim"><i class="bx bx-arrow-back bx-rotate-180" ></i></button>
                            </div>
                        </div>
                    </div><!--/.left-images-about-v3-->
                </div>
            </div>
        </div><!--/.container-->
    </div>
    <!--testimonial area end-->

    <!--blog area start-->
    <section class="blog-sec-v3 px-120">
        <div class="container">
            <div class="row g-0">
                <div class="col-12">
                    <div class="sec-title text-center">
                        <h3><img src="img/icons/title-icon-infinity.svg" alt="">Our Blog</h3>
                        <h2 class="tag1">Latest Blogs & Articles</h2>
                    </div>
                </div>
                <div class="col-12 mt-50">
                    <div class="row justify-content-center g-4 ">
                        <div class="col-lg-6">
                            <div class="single-blog-inner v3">
                                <div class="imgs">
                                    <img src="img/home3/blog1.jpg" alt="">
                                    <a href="blog-details.html" class="single-links">hidden link</a>
                                </div>
                                <div class="conts">
                                    <ul class="meta">
                                        <li><img src="img/icons/tags.svg" alt=""><span>Business Planning</span></li>
                                        <li><img src="img/icons/messages.svg" alt=""> <span>22</span></li>
                                        <li><img src="img/icons/eye.svg" alt=""> <span>120 Views</span></li>
                                    </ul>
                                    <h2><a href="blog-details.html">Staff meeting group a young modern people smart in casual wear discussing</a></h2>
                                    <div class="d-flex justify-content-between align-items-center author">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-0">
                                                <img src="img/testi3.jpg" alt="">
                                            </div>
                                            <div class="flex-shrink-1">
                                                <p>by Kristin</p>
                                            </div>
                                        </div>
                                        <a href="blog-details.html" class="read-more">Read More <span><i class='bx bx-arrow-back bx-rotate-180' ></i></span></a>
                                    </div>
                                </div>
                            </div><!--/.single-blog-inner-->
                        </div>
                        <div class="col-lg-6">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="single-blog-inner v3 smaller" data-aos="fade-up" data-aos-delay="100">
                                        <div class="d-sm-flex align-items-center">
                                            <div class="flex-grow-0">
                                                <div class="imgs">
                                                    <img src="img/home3/blog2.jpg" alt="">
                                                    <a href="blog-details.html" class="single-links">hidden link</a>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-1">
                                                <div class="conts">
                                                    <ul class="meta">
                                                        <li><img src="img/icons/tags.svg" alt=""><span>Business Planning</span></li>
                                                        <li><img src="img/icons/messages.svg" alt=""> <span>22</span></li>
                                                        <li><img src="img/icons/eye.svg" alt=""> <span>120 Views</span></li>
                                                    </ul>
                                                    <h2><a href="blog-details.html">Successful business partners having
                                                        discussing new business</a></h2>
                                                    <div class="d-flex justify-content-between align-items-center author">
                                                        <div class="d-flex">
                                                            <div class="flex-grow-0">
                                                                <img src="img/testi3.jpg" alt="">
                                                            </div>
                                                            <div class="flex-shrink-1">
                                                                <p>by Kristin</p>
                                                            </div>
                                                        </div>
                                                        <a href="blog-details.html" class="read-more">Read More <span><i class='bx bx-arrow-back bx-rotate-180' ></i></span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--/.single-blog-inner-->
                                </div>
                                <div class="col-12">
                                    <div class="single-blog-inner v3 smaller" data-aos="fade-up" data-aos-delay="300">
                                        <div class="d-sm-flex align-items-center">
                                            <div class="flex-grow-0">
                                                <div class="imgs">
                                                    <img src="img/home3/blog3.jpg" alt="">
                                                    <a href="blog-details.html" class="single-links">hidden link</a>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-1">
                                                <div class="conts">
                                                    <ul class="meta">
                                                        <li><img src="img/icons/tags.svg" alt=""><span>Business Planning</span></li>
                                                        <li><img src="img/icons/messages.svg" alt=""> <span>22</span></li>
                                                        <li><img src="img/icons/eye.svg" alt=""> <span>120 Views</span></li>
                                                    </ul>
                                                    <h2><a href="blog-details.html">Female logo designer working on a her tablet connected</a></h2>
                                                    <div class="d-flex justify-content-between align-items-center author">
                                                        <div class="d-flex">
                                                            <div class="flex-grow-0">
                                                                <img src="img/testi3.jpg" alt="">
                                                            </div>
                                                            <div class="flex-shrink-1">
                                                                <p>by Kristin</p>
                                                            </div>
                                                        </div>
                                                        <a href="blog-details.html" class="read-more">Read More <span><i class='bx bx-arrow-back bx-rotate-180' ></i></span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--/.single-blog-inner-->
                                </div>
                                <div class="col-12">
                                    <div class="single-blog-inner v3 smaller" data-aos="fade-up" data-aos-delay="500">
                                        <div class="d-sm-flex align-items-center">
                                            <div class="flex-grow-0">
                                                <div class="imgs">
                                                    <img src="img/home3/blog4.jpg" alt="">
                                                    <a href="blog-details.html" class="single-links">hidden link</a>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-1">
                                                <div class="conts">
                                                    <ul class="meta">
                                                        <li><img src="img/icons/tags.svg" alt=""><span>Business Planning</span></li>
                                                        <li><img src="img/icons/messages.svg" alt=""> <span>22</span></li>
                                                        <li><img src="img/icons/eye.svg" alt=""> <span>120 Views</span></li>
                                                    </ul>
                                                    <h2><a href="blog-details.html">Group of people working business plan in an office</a></h2>
                                                    <div class="d-flex justify-content-between align-items-center author">
                                                        <div class="d-flex">
                                                            <div class="flex-grow-0">
                                                                <img src="img/testi3.jpg" alt="">
                                                            </div>
                                                            <div class="flex-shrink-1">
                                                                <p>by Kristin</p>
                                                            </div>
                                                        </div>
                                                        <a href="blog-details.html" class="read-more">Read More <span><i class='bx bx-arrow-back bx-rotate-180' ></i></span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--/.single-blog-inner-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/.container-->
    </section>
    <!--blog area end-->

    <!--partner area start-->
    <div class="partner-area-wrap px-120">
        <div class="container">
            <div class="col-12">
                <div class="partner-logo-slider">
                    <div class="single">
                        <div class="logo-sl-inner">
                            <img src="img/home2/partner1.png" alt="">
                        </div><!--/.logo-sl-inner-->
                    </div>
                    <div class="single">
                        <div class="logo-sl-inner">
                            <img src="img/home2/partner2.png" alt="">
                        </div><!--/.logo-sl-inner-->
                    </div>
                    <div class="single">
                        <div class="logo-sl-inner">
                            <img src="img/home2/partner3.png" alt="">
                        </div><!--/.logo-sl-inner-->
                    </div>
                    <div class="single">
                        <div class="logo-sl-inner">
                            <img src="img/home2/partner4.png" alt="">
                        </div><!--/.logo-sl-inner-->
                    </div>
                    <div class="single">
                        <div class="logo-sl-inner">
                            <img src="img/home2/partner5.png" alt="">
                        </div><!--/.logo-sl-inner-->
                    </div>
                </div><!--/.partner-logo-slider-->
            </div>
        </div><!--/.container-->
    </div>
    <!--partner area end-->
@endsection