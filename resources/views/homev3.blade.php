@extends('layouts.home-clientv3')
@section('content')
    {{-- ========================================
         HERO SECTION - SaaS Modern
    ======================================== --}}
    <section class="hero-saas">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        {{-- Badge --}}
                        <div class="hero-badge" data-aos="fade-up">
                            <span class="badge-dot"></span>
                            <span>+20 años de experiencia en monitoreo</span>
                        </div>

                        {{-- Two-Tier Title --}}
                        <h1 class="hero-title" data-aos="fade-up" data-aos-delay="100">
                            <span class="line-1">Expertos en</span>
                            <span class="line-2">Monitoreo de Medios</span>
                        </h1>

                        <p class="hero-description" data-aos="fade-up" data-aos-delay="200">
                            Somos tus ojos y oídos para la toma de decisiones. Especialistas en análisis de información en radio, televisión, periódicos, revistas, sitios web y redes sociales.
                        </p>

                        {{-- CTA Buttons --}}
                        <div class="hero-cta" data-aos="fade-up" data-aos-delay="300">
                            <a href="#contacto" class="btn-saas btn-saas-primary btn-saas-lg">
                                Solicitar Demo
                                <i class='bx bx-right-arrow-alt'></i>
                            </a>
                            <a href="#servicios" class="btn-saas btn-saas-secondary btn-saas-lg">
                                Ver Servicios
                            </a>
                        </div>

                        {{-- Stats --}}
                        <div class="hero-stats" data-aos="fade-up" data-aos-delay="400">
                            <div class="stat-item">
                                <span class="stat-number">150+</span>
                                <span class="stat-label">Clientes Activos</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">48</span>
                                <span class="stat-label">Estaciones de Radio <br><small>Monitoreo Continuo</small></span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">35</span>
                                <span class="stat-label">Canales de TV <br><small>Tiempo Real</small></span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number"><i class='bx bx-globe'></i></span>
                                <span class="stat-label">Cobertura Multicanal <br><small>Prensa, Revistas, Redes Sociales y Sitios Web</small></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-visual" data-aos="fade-left" data-aos-delay="200">
                        <div class="hero-image-wrapper">
                            <img src="{{ asset('assets/clientv3/img/pexels-home4.jpg') }}" alt="Dashboard Opemedios" class="hero-image-main">
                            {{-- Floating Cards --}}
                            <div class="hero-float-card card-1">
                                <div class="d-flex align-items-center gap-2">
                                    <i class='bx bx-trending-up' style="color: #10b981; font-size: 1.5rem;"></i>
                                    <div>
                                        <small style="color: var(--ope-gray-500); font-size: 0.75rem;">Menciones hoy</small>
                                        <div style="font-weight: 700; color: var(--ope-dark);">+2,847</div>
                                    </div>
                                </div>
                            </div>
                            <div class="hero-float-card card-2">
                                <div class="d-flex align-items-center gap-2">
                                    <i class='bx bx-check-circle' style="color: #2563eb; font-size: 1.5rem;"></i>
                                    <div>
                                        <small style="color: var(--ope-gray-500); font-size: 0.75rem;">Cobertura</small>
                                        <div style="font-weight: 700; color: var(--ope-dark);">Nacional</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ========================================
         MONITOREOS SECTION - Feature Cards
    ======================================== --}}
    <section class="section-padding bg-gray-light" id="monitoreos">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="section-title-modern text-center" data-aos="fade-up">
                        <span class="section-badge">
                            <i class='bx bx-broadcast'></i>
                            Nuestros Monitoreos
                        </span>
                        <h2>
                            Cobertura <span class="text-gradient">Multiplataforma</span>
                        </h2>
                        <p>Monitoreamos todos los canales de comunicación para que no te pierdas ninguna mención importante.</p>
                    </div>
                </div>
            </div>
            <div class="row g-4 mt-2">
                {{-- Card 1: Radio y TV --}}
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card-modern">
                        <div class="feature-icon">
                            <img src="{{ asset('assets/clientv3/img/icons/icon-radio.png') }}" alt="Radio y TV">
                        </div>
                        <span class="feature-number">01</span>
                        <h3>Radio y Televisión</h3>
                        <p>Grabamos continuamente 48 estaciones de radio en AM y FM y 25 canales de televisión, monitoreando noticias, opinión, espectáculos, finanzas y deportes las 24 horas.</p>
                    </div>
                </div>
                {{-- Card 2: Periódicos --}}
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card-modern">
                        <div class="feature-icon">
                            <img src="{{ asset('assets/clientv3/img/icons/icon-periodico.png') }}" alt="Periódicos">
                        </div>
                        <span class="feature-number">02</span>
                        <h3>Periódicos y Revistas</h3>
                        <p>Búsqueda de información en principales diarios nacionales: Reforma, El Universal, Milenio, La Jornada, Excélsior, El Financiero y revistas especializadas.</p>
                    </div>
                </div>
                {{-- Card 3: Digital --}}
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card-modern">
                        <div class="feature-icon">
                            <img src="{{ asset('assets/clientv3/img/icons/icon-internet.png') }}" alt="Digital">
                        </div>
                        <span class="feature-number">03</span>
                        <h3>Sitios Web y Redes Sociales</h3>
                        <p>Monitoreo de portales de información general y especializados, análisis de redes sociales con rankeo integral de posicionamiento y análisis estratégico.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ========================================
         ABOUT SECTION - Modern
    ======================================== --}}
    <section class="about-section-modern" id="nosotros">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="about-image-grid">
                        <img src="{{ asset('assets/clientv3/img/pexels-alena-darmel-7710155.jpg') }}" alt="Equipo ejecutivo Opemedios" class="img-large">
                        <img src="{{ asset('assets/clientv3/img/pexels-servicio1.jpg') }}" alt="Análisis de medios">
                        <img src="{{ asset('assets/clientv3/img/pexels-kindel-media-7688331.jpg') }}" alt="Trabajo en equipo">
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="section-title-modern">
                        <span class="section-badge">
                            <i class='bx bx-buildings'></i>
                            Sobre Nosotros
                        </span>
                        <h2>
                            Servicio <span class="text-gradient">Personalizado</span>
                        </h2>
                        <p>Somos una empresa líder en monitoreo y análisis de medios. Nuestro equipo está conformado por profesionales especializados en comunicación.</p>
                    </div>

                    <div class="about-features-list">
                        <div class="about-feature-item">
                            <div class="feature-icon">
                                <i class='bx bx-target-lock'></i>
                            </div>
                            <div>
                                <h4>Misión</h4>
                                <p>Convertirnos en tus ojos y oídos para que tomes las mejores decisiones basadas en información precisa.</p>
                            </div>
                        </div>
                        <div class="about-feature-item">
                            <div class="feature-icon">
                                <i class='bx bx-world'></i>
                            </div>
                            <div>
                                <h4>Visión</h4>
                                <p>Brindar un servicio personalizado que supere las expectativas de cada cliente con tecnología de vanguardia.</p>
                            </div>
                        </div>
                    </div>

                    <a href="#contacto" class="btn-saas btn-saas-primary mt-4">
                        Conocer más
                        <i class='bx bx-right-arrow-alt'></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ========================================
         SERVICES SECTION - Horizontal Cards
    ======================================== --}}
    <section class="services-section-modern" id="servicios">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="section-title-modern text-center" data-aos="fade-up">
                        <span class="section-badge">
                            <i class='bx bx-cog'></i>
                            Nuestros Servicios
                        </span>
                        <h2>
                            Servicios <span class="text-gradient">Exclusivos</span>
                        </h2>
                        <p>Soluciones integrales de monitoreo y análisis adaptadas a las necesidades de tu organización.</p>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    {{-- Service 1 --}}
                    <div class="service-card-horizontal" data-aos="fade-up" data-aos-delay="100">
                        <img src="{{ asset('assets/clientv3/img/pexels-servicio1.jpg') }}" alt="Monitoreo Integral" class="service-image">
                        <div class="service-content">
                            <h3>Monitoreo Integral de Medios</h3>
                            <p>Servicio completo de monitoreo en radio, televisión, periódicos, revistas, sitios web y redes sociales. Utilizamos tecnologías avanzadas para rastrear y recopilar datos relevantes, proporcionando una visión completa de tu presencia mediática.</p>
                        </div>
                        <div class="service-link">
                            <a href="#contacto" class="btn-saas btn-saas-secondary">
                                Más Info
                                <i class='bx bx-right-arrow-alt'></i>
                            </a>
                        </div>
                    </div>

                    {{-- Service 2 --}}
                    <div class="service-card-horizontal" data-aos="fade-up" data-aos-delay="200">
                        <img src="{{ asset('assets/clientv3/img/pexels-servicio2.jpg') }}" alt="Análisis de Temas" class="service-image">
                        <div class="service-content">
                            <h3>Análisis Detallado de Temas o Palabras Clave</h3>
                            <p>Análisis exhaustivo de los temas y palabras clave que usted elija. Nuestra tecnología de procesamiento de lenguaje natural identifica patrones, tendencias y cambios en la narrativa mediática.</p>
                        </div>
                        <div class="service-link">
                            <a href="#contacto" class="btn-saas btn-saas-secondary">
                                Más Info
                                <i class='bx bx-right-arrow-alt'></i>
                            </a>
                        </div>
                    </div>

                    {{-- Service 3 --}}
                    <div class="service-card-horizontal" data-aos="fade-up" data-aos-delay="300">
                        <img src="{{ asset('assets/clientv3/img/pexels-karolina-grabowska-7681091-servicio3.jpg') }}" alt="Informe Competencia" class="service-image">
                        <div class="service-content">
                            <h3>Informe de Competencia Mediática</h3>
                            <p>Informe detallado comparando tu presencia mediática con la competencia. Analizamos cobertura, frecuencia de menciones y otros factores clave para optimizar tu estrategia.</p>
                        </div>
                        <div class="service-link">
                            <a href="#contacto" class="btn-saas btn-saas-secondary">
                                Más Info
                                <i class='bx bx-right-arrow-alt'></i>
                            </a>
                        </div>
                    </div>

                    {{-- Service 4 --}}
                    <div class="service-card-horizontal" data-aos="fade-up" data-aos-delay="400">
                        <img src="{{ asset('assets/clientv3/img/pexels-mikael-blomkvist-6483619-servicio4.jpg') }}" alt="Reportes Personalizados" class="service-image">
                        <div class="service-content">
                            <h3>Resúmenes, Notificaciones y Reportes Personalizados</h3>
                            <p>Entrega de información completamente personalizada: resúmenes diarios, notificaciones instantáneas y reportes periódicos con análisis profundos de tu presencia mediática.</p>
                        </div>
                        <div class="service-link">
                            <a href="#contacto" class="btn-saas btn-saas-secondary">
                                Más Info
                                <i class='bx bx-right-arrow-alt'></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ========================================
         WHY CHOOSE US - Modern
    ======================================== --}}
    <section class="why-choose-modern">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <img src="{{ asset('assets/clientv3/img/pexels-alena-darmel-7710155.jpg') }}" alt="Por qué elegirnos" class="img-fluid" style="border-radius: var(--radius-xl); box-shadow: var(--shadow-xl);">
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="section-title-modern">
                        <span class="section-badge">
                            <i class='bx bx-award'></i>
                            Por Qué Elegirnos
                        </span>
                        <h2>
                            Transformamos datos en <span class="text-gradient">conocimiento</span>
                        </h2>
                    </div>

                    <div class="mt-4">
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class='bx bx-check-shield'></i>
                            </div>
                            <div class="benefit-content">
                                <h4>Servicios de Calidad</h4>
                                <p>Nuestros servicios destacan por su precisión, profundidad y atención meticulosa a cada detalle.</p>
                            </div>
                        </div>

                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class='bx bx-line-chart'></i>
                            </div>
                            <div class="benefit-content">
                                <h4>Mejor Proceso de Trabajo</h4>
                                <p>Seguimos el mejor proceso en análisis y gestión de información mediática del mercado.</p>
                            </div>
                        </div>

                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class='bx bx-globe'></i>
                            </div>
                            <div class="benefit-content">
                                <h4>Amplia Cobertura</h4>
                                <p>Cobertura sin igual desde radio y televisión hasta periódicos, revistas, sitios web y redes sociales.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ========================================
         TESTIMONIALS SECTION - Modern Cards
    ======================================== --}}
    <section class="testimonials-section" id="testimonios">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="section-title-modern text-center" data-aos="fade-up">
                        <span class="section-badge">
                            <i class='bx bx-message-square-dots'></i>
                            Testimonios
                        </span>
                        <h2>
                            Lo que dicen nuestros <span class="text-gradient">Clientes</span>
                        </h2>
                        <p>Empresas líderes confían en Opemedios para su monitoreo de medios.</p>
                    </div>
                </div>
            </div>

            <div class="row g-4 mt-2">
                {{-- Testimonial 1 --}}
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="testimonial-card-modern">
                        <div class="testimonial-header">
                            <div class="testimonial-quote-icon">
                                <i class='bx bxs-quote-left'></i>
                            </div>
                            <div class="testimonial-rating">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                            </div>
                        </div>
                        <div class="testimonial-content">
                            <p class="testimonial-text">"La plataforma nos entrega análisis de datos estructurados que facilitan la toma de decisiones críticas. Recibir la información filtrada y analizada nos ahorra horas de trabajo y nos permite enfocarnos en lo que realmente importa: nuestra estrategia."</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="https://ui-avatars.com/api/?name=Elena+Garcia&background=2563eb&color=fff" alt="Elena García" class="author-avatar">
                            <div class="author-info">
                                <h4>Elena García</h4>
                                <p>Directora de Estrategia Digital</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Testimonial 2 --}}
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-card-modern">
                        <div class="testimonial-header">
                            <div class="testimonial-quote-icon">
                                <i class='bx bxs-quote-left'></i>
                            </div>
                            <div class="testimonial-rating">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                            </div>
                        </div>
                        <div class="testimonial-content">
                            <p class="testimonial-text">"Lo que más valoramos es la puntualidad. El resumen informativo llega sin falta a primera hora, permitiendo que nuestro equipo directivo esté alineado con el pulso mediático antes de iniciar su primera reunión. Es eficiencia pura."</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="https://ui-avatars.com/api/?name=Javier+Munguia&background=0ea5e9&color=fff" alt="Javier Munguía" class="author-avatar">
                            <div class="author-info">
                                <h4>Javier Munguía</h4>
                                <p>Gerente de Comunicación Externa</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Testimonial 3 --}}
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="testimonial-card-modern">
                        <div class="testimonial-header">
                            <div class="testimonial-quote-icon">
                                <i class='bx bxs-quote-left'></i>
                            </div>
                            <div class="testimonial-rating">
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                                <i class='bx bxs-star'></i>
                            </div>
                        </div>
                        <div class="testimonial-content">
                            <p class="testimonial-text">"La precisión de Opemedios es excepcional. Gracias a su cobertura en prensa, radio, televisión y medios digitales, tenemos la seguridad de que ninguna mención relevante se nos escapa. Es una herramienta clave para nuestra gestión diaria."</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="https://ui-avatars.com/api/?name=Ricardo+Trejo&background=06b6d4&color=fff" alt="Ricardo Trejo" class="author-avatar">
                            <div class="author-info">
                                <h4>Ricardo Trejo</h4>
                                <p>Jefe de Relaciones Institucionales</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stats Row --}}
            <div class="row g-4 mt-5">
                <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="testimonial-stat-card">
                        <span class="stat-number">150+</span>
                        <span class="stat-label">Clientes Activos</span>
                    </div>
                </div>
                <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-stat-card">
                        <span class="stat-number">20+</span>
                        <span class="stat-label">Años de Experiencia</span>
                    </div>
                </div>
                <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="testimonial-stat-card">
                        <span class="stat-number">98%</span>
                        <span class="stat-label">Satisfacción</span>
                    </div>
                </div>
                <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="testimonial-stat-card">
                        <span class="stat-number">24/7</span>
                        <span class="stat-label">Monitoreo Continuo</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ========================================
         STRATEGIC BENEFITS SECTION - Modern
    ======================================== --}}
    <section class="section-padding bg-gray-light" id="beneficios">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="section-title-modern text-center" data-aos="fade-up">
                        <span class="section-badge">
                            <i class='bx bx-trending-up'></i>
                            Valor para tu negocio
                        </span>
                        <h2>
                            Resultados que Impulsan <span class="text-gradient">Tu Crecimiento</span>
                        </h2>
                        <p>Transforma la información mediática en ventajas competitivas tangibles para tu organización.</p>
                    </div>
                </div>
            </div>

            <div class="row g-4 mt-2">
                {{-- Card 1: Eficiencia Operativa --}}
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card-modern">
                        <div class="feature-icon">
                            <i class='bx bx-time-five'></i>
                        </div>
                        <h3>Ahorro de Tiempo Real</h3>
                        <p>Centralizamos toda la información relevante en un solo tablero, eliminando las búsquedas manuales y permitiendo que tu equipo se enfoque en la estrategia.</p>
                    </div>
                </div>

                {{-- Card 2: Gestión de Riesgos --}}
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card-modern">
                        <div class="feature-icon">
                            <i class='bx bx-shield-quarter'></i>
                        </div>
                        <h3>Alertas Tempranas</h3>
                        <p>Detecta menciones negativas antes de que se conviertan en tendencia. Protege la reputación de tu marca con notificaciones inmediatas para actuar de forma proactiva.</p>
                    </div>
                </div>

                {{-- Card 3: Inteligencia Ejecutiva --}}
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card-modern">
                        <div class="feature-icon">
                            <i class='bx bx-bar-chart-alt-2'></i>
                        </div>
                        <h3>Reportes de Alto Nivel</h3>
                        <p>Genera síntesis ejecutivas con datos estructurados y visualizaciones profesionales listas para ser presentadas en juntas directivas con un solo clic.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ========================================
         CTA SECTION
    ======================================== --}}
    <section class="cta-section-modern">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2>Cuéntanos sobre tu negocio</h2>
                <p>Estamos listos para ayudarte a monitorear y analizar tu presencia en medios. Contáctanos hoy mismo.</p>
                <a href="#contacto" class="btn-saas btn-saas-secondary btn-saas-lg">
                    Contactar Ahora
                    <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>
        </div>
    </section>

    {{-- ========================================
         CONTACT SECTION - Service Pills
    ======================================== --}}
    <section class="contact-section-modern section-padding" id="contacto">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="section-title-modern text-center" data-aos="fade-up">
                        <span class="section-badge">
                            <i class='bx bx-envelope'></i>
                            Contacto
                        </span>
                        <h2>
                            Solicita tu <span class="text-gradient">Demo Gratuita</span>
                        </h2>
                        <p>Selecciona el servicio que te interesa y nos pondremos en contacto contigo.</p>
                    </div>
                </div>
            </div>

            <div class="row g-5 mt-2">
                <div class="col-lg-7" data-aos="fade-right">
                    <div class="contact-form-wrapper">
                        {{-- Alert Messages --}}
                        @if (session('success'))
                            <div class="alert-modern alert-success" role="alert">
                                <i class='bx bx-check-circle'></i>
                                <span>{{ session('success') }}</span>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert-modern alert-error" role="alert">
                                <i class='bx bx-error-circle'></i>
                                <span>{{ session('error') }}</span>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert-modern alert-error" role="alert">
                                <i class='bx bx-error-circle'></i>
                                <div>
                                    <strong>Por favor corrige los siguientes errores:</strong>
                                    <ul class="mb-0 mt-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('form.contact.v3') }}" method="POST">
                            @csrf
                            {{-- Service Pills Selector --}}
                            <div class="service-pills-container">
                                <label class="service-pills-label">Selecciona el servicio de tu interés:</label>
                                <div class="service-pills">
                                    <div class="service-pill">
                                        <input type="radio" name="service_interest" id="servicio-monitoreo" value="monitoreo" {{ old('service_interest', 'monitoreo') == 'monitoreo' ? 'checked' : '' }}>
                                        <label for="servicio-monitoreo">
                                            <i class='bx bx-broadcast'></i>
                                            Monitoreo de Medios
                                        </label>
                                    </div>
                                    <div class="service-pill">
                                        <input type="radio" name="service_interest" id="servicio-redes" value="redes" {{ old('service_interest') == 'redes' ? 'checked' : '' }}>
                                        <label for="servicio-redes">
                                            <i class='bx bx-share-alt'></i>
                                            Redes Sociales
                                        </label>
                                    </div>
                                    <div class="service-pill">
                                        <input type="radio" name="service_interest" id="servicio-reputacion" value="reputacion" {{ old('service_interest') == 'reputacion' ? 'checked' : '' }}>
                                        <label for="servicio-reputacion">
                                            <i class='bx bx-shield-quarter'></i>
                                            Gestión de Reputación
                                        </label>
                                    </div>
                                    <div class="service-pill">
                                        <input type="radio" name="service_interest" id="servicio-reportes" value="reportes" {{ old('service_interest') == 'reportes' ? 'checked' : '' }}>
                                        <label for="servicio-reportes">
                                            <i class='bx bx-file'></i>
                                            Reportes Personalizados
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label for="name">Nombre completo <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control-modern @error('name') is-invalid @enderror" placeholder="Tu nombre" value="{{ old('name') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label for="company">Empresa</label>
                                        <input type="text" name="company" id="company" class="form-control-modern @error('company') is-invalid @enderror" placeholder="Nombre de tu empresa" value="{{ old('company') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label for="email">Correo electrónico <span class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email" class="form-control-modern @error('email') is-invalid @enderror" placeholder="tu@email.com" value="{{ old('email') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label for="phone">Teléfono</label>
                                        <input type="tel" name="phone" id="phone" class="form-control-modern @error('phone') is-invalid @enderror" placeholder="+52 55 1234 5678" value="{{ old('phone') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group-modern">
                                <label for="message">Mensaje</label>
                                <textarea name="message" id="message" class="form-control-modern @error('message') is-invalid @enderror" placeholder="Cuéntanos sobre tus necesidades de monitoreo...">{{ old('message') }}</textarea>
                            </div>

                            <button type="submit" class="btn-saas btn-saas-primary btn-saas-lg w-100">
                                Enviar Solicitud
                                <i class='bx bx-send'></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-5" data-aos="fade-left">
                    <div class="contact-info-card">
                        <div class="info-icon">
                            <i class='bx bx-phone'></i>
                        </div>
                        <div class="info-content">
                            <h4>Teléfonos</h4>
                            <a href="tel:5540304996">55 4030 4996</a>
                            <br>
                            <a href="tel:5534951145">55 3495 1145</a>
                        </div>
                    </div>

                    <div class="contact-info-card">
                        <div class="info-icon">
                            <i class='bx bx-envelope'></i>
                        </div>
                        <div class="info-content">
                            <h4>Email</h4>
                            <a href="mailto:contacto@opemedios.com.mx">contacto@opemedios.com.mx</a>
                        </div>
                    </div>

                    {{-- Social Links --}}
                    <div class="mt-4 pt-4" style="border-top: 1px solid var(--ope-gray-200);">
                        <h4 style="font-size: 1rem; font-weight: 600; color: var(--ope-dark); margin-bottom: 1rem;">Síguenos en redes</h4>
                        <div class="d-flex gap-2">
                            <a href="https://www.facebook.com/OpemediosMx" target="_blank" rel="noopener" class="btn-saas btn-saas-secondary" style="padding: 10px 14px;">
                                <i class='bx bxl-facebook'></i>
                            </a>
                            <a href="https://x.com/DeMonitoreo" target="_blank" rel="noopener" class="btn-saas btn-saas-secondary" style="padding: 10px 14px;">
                                <i class='bx bxl-twitter'></i>
                            </a>
                            <a href="https://www.linkedin.com/in/opemedios-an%C3%A1lisis-y-seguimiento-medi%C3%A1tico-8abba895/" target="_blank" rel="noopener" class="btn-saas btn-saas-secondary" style="padding: 10px 14px;">
                                <i class='bx bxl-linkedin'></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ========================================
         CLIENTS/PARTNERS SECTION
    ======================================== --}}
    <section class="clients-section" id="clientes">
        <div class="container">
            <div class="row justify-content-center mb-4">
                <div class="col-lg-6 text-center">
                    <p class="clients-subtitle">Empresas que confían en nosotros</p>
                </div>
            </div>
            <div class="clients-grid">
                <div class="client-logo-item">
                    <img src="{{ asset('images/clientes/logo_client_videocine.jpg') }}" alt="Videocine">
                </div>
                <div class="client-logo-item">
                    <img src="{{ asset('images/clientes/logo_client_sonyp.jpg') }}" alt="Sony Pictures">
                </div>
                <div class="client-logo-item">
                    <img src="{{ asset('images/clientes/logo_client_sony-channel.png') }}" alt="Sony Channel">
                </div>
                <div class="client-logo-item">
                    <img src="{{ asset('images/clientes/logo_client_sony_music.png') }}" alt="Sony Music">
                </div>
                <div class="client-logo-item">
                    <img src="{{ asset('images/clientes/logo_client_corazonfilms.jpeg') }}" alt="Corazón Films">
                </div>
                <div class="client-logo-item">
                    <img src="{{ asset('images/clientes/logo_client_ambulante.png') }}" alt="Documental Ambulante">
                </div>
                <div class="client-logo-item">
                    <img src="{{ asset('images/clientes/logo_client_FInternacional_Cine_Morelia.png') }}" alt="Festival Internacional de Cine de Morelia">
                </div>
                <div class="client-logo-item">
                    <img src="{{ asset('images/clientes/logo_client_FInternacional_cine_guadalajara.png') }}" alt="Festival Internacional de Cine de Guadalajara">
                </div>
                <div class="client-logo-item">
                    <img src="{{ asset('images/clientes/logo_client_premiosariel.jpeg') }}" alt="Premios Ariel">
                </div>
                <div class="client-logo-item">
                    <img src="{{ asset('images/clientes/logo_client_alphaville.png') }}" alt="Alphaville Cinema">
                </div>
                <div class="client-logo-item">
                    <img src="{{ asset('images/clientes/logo_client_difusion_cultural_unam.png') }}" alt="Difusión Cultural UNAM">
                </div>
            </div>
        </div>
    </section>
@endsection
