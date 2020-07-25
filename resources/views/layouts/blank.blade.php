<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Isaac Batista ">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('lib/jquery-ui/jquery-ui.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/fontawesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/select2/select2.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/timepicker/timepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/dropzone/dropzone.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/bootstrap-4.0.0/css/bootstrap-400.css') }}" rel="stylesheet">
    @yield('styles')
    <style>
        body{
            color: #696c74;
            background-color: #d8dce3;
            line-height: 1.42857143;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 12px;
        }
        h1, .h1 {
            font-size: 31px;
        }

        h1, .h1, h2, .h2, h3, .h3 {
            margin-top: 17px;
            margin-bottom: 8.5px;
        }

        h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
            font-family: inherit;
            font-weight: bold;
            line-height: 1.1;
            color: #262b36;
        }

        h1 {
            font-size: 2em;
            margin: 0.67em 0;        
        }
    </style>
</head>
<body>
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @include('modalb4')
    <script src="{{ asset('lib/jquery/jquery.js') }}"></script>
    <script src="{{ asset('lib/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('lib/bootstrap-4.0.0/js/bootstrap-400.js') }}"></script>
    <script src="{{ asset('lib/select2/select2.js') }}"></script>
    <script src="{{ asset('lib/timepicker/timepicker.js') }}"></script>
    <script src="{{ asset('lib/dropzone/dropzone.js') }}"></script>
    @yield('scripts')
</body>
</html>
