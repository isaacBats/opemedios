<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter Opemedios</title>
    <!--[if mso]> <noscript><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml></noscript>
    <![endif]-->
    <!--[if mso]>
    <style>table,tr,td,p,span,a{mso-line-height-rule:exactly !important;line-height:120% !important;mso-table-lspace:0 !important;mso-table-rspace:0 !important;}
    </style>
    <![endif]-->
    <style>a[x-apple-data-detectors]{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}u+#body a{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}#MessageViewBody a{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}:root{color-scheme:light dark;supported-color-schemes:light dark;}tr{vertical-align:middle;}p,a,li{mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;}p:first-child{margin-top:0!important;}p:last-child{margin-bottom:0!important;}a{text-decoration:underline;color:inherit;}@media only screen and (max-width:599px){.more-width-mobile{width:95%!important;}.full-width-mobile{width:unset!important;height:auto!important;display:block;}.mobile-padding{padding-left:10px!important;padding-right:10px!important;}.mobile-stack{display:block!important;width:100%!important;}}
    </style>
    @php
        $colorsConfig = unserialize($newsletterSend->newsletter->colors);

        $day = date('Y-m-d H:i:s');
        
        $bodyBgColor = isset($colorsConfig['body_bg']) ? $colorsConfig['body_bg'] : "#f2f2f2";
        
        $mainBgColor = isset($colorsConfig['main_bg']) ? $colorsConfig['main_bg'] : "#ffffff";
        
        $linksBgColor = isset($colorsConfig['links_bg']) ? $colorsConfig['links_bg'] : "#b7eae5";
        $linksButtonTextColor = isset($colorsConfig['links_button_text']) ? $colorsConfig['links_button_text'] : "#000000";

        $dateTextColor = isset($colorsConfig['date_text']) ? $colorsConfig['date_text'] : "#222222";

        $themeBgColor = isset($colorsConfig['theme_bg']) ? $colorsConfig['theme_bg'] : "blue";
        $themeTextColor = isset($colorsConfig['theme_text']) ? $colorsConfig['theme_text'] : "#ffffff";

        $newsBgColor = isset($colorsConfig['news_bg']) ? $colorsConfig['news_bg'] : "#ffffff";
        $newsBorderColor = isset($colorsConfig['news_border']) ? $colorsConfig['news_border'] : "#e2e2e2";
        $newsTitleColor = isset($colorsConfig['news_title']) ? $colorsConfig['news_title'] : "cyan";
        $newsTextColor = isset($colorsConfig['news_text']) ? $colorsConfig['news_text'] : "#9b9b9b";

        $newsButtonTextColor = isset($colorsConfig['news_button_text']) ? $colorsConfig['news_button_text'] : "blue";
    @endphp

</head>
<body style="background-color:{{ $bodyBgColor }};padding:0px 0px 0px 0px;margin:0px 0px 0px 0px;">
    <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" 
        style="background-color:{{ $mainBgColor }};max-width:600px;font-size:14px;margin:auto;height:auto;width:100%;font-family: Arial;">
            <tr>
                    <td style="font-weight:bold;padding: 30px 20px 20px 20px;background-color:{{ $linksBgColor }};vertical-align:middle;" class="full-width-mobile">
                        @foreach($linksAllowed as $key => $link)
                        <p>
                            <a href="{{ $link }}" style="text-decoration:none;color:{{ $linksButtonTextColor }};font-size:12px;">
                                {{ $covers->where('slug', $key)->first()->name }}
                            </a>
                        </p>
                        @endforeach
                    </td>
                    <td style="width:70%;text-align:right;padding: 0px 0px 0px 0px;vertical-align:middle;" class="full-width-mobile">
                        <img src="{{ asset("images/{$newsletterSend->newsletter->banner}") }}" alt="{{ $newsletterSend->newsletter->name }}" width="100%" style="width:100%;display:block;max-width:600px;">
                        <p style="padding:10px 20px 10px 20px;color:{{ $dateTextColor }};">{{ ucfirst(Illuminate\Support\Carbon::parse($day)->formatLocalized('%A %d de %B %Y')) }}</p>
                    </td>
            </tr>
            @foreach ($newsletterSend->newsletter->company->themes as $theme)
                @if($newsletterSend->newsletter_theme_news->where('newsletter_theme_id', $theme->id)->count())
                    <tr>
                        <td style="background-color:{{ $linksBgColor }};vertical-align:top;" class="full-width-mobile"></td>
                        <td style="width:70%;text-align:left;vertical-align:top;padding-right: 30px;" class="full-width-mobile">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="background-color:{{ $mainBgColor }};">
                                <tr>
                                    <td style="color:{{ $themeTextColor }};background-color:{{ $themeBgColor }};text-align:center;font-size:18px;padding:10px 20px 10px 20px;box-shadow:-2px 2px 4px rgba(0, 0, 0, .2);margin:0px 0px 0px 0px;">
                                        {{ strtoupper($theme->name) }} &nbsp;▲
                                    </td>
                                </tr>
                            </table>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:{{ $linksBgColor }};vertical-align:top;" class="full-width-mobile""></td>
                        <td style="width:70%;text-align:left;vertical-align:top;padding-right: 30px;" class="full-width-mobile">
                            <table align="left" role="presentation" border="0" cellpadding="0" cellspacing="0" style="background-color:{{ $mainBgColor }};">
                                <tr>
                                    @php
                                        $countNotes = $newsletterSend
                                            ->newsletter_theme_news->where('newsletter_theme_id', $theme->id)
                                            ->count();
                                    @endphp
                                    <td style="color:{{ $dateTextColor }};font-size:13px;padding:10px 10px 20px 10px;;margin:0px 0px 0px 0px;">
                                        {{ "Noticias encontradas: {$countNotes}" }}
                                    </td>
                                </tr>
                            </table>
                            
                        </td>
                    </tr>
                @endif
                @foreach ($newsletterSend->newsletter_theme_news as $note)
                    @if($note->theme->id == $theme->id)
                        <tr>
                            <td colspan="2">
                                <table align="left" role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="width:100%;">
                                    <tr>
                                        <td style="background-color:{{ $linksBgColor }};"></td>
                                        <td style="width:85%;padding:20px 20px 20px 20px;border-width:1px;border-style:solid;border-color:{{ $newsBorderColor }};box-shadow:-2px 2px 4px rgba(0, 0, 0, .2);background-color:{{ $newsBgColor }};" class="more-width-mobile">
                                            <h3 style="font-size:16px;margin-top:0;">
                                                <a
                                                    style="text-decoration:none;color:{{ $newsTitleColor }};"
                                                    href="{{
                                                route(
                                                    'newsletter.shownew',
                                                    ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}">
                                                     <span style="font-size:30px;color:{{ $newsTitleColor }};">&#10003;</span> {{ $note->news->title }}
                                                </a>
                                            </h3>
                                            <p style="color:{{ $newsTextColor }};font-size:14px;">
                                                {!! $note->news->synthesis !!}
                                                <a
                                                    href="{{
                                                route(
                                                    'newsletter.shownew',
                                                    ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}" style="color:{{ $newsButtonTextColor }};">
                                                    >> Ir a nota
                                                </a>
                                            </p>
                                            <p style="color:{{ $newsTextColor }};font-size:14px;margin:20px 0;display:flex">{{ $note->news->mean->name }}, {{ $note->news->source->name ?? 'N/E' }}, {{ $note->news->author }}</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <table align="left" role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="width:100%;">
                                    <tr>
                                        <td style="background-color:{{ $linksBgColor }};width:30%;"></td>
                                        <td style="width:70%;padding:10px 10px 10px 10px;">
                                            <p>&nbsp;</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                    @endif
                @endforeach
            @endforeach
    </table>
</body>
</html>
