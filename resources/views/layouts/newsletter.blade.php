<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Opemedios Newsletter</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="{{ asset('uikit/css/uikit.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('icomoon/style.css') }}" />
    <!-- Style -->
    <link href="{{ asset('css/style.css') }}" media="all" rel="stylesheet" type="text/css">
</head>
<body>
    <article class="uk-container">        
    @yield('content')
    </article>

    <footer class="uk-text-muted uk-container">
        <div class="uk-flex uk-padding uk-padding-large uk-padding-remove-horizontal uk-padding-remove-bottom" uk-grid>
            <p>
                <a href="https://opemedios.com.mx" class="uk-text-muted">Copyright &copy; {{ date('Y') }}, Opemedios</a>
            </p>
            <p class="uk-flex-first@s">
                <strong>Power by:</strong> <a href="https://twitter.com/codeisaac" class="uk-text-muted">{{ '@codeisaac' }}</a> <a href="mailto:{{ 'daniel@danielbat.com' }}" class="uk-text-muted">{{ 'daniel@danielbat.com' }}</a>
            </p>
        </div>
    </footer>
    <script src="{{ asset('uikit/js/uikit.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/pdfobject.min.js') }}"></script>
    <script>
    if(!PDFObject.supportsPDFs){
        $(".lightbox.pdf").addClass('uk-hidden');
        $(".no-pdf-inline").removeClass('uk-hidden');
    }
    </script>
</body>
</html>