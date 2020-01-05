<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Opemedios Newsletter</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <div class="navbar">
            <div class="container d-flex justify-content-between">
                <a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center">
                    {{-- <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg> --}}
                    <strong>Opemedios - {{ $company->name }}</strong>
                </a>
            </div>
        </div>
    </header>
    @yield('content')
    <footer class="text-muted">
        <div class="container">
            <p class="float-right">
                <a href="https://opemedios.com.mx">Copyright &copy; {{ date('Y') }}, Opemedios</a>
            </p>
            <p><strong>Power by:</strong> <a href="https://twitter.com/codeisaac">{{ '@codeisaac' }}</a> <a href="mailto:{{ 'daniel@danielbat.com' }}">{{ 'daniel@danielbat.com' }}</a></p>
        </div>
    </footer>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>