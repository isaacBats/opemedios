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
    <style>a[x-apple-data-detectors]{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}u+#body a{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}#MessageViewBody a{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}:root{color-scheme:light dark;supported-color-schemes:light dark;}tr{vertical-align:middle;}p,a,li{mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;}p:first-child{margin-top:0!important;}p:last-child{margin-bottom:0!important;}a{text-decoration:underline;color:inherit;}@media only screen and (max-width:599px){.full-width-mobile{width:100%!important;height:auto!important;}.mobile-padding{padding-left:10px!important;padding-right:10px!important;}.mobile-stack{display:block!important;width:100%!important;}}
    </style>
    @php
        $day = date('Y-m-d H:i:s');

        $colorsConfig = unserialize($newsletterSend->newsletter->colors);

        $bodyBgColor = isset($colorsConfig['body_bg']) ? $colorsConfig['body_bg'] : "#f4f4f4";

        $mainBgColor = isset($colorsConfig['main_bg']) ? $colorsConfig['main_bg'] : "#dddddd";

        $linksButtonTextColor = isset($colorsConfig['links_button_text']) ? $colorsConfig['links_button_text'] : "#c2c2c2";

        $dateBgColor = isset($colorsConfig['date_bg']) ? $colorsConfig['date_bg'] : "#444444";
        $dateTextColor = isset($colorsConfig['date_text']) ? $colorsConfig['date_text'] : "#f2f2f2";

        $themeBgColor = isset($colorsConfig['theme_bg']) ? $colorsConfig['theme_bg'] : "#552222";
        $themeTextColor = isset($colorsConfig['theme_text']) ? $colorsConfig['theme_text'] : "#ffffff";

        $newsBorderColor = isset($colorsConfig['news_border']) ? $colorsConfig['news_border'] : "#666666";
        $newsTitleColor = isset($colorsConfig['news_title']) ? $colorsConfig['news_title'] : "#000000";
        $newsTextColor = isset($colorsConfig['news_text']) ? $colorsConfig['news_text'] : "#000000";

        $newsButtonTextColor = isset($colorsConfig['news_button_text']) ? $colorsConfig['news_button_text'] : "#0000ff";

        $footerBgColor = isset($colorsConfig['footer_bg']) ? $colorsConfig['footer_bg'] : "#444444";
        $footerBorderColor = isset($colorsConfig['footer_border']) ? $colorsConfig['footer_border'] : "#777777";
        $footerTextColor = isset($colorsConfig['footer_text']) ? $colorsConfig['footer_text'] : "#666666";
    @endphp
</head>

<body style="background-color:{{ $bodyBgColor }};padding:0px 0px 0px 0px;margin:0px 0px 0px 0px;">
    <div style="display:none;font-size:1px;color:{{ $bodyBgColor }};line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;"></div> <!--preheader--><span style="display:none!important;visibility:hidden;mso-hide:all;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;">Newsletter {{ Illuminate\Support\Carbon::parse($day)->formatLocalized('%A %d de %B %Y') }} - Opemedios&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;</span>
    <div
    role="article" aria-roledescription="email" aria-label="Your Email" lang="en" dir="ltr" style="font-size:16px;font-size:1rem;font-size:max(16px,1rem);background-color:{{ $bodyBgColor }};">
        <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:520px;width:100%;background-color:{{ $mainBgColor }};">
            <tr style="vertical-align:middle;" valign="middle">
                <td>
                    <!--[if mso]>
<table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="520" style="border-collapse:collapse;"><tr><td align="center">
<!--<![endif]-->
                </td>
            </tr>
            <tr>
                <td style="text-align:center;">
                    <img src="{{ asset("images/{$newsletterSend->newsletter->banner}") }}" alt="{{ $newsletterSend->newsletter->name ?? 'N/E' }}" style="width: 100%; display: block;">
                    <table border="0" cellpadding="0" cellspacing="0" align="right" style="margin: 0 0 0 auto; width: 100%;">
                        <tr>
                            <td style="background-color:{{ $dateBgColor }}; padding: 5px 15px; overflow: hidden;text-align: right;">
                                <p style="color:{{ $dateTextColor }}; font-size: 13px;">
                                    {{ Illuminate\Support\Carbon::parse($day)->formatLocalized('%A %d de %B %Y') }}
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            @foreach ($newsletterSend->newsletter->company->themes as $theme)
                @if($newsletterSend->newsletter_theme_news->where('newsletter_theme_id', $theme->id)->count())
                    <tr>
                        <td style="padding: 15px 15px 15px 15px; background-color:{{ $themeBgColor }}">
                            <p style="font-size:16px;mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;font-weight: bold;color:{{ $themeTextColor }};margin: 0px 0px 0px 0px;text-align:center;">
                                {{ strtoupper($theme->name) }}
                            </p>
                        </td>
                    </tr>
                @endif
                <tr style="vertical-align:middle;" valign="middle">
                    <td align="center">
                        <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="520" style="border-collapse:collapse;max-width:600px;width:100%;background-color:{{ $mainBgColor }};">
                            <tr style="vertical-align:middle;" valign="middle">
                                <td align="center" style="padding:0px 15px 15px 15px;" class="content">
                                    <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="520" style="border-collapse:collapse;max-width:520px;width:100%;">
                                        <tr style="vertical-align:middle;" valign="middle">
                                            <td class="content">
                                                <p style="font-size:15px;line-height: 15px">&nbsp;</p>

                                                @foreach ($newsletterSend->newsletter_theme_news as $note)
                                                    @if($note->theme->id == $theme->id)
                                                        <table border="0" cellpadding="0" cellspacing="0" style="border-left: 5px solid {{ $newsBorderColor }}; padding: 0 20px 0 20px;">
                                                            <tr>
                                                                <td>
                                                                    <p style="color:{{ $newsTextColor }};font-size:12px;mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;margin-bottom:0!important;">
                                                                        &#x274F; {{ $note->news->mean->name }} / {{ $note->news->source->name }}, {{ $note->news->author }}
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding: 10px 0 10px 0;">
                                                                    <p style="color:{{ $newsTitleColor }};font-size:15px;mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;">
                                                                        <a href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}" style="color:{{ $newsTitleColor }};font-size:15px;mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;text-decoration:none;font-weight:bold">
                                                                            {{ strtoupper($note->news->title) }}
                                                                        </a>
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    {{--<p style="color:{{ $newsTextColor }};font-size:14px;mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;">
                                                                        {!! $note->news->synthesis !!}
                                                                    </p>--}}
                                                                    <table style="width: 100%;">
                                                                        <tr>
                                                                            <td>
                                                                                <p style="color:{{ $newsButtonTextColor }};font-size:13px;mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;">
                                                                                    <a href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}" style="font-size:13px;mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;text-decoration:none;color:{{ $newsButtonTextColor }};">&#91; Ver nota &#93;</a>
                                                                                </p>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <p style="font-size:10px;line-height: 10px">&nbsp;</p>
                                                    @endif
                                                @endforeach

                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            @endforeach
            <tr style="vertical-align:middle;" valign="middle">
                <td align="center">
                    <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="520" style="border-collapse:collapse;max-width:600px;width:100%;background-color:{{ $footerBgColor }};">
                        <tr>
                            <td colspan="2" style="padding:20px 30px 10px 30px; text-align: center;">
                                <p style="text-transform: uppercase; font-weight: bold;border-bottom: 1px solid {{ $footerBorderColor }};padding-bottom:15px;color:{{ $linksButtonTextColor }};">Primeras planas</p>
                            </td>
                        </tr>

                        @foreach ($linksAllowed as $key => $link)
                            @if ($loop->odd)
                                <tr style="vertical-align:middle;" valign="middle">
                                    <td align="center" style="padding:7px 20px 7px 20px;">
                                        <p style="mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;font-size:14px;color:{{ $linksButtonTextColor }};margin-top:0!important;margin-bottom:0!important;">
                                            <a href="{{ $link }}" style="mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;text-decoration:none;font-size:14px;color:{{ $linksButtonTextColor }};">
                                                {{ $covers->where('slug', $key)->first()->name }}
                                            </a>
                                        </p>
                                    </td>
                            @else
                                    <td align="center" style="padding:7px 20px 7px 20px;">
                                        <p style="mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;font-size:14px;color:{{ $linksButtonTextColor }};margin-top:0!important;margin-bottom:0!important;">
                                            <a href="{{ $link }}" style="mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;text-decoration:none;font-size:14px;color:{{ $linksButtonTextColor }};">
                                                {{ $covers->where('slug', $key)->first()->name }}
                                            </a>
                                        </p>
                                    </td>
                                </tr>
                            @endif
                            @if ($loop->last && $loop->odd)
                                    <td align="center" style="padding:7px 20px 7px 20px;">
                                        <p>&nbsp;</p>
                                    </td>
                                </tr>
                            @endif
                        @endforeach


                        <tr style="vertical-align:middle;" valign="middle">
                            <td align="center" style="padding: 10px 30px 10px 30px;" colspan="2">
                                <p style="border-top: 1px solid {{ $footerBorderColor }};padding-top:20px;mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;font-size:13px;color:{{ $footerTextColor }};margin-top:0!important;margin-bottom:0!important;">Newsletter <a href="http://twitter.com/mail_gun" style="mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;text-decoration:underline;font-weight:bold;font-size:13px;color:{{ $footerTextColor }};">Opemedios</a> {{ date('Y') }}.</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!--[if mso]>
</td></tr></table>
<!--<![endif]-->
        </table>
        </div>
</body>

</html>