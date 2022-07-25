<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="Este es el login de la pagina de opemedios">
  <meta name="author" content="Isaac Daniel Batista">
  <!--<link rel="shortcut icon" href="../images/favicon.png" type="image/png">-->

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Opemedios') }}@yield('title-section', ' - ')</title>

  <link rel="stylesheet" href="{{ asset('lib/fontawesome/css/font-awesome.css') }}">

  <link rel="stylesheet" href="{{ asset('css/quirk.css') }}">

  <script src="{{ asset('lib/modernizr/modernizr.js') }}"></script>
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="{{ asset('lib/html5shiv/html5shiv.js') }}"></script>
  <script src="{{ asset('lib/respond/respond.src.js') }}"></script>
  <![endif]-->
  {!! NoCaptcha::renderJs() !!}
</head>

<body class="signwrapper">

  <div class="sign-overlay"></div>
  <div class="signpanel"></div>

  @yield('content')

  @yield('scripts')

</body>
</html>
