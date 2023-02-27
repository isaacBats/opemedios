<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter Opemedios</title>
    <style>
        .trend-green{
            background: green;
        }
        .trend-orange{
            background: orange;
        }
        .trend-red{
            background: red;
        }
    </style>
</head>
<body>
    <table
        style="background: linear-gradient(to left, rgb(255,255,255) 65%, #615d5c 20%); padding:50px 20px;max-width:700px;font-size:14px;margin:auto;height:auto;width:600px;font-family: Arial;">
        <thead style="display:block">
            <tr>
                <td style="font-weight:bold; margin:0 0 10px;display:block">
                    <a href="{{ $covers['primeras_planas'] }}" style="text-decoration: none;color: white;">
                        PRIMERAS PLANAS
                    </a>
                </td>
                <td style="font-weight:bold; margin:0 0 10px;display:block">
                    <a href="{{ $covers['portadas_financieras'] }}" style="text-decoration: none;color: white;">
                        PORTADAS FINANCIERAS
                    </a>
                </td>
                <td style="font-weight:bold; margin:0 0 10px;display:block">
                    <a href="{{ $covers['cartones'] }}" style="text-decoration: none;color: white;">
                        CARTONES
                    </a>
                </td>
                <td style="font-weight:bold; margin:0 0 10px;display:block">
                    <a href="{{ $covers['portadas_politicas'] }}" style="text-decoration: none;color: white;">
                        COLUMNAS POLITICAS
                    </a>
                </td>
                <td style="font-weight:bold; margin:0 0 10px;display:block">
                    <a href="{{ $covers['columnas_financieras'] }}" style="text-decoration: none;color: white;">
                        COLUMNAS FINANCIERAS
                    </a>
                </td>
            </tr>
            <tr style="float:right">
                <td>
                    <img src="{{ asset("images/{$newsletterSend->newsletter->banner}") }}" alt="{{ $newsletterSend->newsletter->name }}" width="65%" style="float:right;margin: -140px auto 14px 0;">
                    @php
                        $day = date('Y-m-d H:i:s');
                    @endphp
                    <p style="float:right;margin: 0 auto 20px auto;color:#646464;">{{ Illuminate\Support\Carbon::parse($day)->formatLocalized('%A %d de %B %Y') }}</p>
                </td>
            </tr>
        </thead>
        <tbody style="width=600px;max-width=700px;">
            @foreach ($newsletterSend->newsletter->company->themes as $theme)
                @if($newsletterSend->newsletter_theme_news->where('newsletter_theme_id', $theme->id)->count())
                    <tr>
                        <td style="margin:auto 34% 20px;width:70%;text-align:left;display:block">
                            <p style="margin:auto auto 10px;background:#bf3a2a;text-align:center;font-size:24px;color:#e5e5e5;display:flex;padding:10px;">{{ strtoupper($theme->name) }}</p>
                            @php
                                $countNotes = $newsletterSend
                                    ->newsletter_theme_news->where('newsletter_theme_id', $theme->id)
                                    ->count();
                            @endphp
                            <span>{{ "Noticias encontradas: {$countNotes}" }}</span>
                        </td>
                    </tr>
                @endif
                @foreach ($newsletterSend->newsletter_theme_news as $note)
                    @if($note->theme->id == $theme->id)
                        <tr style="margin:auto 28% 40px;background:white;display:block;padding:20px;width:68%">
                            <td>
                                <h3>
                                    <a
                                        style="text-decoration:none;color:#646464;cursor:pointer;"
                                        onmouseover="this.style.color='#0000EE'"
                                        onmouseout="this.style.color='#646464'"
                                        href="{{
                                                route(
                                                    'newsletter.shownew',
                                                    ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}">
                                        {{ $note->news->title }}
                                    </a>
                                </h3>
                                <p style="color:#9B9B9B">
                                    {!! $note->news->synthesis !!}
                                    <a
                                        href="{{
                                                route(
                                                    'newsletter.shownew',
                                                    ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}">
                                        >> Ir a nota
                                    </a>
                                </p>
                                <p style="color:#9B9B9B;font-size:18px;margin:20px 0;display:flex">{{ $note->news->mean->name }}, {{ $note->news->source->name ?? 'N/E' }}, {{ $note->news->author }}</p>
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>
