<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="Este es el administrador de Opemedios. Sistema Integral de Administración de Opemedios">
  <meta name="author" content="Isaac Batista ">
  <!--<link rel="shortcut icon" href="../images/favicon.png" type="image/png">-->

  <title>Opemedios @yield('admin-title', '- Admin')</title>

  <link rel="stylesheet" href="{{ asset('lib/Hover/hover.css') }}">
  <link rel="stylesheet" href="{{ asset('lib/fontawesome/css/font-awesome.css') }}">
  <link rel="stylesheet" href="{{ asset('lib/weather-icons/css/weather-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('lib/ionicons/css/ionicons.css') }}">
  <link rel="stylesheet" href="{{ asset('lib/jquery-toggles/toggles-full.css') }}">
  <link rel="stylesheet" href="{{ asset('lib/morrisjs/morris.css') }}">

  <link rel="stylesheet" href="{{ asset('css/quirk.css') }}">

  <script src="{{ asset('lib/modernizr/modernizr.js') }}"></script>

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="{{ asset('lib/html5shiv/html5shiv.js') }}"></script>
  <script src="{{ asset('lib/respond/respond.src.js') }}"></script>
  <![endif]-->
</head>

<body>
  @include('admin.header')
  <section>
    @include('admin.sidebar')
    <div class="mainpanel">

      <div class="contentpanel">
        @include('admin.breadcrumb')
        <!-- content goes here... -->
        @yield('content')

      </div><!-- contentpanel -->
    </div><!-- mainpanel -->
</section>

<script src="{{ asset('lib/jquery/jquery.js') }}"></script>
<script src="{{ asset('lib/jquery-ui/jquery-ui.js') }}"></script>
<script src="{{ asset('lib/bootstrap/js/bootstrap.js') }}"></script>
<script src="{{ asset('lib/jquery-toggles/toggles.js') }}"></script>

<script src="{{ asset('js/quirk.js') }}"></script>
</body>
</html>
