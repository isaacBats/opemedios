<!DOCTYPE html>
<html lang="en" dir="ltr" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1 user-scalable=yes">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no, url=no">
    <meta name="x-apple-disable-message-reformatting">
    <title>{{ config('app.name', 'Opemedios Newsletter') }}</title>
    <!--[if mso]> <noscript><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml></noscript>
    <![endif]-->
    <!--[if mso]>
    <style>table,tr,td,p,span,a{mso-line-height-rule:exactly !important;line-height:120% !important;mso-table-lspace:0 !important;mso-table-rspace:0 !important;}
    </style>
    <![endif]-->
    <style>a[x-apple-data-detectors]{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}u+#body a{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}#MessageViewBody a{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}:root{color-scheme:light dark;supported-color-schemes:light dark;}tr{vertical-align:middle;}p,a,li{mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;}p:first-child{margin-top:0!important;}p:last-child{margin-bottom:0!important;}a{text-decoration:underline;color: inherit;}@media only screen and (max-width:599px){.full-width-mobile{width:100%!important;height:auto!important;}.mobile-padding{padding-left:10px!important;padding-right:10px!important;}.mobile-stack{display:block!important;width:100%!important;}}
    </style>
    @php
        $day = date('Y-m-d H:i:s');

        $colorsConfig = unserialize($newsletterSend->newsletter->colors);
        $mainBgColor = isset($colorsConfig['main_bg']) ? $colorsConfig['main_bg'] : "#f2f2f2";
        $linksButtonBorderColor = isset($colorsConfig['links_button_border']) ? $colorsConfig['links_button_border'] : "#615d5c";
        $linksButtonTextColor = isset($colorsConfig['links_button_text']) ? $colorsConfig['links_button_text'] : "#f2f2f2";
        $bannerBgColor = isset($colorsConfig['banner_bg']) ? $colorsConfig['banner_bg'] : "#444444";
        $dateTextColor = isset($colorsConfig['date_text']) ? $colorsConfig['date_text'] : "#ffffff";
        $themeBorderColor = isset($colorsConfig['theme_border']) ? $colorsConfig['theme_border'] : "#615d5c";
        $themeTextColor = isset($colorsConfig['theme_text']) ? $colorsConfig['theme_text'] : "#2b2a27";
        $newsBorderColor = isset($colorsConfig['news_border']) ? $colorsConfig['news_border'] : "#646464";
        $newsTitleColor = isset($colorsConfig['news_title']) ? $colorsConfig['news_title'] : "#646464";
        $newsTextColor = isset($colorsConfig['news_text']) ? $colorsConfig['news_text'] : "#9B9B9B";
        $newsButtonTextColor = isset($colorsConfig['news_button_text']) ? $colorsConfig['news_button_text'] : "#2b2a27";
        $footerBgColor = isset($colorsConfig['footer_bg']) ? $colorsConfig['footer_bg'] : "#444444";
        $footerTextColor = isset($colorsConfig['footer_text']) ? $colorsConfig['footer_text'] : "#999999";
    @endphp
</head>
<body class="body" style="background-color:{{ $mainBgColor }};padding:0px 0px 0px 0px;margin:0px 0px 0px 0px;">
    <div style="display:none;font-size:1px;background-color:{{ $mainBgColor }};line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;">
    </div>
    <span style="display:none!important;visibility:hidden;mso-hide:all;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;"> Newsletter!&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;</span>
    <div role="article" aria-roledescription="email" aria-label="newsletter" lang="en" dir="ltr" style="font-size:16px;font-size:1rem;font-size:max(16px,1rem);background-color:{{ $mainBgColor }};">

        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;width:100%;background-color:{{ $bannerBgColor }}">
            <tr>
                <td style="background-color:{{ $bannerBgColor }}">
                    <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:520px;width:100%;background-color:{{ $bannerBgColor }};">
                        <tr style="vertical-align:middle;" valign="middle">
                            <td>
                            <!--[if mso]>
                            <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="520" style="border-collapse:collapse;"><tr><td align="center">
                            <!--<![endif]-->
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;max-width:520px;margin:0 auto 0 auto;width:100%;background-color:{{ $bannerBgColor }};padding:15px 0px 0px 0px;">
                                    <tr>
                                        <td style="padding:20px 15px 5px 15px;text-align:center;">
                                            <p style="color:{{ $dateTextColor }};font-size: 13px;text-align: right;">
                                                {{ Illuminate\Support\Carbon::parse($day)->formatLocalized('%A %d de %B %Y') }}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center;">
                                            <img src="{{ asset("images/{$newsletterSend->newsletter->banner}") }}" alt="{{ $newsletterSend->newsletter->name ?? 'N/E' }}" style="display:block;margin:0 auto;width:100%;max-width:520px;">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!--[if mso]>
                        </td></tr></table>
                        <!--<![endif]-->
                    </table>
                </td>
            </tr>
        </table>

        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;width:100%;background-color:{{ $mainBgColor }}">
            <tr>
                <td style="background-color:{{ $mainBgColor }}">
                    <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:520px;width:100%;background-color:{{ $mainBgColor }};">
                        <tr style="vertical-align:middle;" valign="middle">
                            <td>
                            <!--[if mso]>
                            <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="520" style="border-collapse:collapse;"><tr><td align="center">
                            <!--<![endif]-->
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:0 auto 0 auto;background-color:{{ $mainBgColor }};" align="center">
                                    @foreach ($newsletterSend->newsletter->company->themes as $theme)
                                        @if($newsletterSend->newsletter_theme_news->where('newsletter_theme_id', $theme->id)->count())
                                            <tr>
                                                <td style="padding:30px 30px 0 30px;">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:400px;margin:0 auto 0 auto;width:100%;" align="center">
                                                        <tr>
                                                            <td style="border-width:1px 0px;border-style:solid; border-color:{{ $themeBorderColor }};text-align:center; padding:20px 0px 20px 0px;">
                                                                <p style="font-size:16px;color:{{ $themeTextColor }}; font-weight: bold;">
                                                                    {{ strtoupper($theme->name) }}
                                                                </p>
                                                                <p style="font-size:13px;color:{{ $themeTextColor }};">
                                                                    @php
                                                                      $countNotes = $newsletterSend
                                                                        ->newsletter_theme_news->where('newsletter_theme_id', $theme->id)
                                                                        ->count();
                                                                    @endphp
                                                                    {{ "Noticias encontradas: {$countNotes}" }}
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        @endif

                                        @foreach ($newsletterSend->newsletter_theme_news as $note)
                                            @if($note->theme->id == $theme->id)
                                                <tr>
                                                    <td style="padding:30px 30px 0px 30px;">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:400px;margin:0 auto 0 auto;width:100%;border-bottom:1px solid {{ $newsBorderColor }};">
                                                            <tr>
                                                                <td style="padding-bottom: 15px;color:{{ $newsTitleColor }};">
                                                                    <a style="text-decoration:none;color:{{ $newsTitleColor }};font-weight: bold;" href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}">
                                                                        {{ strtoupper($note->news->title) }}
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding-bottom:10px;">
                                                                    <p style="color:{{ $newsTextColor }};">
                                                                        {!! $note->news->synthesis !!}
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding-bottom:25px;">
                                                                    <p>
                                                                        <a href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}" style="text-decoration: none;color:{{ $newsButtonTextColor }};">
                                                                        — Ir a nota —</a>
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding-bottom: 30px;">
                                                                    <p style="color:{{ $newsTextColor }};font-size:14px;">
                                                                        {{ $note->news->mean->name }} / {{ $note->news->source->name }}, {{ $note->news->author }}
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach
                                    <tr>
                                        <td style="padding-top: 30px;">
                                            
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!--[if mso]>
                        </td></tr></table>
                        <!--<![endif]-->
                    </table>
                </td>
            </tr>
        </table>

        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;width:100%;background-color:{{ $footerBgColor }}">
            <tr>
                <td style="background-color:{{ $footerBgColor }}">
                    <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:520px;width:100%;background-color:{{ $footerBgColor }};">
                        <tr style="vertical-align:middle;" valign="middle">
                            <td>
                            <!--[if mso]>
                            <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="520" style="border-collapse:collapse;"><tr><td align="center">
                            <!--<![endif]-->
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center;padding:30px 15px 10px 15px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:520px;margin:0 auto 0 auto;width:100%;background-color:{{ $footerBgColor }};">
                                    <tr>
                                        <td>
                                            @foreach ($linksAllowed as $key => $link)
                                                <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;display:inline-block;background-color:{{ $footerBgColor }};">
                                                    <tr>
                                                        <td style="padding: 5px 10px 5px 10px;border-right: 1px solid {{ $linksButtonBorderColor }}; ">
                                                            <a href="{{ $link }}" style="font-weight:normal;color:{{ $linksButtonTextColor }};mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;font-size:14px;margin-top:0!important;margin-bottom:0!important;">
                                                                    {{ $covers->where('slug', $key)->first()->name }}
                                                                </a>
                                                        </td>
                     
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-bottom:10px;"></td>
                                                    </tr>
                                                </table>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:20px 20px 0px 20px;text-align:center;">
                                            <p style="color:{{ $footerTextColor }};font-size:13px;">Newsletter <a href="https://opemedios.com.mx" style="{{ $footerTextColor }};">Opemedios</a> {{ date('Y') }}</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!--[if mso]>
                        </td></tr></table>
                        <!--<![endif]-->
                    </table>
                </td>
            </tr>
        </table>

    </div>
</body>
</html>