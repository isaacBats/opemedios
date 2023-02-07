<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
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

    <table 
        style="padding:50px 20px;font-size:14px;margin:auto;height:auto;width:100%; font-family: Arial;">
        <thead style="display:block">
            <tr>
                <td style="margin:0 0 10px;display:block">
                    <a href="{{ $covers['primeras_planas'] }}" style="text-decoration: none;">
                        PRIMERAS PLANAS
                    </a>
                </td>
                <td style="margin:0 0 10px;display:block">
                    <a href="{{ $covers['portadas_financieras'] }}" style="text-decoration: none;">
                        PORTADAS FINANCIERAS
                    </a>
                </td>
                <td style="margin:0 0 10px;display:block">
                    <a href="{{ $covers['cartones'] }}" style="text-decoration: none;">
                        CARTONES
                    </a>
                </td>
                <td style="margin:0 0 10px;display:block">
                    <a href="{{ $covers['portadas_politicas'] }}" style="text-decoration: none;">
                        COLUMNAS POLITICAS
                    </a>
                </td>
                <td style="margin:0 0 10px;display:block">
                    <a href="{{ $covers['columnas_financieras'] }}" style="text-decoration: none;">
                        COLUMNAS FINANCIERAS
                    </a>
                </td>
            </tr>
            <tr style="float:right">
                <td>
                    <img src="{{ asset("images/{$newsletterSend->newsletter->banner}") }}" alt="{{ $newsletterSend->newsletter->name }}" width="250" style="float:right">
                    @php
                        $day = date('Y-m-d H:i:s');
                    @endphp
                    <p>{{ Illuminate\Support\Carbon::parse($day)->formatLocalized('%A %d de %B %Y') }}</p>
                </td>
            </tr>
        </thead>
        <tbody>
            @foreach ($newsletterSend->newsletter->company->themes as $theme)
                @if($newsletterSend->newsletter_theme_news->where('newsletter_theme_id', $theme->id)->count())
                    <tr>
                        <td style="width:max-content;text-align:left;display:block">
                            <p style="margin:auto auto 10px;background:#023f82;text-align:center;font-size:24px;color:white;display:flex;padding:10px;width:260px">{{ strtoupper($theme->name) }}</p>
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
                        <tr style="background:#ffffff;display:block;padding:20px;width:80%">
                            <td>                                
                                <h3 style="color:#023f82"><a style="text-decoration:none" href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}">{{ $note->news->title }}</a></h3>
                                <p style="color:#023f82">{!! $note->news->synthesis !!}</p>
                                <p style="color:#8ad4c5;font-size:18px;margin:20px 0;display:flex"><span class="trend-{{ $note->trend == 1 ? 'green' : ($note->trend == 2? 'red' : 'orange') }}" style="border-radius:50px;margin: auto 10px auto 0;display:block;height:15px;width:15px;"></span>{{ $note->news->mean->name }}, {{ $note->news->source->name ?? 'N/E' }}, {{ $note->news->author }}</p>
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>