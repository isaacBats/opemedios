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

        $bodyBgColor = isset($colorsConfig['body_bg']) ? $colorsConfig['body_bg'] : "#444444";

        $mainBgColor = isset($colorsConfig['main_bg']) ? $colorsConfig['main_bg'] : "#e2e2e2";

        $linksBgColor = isset($colorsConfig['links_bg']) ? $colorsConfig['links_bg'] : "#333333";
        $linksButtonBgColor = isset($colorsConfig['links_button_bg']) ? $colorsConfig['links_button_bg'] : "#444444";
        $linksButtonTextColor = isset($colorsConfig['links_button_text']) ? $colorsConfig['links_button_text'] : "#bbbbbb";

        $dateTextColor = isset($colorsConfig['date_text']) ? $colorsConfig['date_text'] : "black";

        $themeBgColor = isset($colorsConfig['theme_bg']) ? $colorsConfig['theme_bg'] : "#333333";
        $themeTextColor = isset($colorsConfig['theme_text']) ? $colorsConfig['theme_text'] : "#ffffff";

        $newsBgColor = isset($colorsConfig['news_bg']) ? $colorsConfig['news_bg'] : "#f9f9f9";
        $newsBorderColor = isset($colorsConfig['news_border']) ? $colorsConfig['news_border'] : "gray";
        $newsTitleColor = isset($colorsConfig['news_title']) ? $colorsConfig['news_title'] : "#222222";
        $newsTextColor = isset($colorsConfig['news_text']) ? $colorsConfig['news_text'] : "#333333";

        $newsButtonBgColor = isset($colorsConfig['news_button_bg']) ? $colorsConfig['news_button_bg'] : "#444444";
        $newsButtonTextColor = isset($colorsConfig['news_button_text']) ? $colorsConfig['news_button_text'] : "#ffffff";

        $footerTextColor = isset($colorsConfig['footer_text']) ? $colorsConfig['footer_text'] : "gray";
    @endphp
</head>
<body class="body" style="background-color:{{ $bodyBgColor }};padding:0px 0px 0px 0px;margin:0px 0px 0px 0px;"><div style="display:none;font-size:1px;color:{{ $bodyBgColor }};line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;"></div> <span style="display:none!important;visibility:hidden;mso-hide:all;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;"> Newsletter!&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;</span><div role="article" aria-roledescription="email" aria-label="newsletter" lang="en" dir="ltr" style="font-size:16px;font-size:1rem;font-size:max(16px,1rem);background-color:{{ $bodyBgColor }};">
    <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:540px;width:100%;background-color:{{ $mainBgColor }};">
        <tr style="vertical-align:middle;" valign="middle">
            <td>
            <!--[if mso]>
            <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="540" style="border-collapse:collapse;"><tr><td align="center">
            <!--<![endif]-->
            </td>
        </tr>
        <tr style="vertical-align:middle;" valign="middle">
            <td align="center" style="padding:0px 0px 0px 0px;">

                <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="10" width="540" style="max-width:540px;width:100%;background-color:{{ $linksBgColor }};text-align:center;">
                    @foreach ($linksAllowed as $key => $link)
                        @if ($loop->odd)
                            <tr>
                                <td style="padding:5px 5px 5px 5px;background-color:{{ $linksButtonBgColor }};width:50%;">
                                    <a href="{{ $link }}" style="font-weight:normal;color:{{ $linksButtonTextColor }};mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;font-size:14px;margin-top:0!important;margin-bottom:0!important;text-decoration:none;">
                                        {{ $covers->where('slug', $key)->first()->name }}
                                    </a>
                                </td>
                        @else
                                <td style="padding:5px 5px 5px 5px;background-color:{{ $linksButtonBgColor }};width:50%;">
                                    <a href="{{ $link }}" style="font-weight:normal;color:{{ $linksButtonTextColor }};mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;font-size:14px;margin-top:0!important;margin-bottom:0!important;text-decoration:none;">
                                        {{ $covers->where('slug', $key)->first()->name }}
                                    </a>
                                </td>
                            </tr>
                        @endif
                        @if ($loop->last && $loop->odd)
                                <td style="padding:5px 5px 5px 5px;width:50%;">
                                </td> 
                            </tr>
                        @endif
                    @endforeach
                </table>

                <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="540" style="border-collapse:collapse;max-width:540px;width:100%;background-color:{{ $mainBgColor }};">
                    <tr>
                        <td valign="top">
                            <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="10" style="border-collapse:collapse;">
                                <tr>
                                    <td style="width:10px;padding-top:60px;background-color:{{ $linksBgColor }};"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                        <td style="text-align: center;">
                            <img src="{{ asset("images/{$newsletterSend->newsletter->banner}") }}" alt="{{ $newsletterSend->newsletter->name ?? 'N/E' }}" style="display:block;margin:0 auto;width:100%;max-width:560px;">
                        </td>
                        <td valign="top">
                            <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="10" style="border-collapse:collapse;">
                                <tr>
                                    <td style="width:10px;padding-top:60px;background-color:{{ $linksBgColor }};"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="540" style="border-collapse:collapse;max-width:540px;width:100%;background-color:{{ $mainBgColor }};">
                    <tr>
                        <td style="text-align:center;padding: 15px 20px 0px 0px;text-align: right;">
                            <p style="color:{{ $dateTextColor }};font-size:13px;mso-line-height-rule:exactly;line-height:23px;font-family:serif;margin-top:0!important;margin-bottom:0!important;">
                                {{ Illuminate\Support\Carbon::parse($day)->formatLocalized('%A %d de %B %Y') }}
                            </p>
                        </td>
                    </tr>
                </table>

                @foreach ($newsletterSend->newsletter->company->themes as $theme)
                    @if($newsletterSend->newsletter_theme_news->where('newsletter_theme_id', $theme->id)->count())
                        <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="540" style="border-collapse:collapse;max-width:540px;width:100%;background-color:{{ $mainBgColor }};">
                            <tr>
                                <td style="padding-top:15px;"></td>
                            </tr>
                            <tr>
                                <td style="text-align:center;padding: 15px 0px 15px 0px;background-color:{{ $themeBgColor }};">
                                    <p style="font-size:16px;margin-bottom:5px;color:{{ $themeTextColor }};mso-line-height-rule:exactly;line-height:26px;font-family:Arial,sans-serif;margin-top:0!important;font-weight:bold;">
                                        {{ strtoupper($theme->name) }}
                                    </p>
                                    <p style="font-size:13px;margin:0px 0px 0px 0px;color:{{ $themeTextColor }};mso-line-height-rule:exactly;line-height:23px;font-family:Arial,sans-serif;margin-top:0!important;margin-bottom:0!important;">
                                        @php
                                          $countNotes = $newsletterSend
                                            ->newsletter_theme_news->where('newsletter_theme_id', $theme->id)
                                            ->count();
                                        @endphp
                                        {{ "Noticias encontradas: {$countNotes}" }}
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top:10px;"></td>
                            </tr>
                        </table>
                    @endif

                    @foreach ($newsletterSend->newsletter_theme_news as $note)
                        @if($note->theme->id == $theme->id)
                            <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="540" style="border-collapse:collapse;max-width:540px;width:100%;background-color:{{ $mainBgColor }};">
                                <tr style="vertical-align:middle;" valign="middle">
                                    <td align="center" style="padding:10px 15px 10px 15px;" class="content">
                                        <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="510" style="border-collapse:collapse;max-width:510px;width:100%;background-color:{{ $newsBgColor }};">
                                            <tr style="vertical-align:middle;" valign="middle">
                                                <td class="content" style="padding:15px 15px 15px 15px;">
                                                    <p style="color:{{ $newsTitleColor }};font-size:16px;mso-line-height-rule:exactly;line-height:26px;font-family:Arial,sans-serif;margin-top:0!important;font-weight:bold;">
                                                        <a href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}" style="color:{{ $newsTitleColor }};font-size:16px;mso-line-height-rule:exactly;line-height:26px;font-family:Arial,sans-serif;margin-top:0!important;font-weight:bold;text-decoration:none;">
                                                            {{ strtoupper($note->news->title) }}
                                                        </a>
                                                    </p>
                                                    <p style="color:{{ $newsTextColor }};font-size:15px;mso-line-height-rule:exactly;line-height:25px;font-family:Arial,sans-serif;">
                                                        {!! $note->news->synthesis !!}
                                                    </p>
                                                    <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="510" style="border-collapse:collapse;max-width:510px;width:100%;background-color:{{ $newsBgColor }};">
                                                        <tr>
                                                            <td colspan="3" style="border-top:1px solid {{ $newsBorderColor }};padding-bottom:15px;"></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border-right:1px solid {{ $newsBorderColor }};padding-right:10px;">
                                                                <p style="color:{{ $newsTextColor }};font-size:13px;mso-line-height-rule:exactly;line-height:23px;font-family:Arial,sans-serif;margin-bottom:0!important;">
                                                                    &#8226; {{ $note->news->mean->name }}<br>
                                                                    &#8226; {{ $note->news->source->name }}<br>
                                                                    &#8226; {{ $note->news->author }}
                                                                </p>
                                                            </td>
                                                            <td style="width:10px;">
                                                            </td>
                                                            <td style="width: 100px;">
                                                                <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="100" style="border-collapse:collapse;max-width:100px;width:100%;background-color:{{ $newsButtonBgColor }};">
                                                                    <tr>
                                                                        <td style="text-align:center;padding:10px 5px 10px 5px;">
                                                                            <p style="color:{{ $newsTextColor }};font-size:16px;mso-line-height-rule:exactly;line-height:26px;font-family:Arial,sans-serif;">
                                                                                <a href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}" style="font-size:16px;mso-line-height-rule:exactly;line-height:26px;font-family:Arial,sans-serif;text-decoration:underline;color:{{ $newsButtonTextColor }};text-decoration:none;">
                                                                                    Ver nota
                                                                                </a>
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        @endif
                    @endforeach
                @endforeach

                <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="540" style="border-collapse:collapse;max-width:540px;width:100%;">
                    <tr style="vertical-align:middle;" valign="middle">
                        <td align="center" style="padding-top:40px;">
                            <p style="mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;font-size:14px;color:{{ $footerTextColor }};margin-top:0!important;margin-bottom:0!important;">
                                Newsletter <a href="https://opemedios.com.mx" style="mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;text-decoration:underline;font-size:14px;color:{{ $footerTextColor }}">Opemedios</a> {{ date('Y') }}.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    <!--[if mso]>
    </td></tr></table>
    <!--<![endif]-->
    </table>
</div></body>
</html>