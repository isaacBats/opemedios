<!DOCTYPE html>
<html lang="en" dir="ltr" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1 user-scalable=yes">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no, url=no">
    <meta name="x-apple-disable-message-reformatting">
    <title></title>
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
        $mainBgColor = isset($colorsConfig['main_bg']) ? $colorsConfig['main_bg'] : "#f4f4f4";
        $linksButtonTextColor = isset($colorsConfig['links_button_text']) ? $colorsConfig['links_button_text'] : "#222222";
        $dateBorderColor = isset($colorsConfig['date_border']) ? $colorsConfig['date_border'] : "#666666";
        $dateTextColor = isset($colorsConfig['date_text']) ? $colorsConfig['date_text'] : "#222222";
        $themeBorderColor = isset($colorsConfig['theme_border']) ? $colorsConfig['theme_border'] : "#666666";
        $themeTextColor = isset($colorsConfig['theme_text']) ? $colorsConfig['theme_text'] : "#000000";
        $newsTitleColor = isset($colorsConfig['news_title']) ? $colorsConfig['news_title'] : "#000000";
        $newsTextColor = isset($colorsConfig['news_text']) ? $colorsConfig['news_text'] : "#222222";
        $footerBorderColor = isset($colorsConfig['footer_border']) ? $colorsConfig['footer_border'] : "#666666";
        $footerTextColor = isset($colorsConfig['footer_text']) ? $colorsConfig['footer_text'] : "#666666";
    @endphp
</head>

<body style="background-color:{{ $mainBgColor }};padding:0px 0px 0px 0px;margin:0px 0px 0px 0px;">
    <div style="display:none;font-size:1px;color:{{ $mainBgColor }};line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;"></div> <!--preheader--><span style="display:none!important;visibility:hidden;mso-hide:all;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;">Newsletter {{ Illuminate\Support\Carbon::parse($day)->formatLocalized('%A %d de %B %Y') }} - Opemedios&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;</span>
    <div
    role="article" aria-roledescription="email" aria-label="Your Email" lang="en" dir="ltr" style="font-size:16px;font-size:1rem;font-size:max(16px,1rem);background-color:{{ $mainBgColor }};">
        <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:520px;width:100%;background-color:{{ $mainBgColor }};">
            <tr style="vertical-align:middle;" valign="middle">
                <td>
                    <!--[if mso]>
<table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="520" style="border-collapse:collapse;"><tr><td align="center">
<!--<![endif]-->
                </td>
            </tr>
            <tr>
                <td style="text-align:right;border-bottom: 2px solid {{ $dateBorderColor }};padding:5px 30px 0px 30px;">
                    <p style="color:{{ $dateTextColor }}; font-size: 13px;">
                        {{ Illuminate\Support\Carbon::parse($day)->formatLocalized('%A %d de %B %Y') }}
                    </p>
                </td>
            </tr>
            <tr style="vertical-align:middle;" valign="middle">
                <td align="center" style="padding-bottom: 10px;">
                    <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="520" style="border-collapse:collapse;max-width:600px;width:100%;background-color:{{ $mainBgColor }};">
                        <tr>
                            <td colspan="2" style="padding:15px 30px 5px 30px; text-align: center;">
                                <p style="text-transform: uppercase; font-weight: bold;color:{{ $themeTextColor }};">Primeras planas</p>
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
                        
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding-bottom:20px;">
                    <img src="{{ asset("images/{$newsletterSend->newsletter->banner}") }}" alt="{{ $newsletterSend->newsletter->name ?? 'N/E' }}" style="display:block;margin:0 auto;width:100%;max-width:520px;">
                </td>
            </tr>

            @foreach ($newsletterSend->newsletter->company->themes as $theme)
                @if($newsletterSend->newsletter_theme_news->where('newsletter_theme_id', $theme->id)->count())
                    <tr>
                        <td style="padding: 15px 30px 15px 30px; border-top: 2px solid {{ $themeBorderColor }};border-bottom: 2px solid {{ $themeBorderColor }};">
                            <p style="font-size:16px;mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;font-weight: bold;color:{{ $themeTextColor }};margin: 0px 0px 0px 0px;text-align:center;">
                                {{ strtoupper($theme->name) }}
                            </p>
                        </td>
                    </tr>
                @endif
                @foreach ($newsletterSend->newsletter_theme_news as $note)
                    @if($note->theme->id == $theme->id)
                        <tr>
                            <td style="padding: 20px 30px 5px 30px">
                                <p style="color:{{ $newsTextColor }};font-size:13px;mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;margin-bottom:0!important;">
                                    &bullet; {{ $note->news->mean->name }} / {{ $note->news->source->name }}, {{ $note->news->author }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 5px 30px 20px 30px;">
                                <p style="color:{{ $newsTitleColor }};font-size:15px;mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;">
                                    <a href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}" style="color:{{ $newsTitleColor }};font-size:15px;mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;text-decoration:none;font-weight:bold;">
                                        &#8227; {{ strtoupper($note->news->title) }}
                                    </a>
                                </p>
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endforeach

            <tr style="vertical-align:middle;" valign="middle">
                <td align="center" style="padding: 10px 30px 10px 30px;border-top: 2px solid {{ $footerBorderColor }};" colspan="2">
                    <p style="padding-top:20px;mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;font-size:13px;color:{{ $footerTextColor }};margin-top:0!important;margin-bottom:0!important;">Newsletter <a href="http://twitter.com/mail_gun" style="mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;text-decoration:underline;font-weight:bold;font-size:13px;color:{{ $footerTextColor }};">Opemedios</a> {{ date('Y') }}.</p>
                </td>
            </tr>
            <!--[if mso]>
</td></tr></table>
<!--<![endif]-->
        </table>
        </div>
</body>

</html>