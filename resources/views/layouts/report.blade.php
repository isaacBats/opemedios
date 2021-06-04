<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    @yield('styles')
</head>
<body>
    @yield('content')
    <footer>
        <script src="{{ asset('lib/jquery/jquery.js') }}"></script>
        <script src="{{ asset('lib/flot/jquery.flot.js') }}"></script>
        <script src="{{ asset('lib/flot/jquery.flot.canvas.js') }}"></script>
        <script src="{{ asset('lib/flot/jquery.flot.categories.js') }}"></script>
        <script src="{{ asset('lib/flot/jquery.flot.pie.js') }}"></script>
        <script src="{{ asset('lib/flot/jquery.flot.resize.js') }}"></script>
        <script src="{{ asset('lib/flot/jquery.flot.selection.js') }}"></script>
        <script src="{{ asset('lib/flot/jquery.flot.stack.js') }}"></script>
        <script src="{{ asset('lib/flot/jquery.flot.symbol.js') }}"></script>
        @yield('scripts')
    </footer>
</body>
</html>