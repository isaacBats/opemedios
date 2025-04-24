<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
    <style>a[x-apple-data-detectors]{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}u+#body a{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}#MessageViewBody a{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}:root{color-scheme:light dark;supported-color-schemes:light dark;}tr{vertical-align:middle;}p,a,li{mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;}p:first-child{margin-top:0!important;}p:last-child{margin-bottom:0!important;}a{text-decoration:underline;color:inherit;}@media only screen and (max-width:599px){.full-width-mobile{width:100%!important;height:auto!important;}.mobile-padding{padding-left:10px!important;padding-right:10px!important;}.mobile-stack{display:block!important;width:100%!important;}}
    </style>
    @php
        $day = date('Y-m-d H:i:s');

        $colorsConfig = unserialize($newsletterSend->newsletter->colors);
        $bodyBgColor = isset($colorsConfig['body_bg']) ? $colorsConfig['body_bg'] : "#f8f8f8";
        $mainBgColor = isset($colorsConfig['main_bg']) ? $colorsConfig['main_bg'] : "#ffffff";
        $linksBgColor = isset($colorsConfig['links_bg']) ? $colorsConfig['links_bg'] : "#7dffd3";
        $linksButtonTextColor = isset($colorsConfig['links_button_text']) ? $colorsConfig['links_button_text'] : "#015199";
        $dateBgColor = isset($colorsConfig['date_bg']) ? $colorsConfig['date_bg'] : "#7dffd3";
        $dateTextColor = isset($colorsConfig['date_text']) ? $colorsConfig['date_text'] : "#015199";
        $themeTextColor = isset($colorsConfig['theme_text']) ? $colorsConfig['theme_text'] : "#000000";
        $newsBorderColor = isset($colorsConfig['news_border']) ? $colorsConfig['news_border'] : "#e6e1df";
        $newsTitleColor = isset($colorsConfig['news_title']) ? $colorsConfig['news_title'] : "#015199";
        $newsTextColor = isset($colorsConfig['news_text']) ? $colorsConfig['news_text'] : "#015199";
    @endphp
</head>
<body style="background: {{ $bodyBgColor }};padding: 0px 0px 0px 0px;margin:0px 0px 0px 0px;">
    <table border="0" cellpadding="0" cellspacing="0" bgcolor="{{ $mainBgColor }}" style="background-color: {{ $mainBgColor }}; width: 100%; max-width: 580px; margin: 0 auto 0 auto;" align="center">
        <tr>
            <td>
                <table cellspacing="0" style="max-width: 580px;width:100%;border-collapse: collapse;" align="center">
                    <tr>
                        <td style="margin:0 0 0 0;padding:0 0 0 0;border: 0;text-align: center;">
                            <img src="{{ asset("images/{$newsletterSend->newsletter->banner}") }}" alt="{{ $newsletterSend->newsletter->name ?? 'N/E' }}" style="max-width: 580px;width: 100%;display: block;">
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" style="max-width: 580px;width:100%;border-collapse: collapse;font-size: 13px;font-family: Arial, Helvetica, sans-serif;" align="center">
                    <tr>
                        <td bgcolor="{{ $dateBgColor }}" style="padding: 15px 30px;background-color:{{ $dateBgColor }};text-align: right; color:{{ $dateTextColor }};">
                            {{ Illuminate\Support\Carbon::parse($day)->formatLocalized('%A %d de %B %Y') }}
                        </td>
                    </tr>

                    @php
                        $notes = $newsletterSend->newsletter_theme_news;
                        $maxNotes = 15;
                    @endphp

                    @foreach ($notes->take($maxNotes) as $note)
                        <tr>
                            <td bgcolor="{{ $mainBgColor }}" style="padding:30px 30px 20px 30px;background: {{ $mainBgColor }};border-bottom: solid 1px {{ $newsBorderColor }}; margin: 0; font-size: 14px;font-family: Arial, Helvetica, sans-serif;line-height: 1.25;font-weight: normal;text-align: left !important;">
                                <table cellspacing="0">
                                    <tr>
                                        <td style="padding-bottom: 15px;">
                                            <p style="font-weight: bold;color:{{ $themeTextColor }};font-size:13px;line-height:20px;">{{ $note->theme->name ?? 'N/E' }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 15px;">
                                            <a href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}" style="color:{{ $newsTitleColor }};font-weight: bold;text-decoration:none; font-size:16px;" target="_blank">
                                                {{ $note->news->title }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 25px;">
                                            <p style="color:{{ $newsTextColor }}; font-size: 13px;">
                                                {!! $note->news->synthesis !!}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p style="color:{{ $newsTextColor }};font-weight: bold; font-size: 13px;">
                                                {{ $note->news->mean->name ?? 'N/E' }} | {{ $note->news->source->name ?? 'N/E' }}, {{ $note->news->author }}
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                                </p>
                            </td>
                        </tr>
                    @endforeach

                    @if ($notes->count() > $maxNotes)
                        <tr>
                            <td bgcolor="{{ $mainBgColor }}" style="padding: 20px 30px;text-align: center;">
                                <a href="{{ route('front.newsletter.see', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$newsletterSend->id}-{$newsletterSend->newsletter->company->id}")]) }}" style="background-color: {{ $linksBgColor }}; color: {{ $linksButtonTextColor }}; text-decoration: none; padding: 10px 20px; font-size: 14px; font-family: Arial, Helvetica, sans-serif; border-radius: 5px; display: inline-block;">
                                    Ver el newsletter completo
                                </a>
                            </td>
                        </tr>
                    @endif

                </table>
                <table cellspacing="0" bgcolor="{{ $linksBgColor }}" style="max-width: 580px;width:100%;border-collapse:collapse;background-color:{{ $linksBgColor }};" align="center">
                    <tr>
                        <td bgcolor="{{ $linksBgColor }}" style="padding: 30px 30px;background-color:{{ $linksBgColor }};">
                            <p style="margin: 0;padding: 0;text-align: center; line-height: 30px; font-size: 13px;font-family: Arial, Helvetica, sans-serif; color:{{ $linksButtonTextColor }};">
                                @foreach ($linksAllowed as $key => $link)
                                    <a href="{{ $link }}" style="color:{{ $linksButtonTextColor }};text-decoration: none;line-height: 13px;white-space: nowrap;">
                                        &#9615;&nbsp;{{ $covers->where('slug', $key)->first()->name }}&nbsp;&nbsp;
                                    </a>
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
