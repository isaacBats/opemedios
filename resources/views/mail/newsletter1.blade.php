<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
</head>
<body style="background: #f8f8f8;">
<table style="width: 100%; border-collapse: collapse;">
    <tr>
        <td>
            <table style="width: 580px;border-collapse: collapse;" align="center">
                <tr>
                    <td style="margin:0;padding: 0;border: 0">
                        <img src="{{ asset("images/{$newsletterSend->newsletter->banner}") }}" alt="{{ $newsletterSend->newsletter->name }}" style="max-width: 100%;display: block;">
                    </td>
                </tr>
            </table>
            <table style="width: 580px;border-collapse: collapse;font-size: 12px;font-family: Arial, Helvetica, sans-serif;" align="center">
                <tr>
                    <td style="padding: 15px 30px;background: #000000;text-align: right; color: #fff">
                        @php
                            $day = date('Y-m-d H:i:s');
                        @endphp
                        {{ Illuminate\Support\Carbon::parse($day)->formatLocalized('%A %d de %B %Y') }}
                    </td>
                </tr>

               
                @foreach ($newsletterSend->newsletter_theme_news as $note) 
                    <tr>
                        <td style="padding: 15px 30px;background: white;border-bottom: solid 1px #e8e8e8">
                            <p style="margin: 0;padding: 0;font-size: 12px;font-family: Arial, Helvetica, sans-serif;line-height: 1.25;font-weight: normal;text-align: left !important;">
                                <span style="font-weight: bold">{{ $note->theme->name }}</span>
                                <br>
                                <a href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}" style="color: #015199;font-weight: bold;text-decoration:none" target="_blank">{{ $note->news->title }}</a>
                                <br>
                                {!! $note->news->synthesis !!}
                                <br>
                                <span style="color: #950a16;font-weight: bold;">{{ $note->news->mean->name }} | {{ $note->news->source->name }}, {{ $note->news->author }}</span>
                            </p>
                        </td>
                    </tr>
                @endforeach

            </table>
            <table style="width: 580px;border-collapse: collapse;font-size: 12px;font-family: Arial, Helvetica, sans-serif;" align="center">
                <tr>
                    <td style="padding: 30px 30px;">
                        <p style="margin: 0;padding: 0;text-align: center;">
                            <a href="" style="color: #015199;text-decoration: none;">PRIMERAS PLANAS</a>
                            <a href="" style="color: #015199;text-decoration: none;"> | PORTADAS NEGOCIOS</a>
                            <a href="" style="color: #015199;text-decoration: none;"> | CARTONES</a>
                            <a href="" style="color: #015199;text-decoration: none;"> | COLUMNAS NEGOCIOS</a>
                            <a href="" style="color: #015199;text-decoration: none;"> | COLUMNAS POLÍTICAS</a>
                            {{-- <a href="#" style="color: #015199;text-decoration: none;"> | PORTADA ESPECTACULOS</a> --}}
                         </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>