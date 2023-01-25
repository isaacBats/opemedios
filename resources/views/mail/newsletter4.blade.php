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
        .body {
            background: linear-gradient(to left, white 65%, #b7eae5 20%);
            padding: 50px 20px;
            max-width: 600px;
            font-size: 14px;
            margin: auto;
            height: auto;
            width: 100%;
        }

        .opciones-herder {
            flex-direction: column;
            display: flex;
        }

        .opciones-herder td {
            margin: 0 0 10px;
        }

        thead {
            justify-content: space-between;
            display: flex;
        }

        .azul {
            margin: auto auto 20px;
            width: max-content;
            text-align: left;
            display: block;
        }

        .logo td img {
            max-width: 250px;
        }

        .flecha {
            background: linear-gradient(to bottom right, white 50%, transparent 50%);
            transform: rotate(45deg);
            margin-right: 5px;
            display: block;
            height: 15px;
            width: 15px;
        }

        [class*=tittle] {
            justify-content: space-between;
            margin: auto auto 10px;
            background: #023f82;
            align-items: center;
            text-align: center;
            font-size: 24px;
            color: white;
            display: flex;
            padding: 10px;
            width: 260px;
        }

        .informacion {
            box-shadow: -12px 1px 13px -8px black;
            margin: auto auto 60px;
            background: white;
            display: block;
            padding: 20px;
            width: 80%;
        }

        .status {
            border-radius: 50px;
            margin: 0 10px 0 0;
            display: block;
            height: 15px;
            width: 15px;
        }
        /* clase para cada estatus */
        .green {
            background: green;
        }

        .red {
            background: red;
        }

        .orange {
            background: orange;
        }

        h3 {
            color: #023f82;
        }

        h3 a {
            text-decoration: none;
        }

        .date {
            align-items: center;
            color: #8ad4c5;
            font-size: 18px;
            margin: 20px 0;
            display: flex;
        }

        .infotxt {
            color: #023f82;
        }
    </style>

    <table class="body">
        <thead>
            <tr class="opciones-herder">
                <td>
                    <a href="{{ $covers['primeras_planas'] }}" style="text-decoration: none;">
                        PRIMERAS PLANAS
                    </a>
                </td>
                <td>
                    <a href="{{ $covers['portadas_financieras'] }}" style="text-decoration: none;">
                        PORTADAS FINANCIERAS
                    </a>
                </td>
                <td>
                    <a href="{{ $covers['cartones'] }}" style="text-decoration: none;">
                        CARTONES
                    </a>
                </td>
                <td>
                    <a href="{{ $covers['portadas_politicas'] }}" style="text-decoration: none;">
                        COLUMNAS POLITICAS
                    </a>
                </td>
                <td>
                    <a href="{{ $covers['columnas_financieras'] }}" style="text-decoration: none;">
                        COLUMNAS FINANCIERAS
                    </a>
                </td>
            </tr>
            <tr class="logo">
                <td>
                    <img src="{{ asset("images/{$newsletterSend->newsletter->banner}") }}" alt="{{ $newsletterSend->newsletter->name }}">
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
                        <td class="azul">
                            <p class="tittle-1">{{ strtoupper($theme->name) }} <span class="flecha"></span></p>
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
                        <tr class="informacion">
                            <td>
                                
                                <h3><a href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}">{{ $note->news->title }}</a></h3>
                                <p class="date"><span class="status {{ $note->trend == 1 ? 'green' : ($note->trend == 2? 'red' : 'orange') }}"></span>{{ $note->news->mean->name }}, {{ $note->news->source->name ?? 'N/E' }}, {{ $note->news->author }}</p>
                                <p class="infotxt">{!! Illuminate\Support\STR::limit($note->news->synthesis, 200) !!}</p>
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endforeach
        </tbody>

    </table>


</body>

</html>