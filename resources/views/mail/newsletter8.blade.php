<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" style="width:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
<head>
    <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <meta name="x-apple-disable-message-reformatting">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="telephone=no" name="format-detection">
  <title>Newsletter - Opemedios</title><!--[if (mso 16)]>
    <style type="text/css">
    a {text-decoration: none;}
    </style>
    <![endif]--><!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--><!--[if gte mso 9]>
<xml>
    <o:OfficeDocumentSettings>
    <o:AllowPNG></o:AllowPNG>
    <o:PixelsPerInch>96</o:PixelsPerInch>
    </o:OfficeDocumentSettings>
</xml>
<![endif]--><!--[if !mso]><!-- -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 700px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-: #003C71;
            padding: 20px;color
            text-align: center;
        }
        .header img {
            max-width: 150px;
            height: auto;
        }
        .title-bar {
            background-color: #E0F4FF;
            color: #003C71;
            padding: 10px;
            text-align: center;
            font-size: 18px;
        }
        .date {
            text-align: center;
            color: #666;
            font-size: 14px;
            padding: 10px;
        }
        .main-content {
            padding: 20px;
        }
        .news-section {
            margin-bottom: 20px;
        }
        .news-title {
            color: #003C71;
            font-size: 18px;
            font-weight: bold;
        }
        .news-summary {
            color: #333;
            font-size: 14px;
        }
        .news-link {
            color: #0074B7;
            text-decoration: none;
        }
        .recommendation-section {
            background-color: #E0F4FF;
            padding: 20px;
        }
        .recommendation-title {
            color: #003C71;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }
        .footer {
            background-color: #003C71;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            font-size: 12px;
        }
        .footer a {
            color: #ffffff;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    @php
        $colorsConfig = unserialize($newsletterSend->newsletter->colors);
        $bgPrimary = isset($colorsConfig['bg_primary']) ? $colorsConfig['bg_primary'] : "#a7a189";
        $bgCovers = isset($colorsConfig['bg_covers']) ? $colorsConfig['bg_covers'] : "#afc4d2";
        $bgFontCovers = isset($colorsConfig['bg_font_covers']) ? $colorsConfig['bg_font_covers'] : "#3D5CA3";
        $bgTitleSecond = isset($colorsConfig['bg_title_second']) ? $colorsConfig['bg_title_second'] : "#e4e2d0";
        $bgBodyThemeSecond = isset($colorsConfig['bg_body_theme_second']) ? $colorsConfig['bg_body_theme_second'] : "#f9f8e8";
         $linksAllowed = array_chunk($linksAllowed, 2, true);
    @endphp
    <div class="container">
        <!-- Encabezado -->
        <div class="header">
            <img src="{{ asset("images/{$newsletterSend->newsletter->banner}") }}" alt="{{ $newsletterSend->newsletter->name }}">
        </div>
        
        <!-- Barra de Título -->
        <div class="title-bar">
            <h2>Hoy deberías saber</h2>
        </div>
        
        <!-- Fecha -->
        <div class="date">
            {{-- Fecha del newsletter--}}
            {{ Illuminate\Support\Carbon::parse(
                $newsletterSend->date_sending
               )->formatLocalized('%A %d de %B %Y')
            }}
        </div>
        
        <!-- Contenido Principal -->
        <div class="main-content">
            @foreach ($newsletterSend->newsletter->company->themes as $theme)
                <h3>{{ strtoupper($theme->name) }}</h3>
                @foreach ($newsletterSend->newsletter_theme_news as $note)
                    <!-- Sección de Noticias -->
                    <div class="news-section">
                        <h3 class="news-title">
                            <a href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}" style="font-size: 18px;color: {{ $bgBodyThemeSecond }};text-decoration: none;" target="_blank">{{ strtoupper($note->news->title) }}</a>
                        </h3>
                        <p class="news-summary">{!! $note->news->synthesis !!}</p>
                        <p style="font-size: 12px;margin-bottom: 20px;margin-top: 5px;color: {{ $bgBodyThemeSecond }};"> {{ $note->news->mean->name }} / {{ $note->news->source->name }}, {{ $note->news->author }}</p>
                    </div>
                @endforeach
            @endforeach
        </div>
        <!-- Pie de Página -->
        <div class="footer">
            <p>Si lo deseas tenemos otros newsletters para ti.<br><a href="#">Suscríbete aquí</a></p>
            <p>Síguenos en redes sociales</p>
            <p>
                <a href="#" style="margin-right: 10px;">Facebook</a> |
                <a href="#" style="margin-left: 10px; margin-right: 10px;">Twitter</a> |
                <a href="#" style="margin-left: 10px;">Instagram</a>
            </p>
        </div>
    </div>
</body>
</html>
