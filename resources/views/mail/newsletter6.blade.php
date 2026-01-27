<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title>Amp-accordion</title>
    <style>a[x-apple-data-detectors]{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}u+#body a{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}#MessageViewBody a{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}:root{color-scheme:light dark;supported-color-schemes:light dark;}tr{vertical-align:middle;}p,a,li{mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;}p:first-child{margin-top:0!important;}p:last-child{margin-bottom:0!important;}a{text-decoration:underline;color:inherit;}@media only screen and (max-width:599px){.full-width-mobile{width:100%!important;height:auto!important;}.mobile-padding{padding-left:10px!important;padding-right:10px!important;}.mobile-stack{display:block!important;width:100%!important;}}
    </style>
    @php
        $day = date('Y-m-d H:i:s');

        $colorsConfig = unserialize($newsletterSend->newsletter->colors);
        $mainBgColor = isset($colorsConfig['main_bg']) ? $colorsConfig['main_bg'] : "#F7F7F7";
        $bannerBgColor = isset($colorsConfig['banner_bg']) ? $colorsConfig['banner_bg'] : "#ffffff";
        $dateTextColor = isset($colorsConfig['date_text']) ? $colorsConfig['date_text'] : "#666666";
        $themeBgColor = isset($colorsConfig['theme_bg']) ? $colorsConfig['theme_bg'] : "#273095";
        $themeTextColor = isset($colorsConfig['theme_text']) ? $colorsConfig['theme_text'] : "#efefef";
        $newsTitleColor = isset($colorsConfig['news_title']) ? $colorsConfig['news_title'] : "#273095";
        $newsTextColor = isset($colorsConfig['news_text']) ? $colorsConfig['news_text'] : "#333333";
        $footerBgColor = isset($colorsConfig['footer_bg']) ? $colorsConfig['footer_bg'] : "#cccccc";
        $footerTextColor = isset($colorsConfig['footer_text']) ? $colorsConfig['footer_text'] : "#666666";
    @endphp
</head>
<body style="font-family:georgia, times, 'times new roman', serif; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px;background-color:{{ $mainBgColor }};">
    <table cellspacing="0" cellpadding="0" style="border-collapse:collapse;width:100%;max-width:600px;margin:0 auto 0 auto;background-color:{{ $mainBgColor }};">
        <tr>
            <td align="center" style="line-height:13px;font-size:11px;color:#999999; padding: 10px 20px;">
                <p style="mso-line-height-rule:exactly;font-family:georgia, times, 'times new roman', serif;line-height:13px;color:#999999;font-size:11px">
                    Si no puedes ver la información. <a href="{{ route('front.newsletter.see', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$newsletterSend->id}-{$newsletterSend->newsletter->company->id}")]) }}" target="_blank" style="text-decoration:none;mso-line-height-rule:exactly;color:#3D5CA3;font-size:11px">Pulsa aquí</a>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <table cellspacing="0" cellpadding="0" align="center" style="border-collapse:collapse;table-layout:fixed !important;width:100%;background: {{ $bannerBgColor }};">
                    <tr style="border-collapse:collapse">
                        <td align="left" style="width: 55%;padding: 20px 0px 20px 0px;">
                            <img src="{{ asset("images/{$newsletterSend->newsletter->banner}") }}" alt="{{ $newsletterSend->newsletter->name ?? 'N/E' }}" style="width: 100%; display:block;text-decoration:none;-ms-interpolation-mode:bicubic">
                        </td>
                        <td align="right" style="width: 45%;padding: 20px 15px 20px 10px;" valign="top">
                            <p style="mso-line-height-rule:exactly;font-family:georgia, times, 'times new roman', serif;line-height:21px;color:{{ $dateTextColor }};font-size:14px">
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
                    <td style="padding: 20px 20px 20px 20px;">
                        <table style="width:100%;">
                            <tr>
                                @php
                                    $countNotes = $newsletterSend
                                        ->newsletter_theme_news->where('newsletter_theme_id', $theme->id)
                                        ->count();
                                @endphp
                                <td align="left" bgcolor="{{ $themeBgColor }}" style="padding: 10px 10px 10px 10px;background-color:{{ $themeBgColor }};">
                                    <p style="mso-line-height-rule:exactly;font-family:georgia, times, 'times new roman', serif;line-height:27px;color:{{ $themeTextColor }};font-size:18px">
                                        <strong>&nbsp;{{ strtoupper($theme->name) }}</strong><br>&nbsp;|&nbsp;<span style="font-size:14px">Noticias encontradas : <strong>{{ $countNotes }}</strong></span><strong></strong>
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
                        <td align="left" valign="middle" style="padding:25px 20px 30px 20px;">
                            <p style="line-height:22px;mso-line-height-rule:exactly;font-family:georgia, times, 'times new roman', serif;font-size:18px;font-style:normal;font-weight:normal;color:{{ $newsTitleColor }}"><strong><a target="_blank" style="text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:{{ $newsTitleColor }};font-size:18px;line-height:22px;font-family:georgia, times, 'times new roman', serif" href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}">
                                ‘{{ strtoupper($note->news->title) }}
                                </a></strong>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" style="padding: 0 20px 10px 20px;">
                            <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:georgia, times, 'times new roman', serif;line-height:21px;color:{{ $newsTextColor }};font-size:14px">
                                {!! $note->news->synthesis !!} ({{ $note->news->news_date->format('d-m-Y') }})
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" style="padding: 0 20px 20px 20px;">
                            <p style="Margin:0;line-height:14px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:12px;font-style:normal;font-weight:normal;color:{{ $newsTextColor }};"><strong>
                                {{ $note->news->mean->name }}, {{ $note->news->source->name ?? 'N/E' }}, {{ $note->news->author }}
                            </strong></p>
                        </td>
                    </tr>
                @endif
            @endforeach
        @endforeach

        <tr>
            <td style="padding-top: 20px;">
                
            </td>
        </tr>
        <tr>
            <td align="center" style="text-align: center; padding: 20px 20px; background-color:{{ $footerBgColor }};">
                <img class="adapt-img" src="{{ asset('images/opemedios_logo.png') }}" alt style="border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="179">
            </td>
        </tr>
        <tr>
            <td style="text-align: center; padding: 20px 20px 0px 20px;">
                <table cellspacing="0" cellpadding="0" role="presentation" style="border-collapse:collapse; margin: 0 auto 0 auto;">
                    <tr style="border-collapse:collapse">
                        <td style="padding-right:20px;font-family: arial, 'helvetica neue', helvetica, sans-serif;color:{{ $footerTextColor }};font-weight: bold;" valign="center">
                            <p>Síguenos:</p>
                        </td>
                        <td valign="top" align="center" style="text-align: left;">
                            <a target="_blank" href="javascript:void(0);" style="text-decoration:none;">
                                <img title="Facebook" src="{{ asset('images/facebook-rounded-gray.png') }}" alt="Fb" width="32" height="32" style="border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic">
                                &nbsp;
                            </a>
                            <a target="_blank" href="javascript:void(0);" style="text-decoration:none;">
                                <img title="Twitter" src="{{ asset('images/twitter-rounded-gray.png') }}" alt="Tw" width="32" height="32" style="border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic">
                                &nbsp;
                            </a>
                            <a target="_blank" href="javascript:void(0);" style="text-decoration:none;">
                                <img title="Instagram" src="{{ asset('images/instagram-rounded-gray.png') }}" alt="Inst" width="32" height="32" style="border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic">
                                &nbsp;
                            </a>
                            <a target="_blank" href="javascript:void(0);" style="text-decoration:none;">
                                <img title="Youtube" src="{{ asset('images/youtube-rounded-gray.png') }}" alt="Yt" width="32" height="32" style="border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic">
                                &nbsp;
                            </a>
                            <a target="_blank" href="javascript:void(0);" style="text-decoration:none;">
                                <img title="Linkedin" src="{{ asset('images/linkedin-rounded-gray.png') }}" alt="In" width="32" height="32" style="border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic">
                                &nbsp;
                            </a>
                            <a target="_blank" href="javascript:void(0);" style="text-decoration:none;">
                                <img title="Pinterest" src="{{ asset('images/pinterest-rounded-gray.png') }}" alt="P" width="32" height="32" style="border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic">
                                &nbsp;
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding:0;Margin:0;padding-top:5px;padding-bottom:10px">
                <p style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;color:{{ $footerTextColor }}; font-weight: bold; font-size: 13px;">
                    Contactanos: 55 4030 4996 | 55 3495 1145 | <a target="_blank" href="mailto:contacto@opemedios.com.mx" style="text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:{{ $footerTextColor }};font-size:12px">contacto@opemedios.com.mx</a>
                </p>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding:0 5px 0 5px;">
                <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:georgia, times, 'times new roman', serif;line-height:18px;color:{{ $footerTextColor }};font-size:12px">This daily newsletter was sent to <a target="_blank" href="mailto:contacto@opemedios.com.mx" style="text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:{{ $footerTextColor }};font-size:12px">contacto@opemedios.com.mx</a> from company name because you subscribed.</p>
            </td>
        </tr>
    </table>
</body>
</html>
