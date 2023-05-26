<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
</head>
<body style="background: #f8f8f8;">
@php
    $colorsConfig = unserialize($newsletterSend->newsletter->colors);
    $bgPrimary = isset($colorsConfig['bg_primary']) ? $colorsConfig['bg_primary'] : "#ffffff";
    $bgCovers = isset($colorsConfig['bg_covers']) ? $colorsConfig['bg_covers'] : "#7dffd3";
    $bgFontCovers = isset($colorsConfig['bg_font_covers']) ? $colorsConfig['bg_font_covers'] : "#015199";
    $bgTitleSecond = isset($colorsConfig['bg_title_second']) ? $colorsConfig['bg_title_second'] : "#015199";
    $bgBodyThemeSecond = isset($colorsConfig['bg_body_theme_second']) ? $colorsConfig['bg_body_theme_second'] : "#950a16";
@endphp
<table style="width: 100%; border-collapse: collapse;">
    <tr>
        <td>
            <table style="width: 580px;border-collapse: collapse;" align="center">
                <tr>
                    <td style="margin:0;padding: 0;border: 0">
                        <img src="{{ asset("images/{$newsletterSend->newsletter->banner}") }}" alt="{{ $newsletterSend->newsletter->name ?? 'N/E' }}" style="max-width: 100%;display: block;">
                    </td>
                </tr>
            </table>
            <table style="width: 580px;border-collapse: collapse;font-size: 12px;font-family: Arial, Helvetica, sans-serif;" align="center">
                <tr>
                    <td bgcolor="{{ $bgCovers }}" style="padding: 15px 30px;background-color:{{ $bgCovers }};text-align: right; color:{{ $bgFontCovers }};">
                        @php
                            $day = date('Y-m-d H:i:s');
                        @endphp
                        {{ Illuminate\Support\Carbon::parse($day)->formatLocalized('%A %d de %B %Y') }}
                    </td>
                </tr>


                @foreach ($newsletterSend->newsletter_theme_news as $note)
                    <tr>
                        <td bgcolor="{{ $bgPrimary }}" style="padding: 30px 30px;background: {{ $bgPrimary }};border-bottom: solid 1px #f2f2f2">
                            <p style="margin: 0;padding: 0;font-size: 12px;font-family: Arial, Helvetica, sans-serif;line-height: 1.25;font-weight: normal;text-align: left !important;">
                                <p style="font-weight: bold;">{{ $note->theme->name ?? 'N/E' }}</p>
                                <br>
                                <a href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}" style="color: {{ $bgTitleSecond }};font-weight: bold;text-decoration:none; font-size:18px;" target="_blank">{{ $note->news->title }}</a>
                                <p style="color: {{ $bgTitleSecond }};">
                                {!! $note->news->synthesis !!}
                                </p>
                                <br>
                                <p style="color: {{ $bgBodyThemeSecond }};font-weight: bold;">{{ $note->news->mean->name ?? 'N/E' }} | {{ $note->news->source->name ?? 'N/E' }}, {{ $note->news->author }}</p>
                            </p>
                        </td>
                    </tr>
                @endforeach

            </table>
            <table style="width: 580px;border-collapse: collapse;font-size: 12px;font-family: Arial, Helvetica, sans-serif;" align="center">
                <tr>
                    <td bgcolor="{{ $bgCovers }}" style="padding: 30px 30px;background-color:{{ $bgCovers }};">
                        <p style="margin: 0;padding: 0;text-align: center; line-height: 30px;">
                            @foreach ($linksAllowed as $key => $link)
                                <a href="{{ $link }}" style="color:{{ $bgFontCovers }};text-decoration: none;line-height: 12px;"> | {{ $covers->where('slug', $key)->first()->name }}</a>
                            @endforeach
                         </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
