<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    @php
        $day = date('Y-m-d H:i:s');

        $colorsConfig = unserialize($newsletterSend->newsletter->colors);
        $bodyBgColor = isset($colorsConfig['body_bg']) ? $colorsConfig['body_bg'] : "#ffffff";
        $fontCoversColor = isset($colorsConfig['covers_bg']) ? $colorsConfig['covers_bg'] : "#ffffff";
        $mainBgColor = isset($colorsConfig['main_bg']) ? $colorsConfig['main_bg'] : "#ffffff";
        $dateTextColor = isset($colorsConfig['date_text']) ? $colorsConfig['date_text'] : "#f6f1df";
        $themeBorderColor = isset($colorsConfig['theme_border']) ? $colorsConfig['theme_border'] : "#f2f2f2";
        $themeTextColor = isset($colorsConfig['theme_text']) ? $colorsConfig['theme_text'] : "#000000";
        $newsButtonBgColor = isset($colorsConfig['news_button_bg']) ? $colorsConfig['news_button_bg'] : "#f2f2f2";
        $newsButtonBorderColor = isset($colorsConfig['news_button_border']) ? $colorsConfig['news_button_border'] : "#f2eeee";
        $newsButtonTextColor = isset($colorsConfig['news_button_text']) ? $colorsConfig['news_button_text'] : "#251d93";
    @endphp
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ config('app.name', 'Opemedios Newsletter') }}</title>
    <style>a[x-apple-data-detectors]{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}u+#body a{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}#MessageViewBody a{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}:root{color-scheme:light dark;supported-color-schemes:light dark;}tr{vertical-align:middle;}p,a,li{mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;}p:first-child{margin-top:0!important;}p:last-child{margin-bottom:0!important;}a{text-decoration:underline;color:inherit;}@media only screen and (max-width:599px){.full-width-mobile{width:100%!important;height:auto!important;}.mobile-padding{padding-left:10px!important;padding-right:10px!important;}.mobile-stack{display:block!important;width:100%!important;}}
    </style>
  </head>
  <body style="background-color:{{ $bodyBgColor }};padding:0px 0px 0px 0px;margin:0px 0px 0px 0px;">
    <table border="0" cellpadding="0" cellspacing="0" width="510" style="width:100%;max-width:510px;margin:0px auto 0px auto;background-color:{{ $mainBgColor }};" align="center">
        <tr>
            <td align="center">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="text-align:center;">
                            <!-- Banner -->
                            <img src="{{ asset("images/{$newsletterSend->newsletter->banner}") }}" alt="{{ $newsletterSend->newsletter->name }}" style="width: 100%;display:block;">
                        </td>
                    </tr>
                    <tr>
                        {{ Illuminate\Support\Carbon::parse($newsletterSend->date_sending)
                                    ->locale('es')
                                    ->formatLocalized('%A %d de %B %Y') }}
                        <td align="right" style="color:{{ $dateTextColor }};padding: 15px 20px 25px 20px;font-family:sans-serif;font-size:14px;"><b>{{ Illuminate\Support\Carbon::parse($day)->formatLocalized('%A %d de %B %Y') }}</b></td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 0 20px 0 20px;">
                            <h3 style="color:{{ $themeTextColor }};border-bottom: 1px solid {{ $themeBorderColor }}; padding-bottom: 15px;font-family:sans-serif;font-size:15px;">Resumen Diario</h3>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            {{-- HAGA CLIC EN EL NOMBRE DE LA SECCIÓN PARA VISUALIZAR LA INFORMACIÓN<br> --}}
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 20px 0 20px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 100%;">
                                @foreach ($newsletterSend->newsletter_theme_news as $note)
                                    <tr>
                                        <td bgcolor="{{ $newsButtonBgColor }}" style="background-color:{{ $newsButtonBgColor }};font-size:16px;color:{{ $fontCoversColor }};text-align:center;border:1px solid {{ $newsButtonBorderColor }};border-radius:5px; padding: 15px 10px;">
                                            <a href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}" style="color:{{ $newsButtonTextColor }};text-decoration:none;font-family:sans-serif;font-size:16px;" rel="noreferrer" target="_blank">{{ strtoupper($note->news->title) }}</a>
                                        </td>
                                    </tr>
                                    <tr style="height:12px">
                                        <td></td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
  </body>
</html>
