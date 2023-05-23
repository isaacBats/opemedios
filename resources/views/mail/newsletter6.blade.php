<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" style="width:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
<head>
    @php
        $colorsConfig = unserialize($newsletterSend->newsletter->colors);
        $bgPrimary = isset($colorsConfig['bg_primary']) ? $colorsConfig['bg_primary'] : "#646464";
        $bgCovers = isset($colorsConfig['bg_covers']) ? $colorsConfig['bg_covers'] : "#615d5c";
        $bgFontCovers = isset($colorsConfig['bg_font_covers']) ? $colorsConfig['bg_font_covers'] : "#ffffff";
        $bgTitleSecond = isset($colorsConfig['bg_title_second']) ? $colorsConfig['bg_title_second'] : "#F7F7F7";
        $bgBodyThemeSecond = isset($colorsConfig['bg_body_theme_second']) ? $colorsConfig['bg_body_theme_second'] : "#ffffff";
    @endphp
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title>Amp-accordion</title><!--[if (mso 16)]>
    <style type="text/css">
    a {text-decoration: none;}
    </style>
    <![endif]--><!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--><!--[if gte mso 9]>
    <xml>
    <o:OfficeDocumentSettings>
        <o:AllowPNG></o:AllowPNG>
        <o:PixelsPerInch>96</o:PixelsPerInch>
    </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
    <style type="text/css">
        .section-title {
            padding:5px 10px;
            background-color:#f6f6f6;
            border:1px solid #dfdfdf;
            outline:0;
        }
        a {
            text-decoration:none;
        }
        #outlook a {
            padding:0;
        }
        .ExternalClass {
            width:100%;
        }
        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
            line-height:100%;
        }
        .es-button {
            mso-style-priority:100!important;
            text-decoration:none!important;
        }
        a[x-apple-data-detectors] {
            color:inherit!important;
            text-decoration:none!important;
            font-size:inherit!important;
            font-family:inherit!important;
            font-weight:inherit!important;
            line-height:inherit!important;
        }
        .es-desk-hidden {
            display:none;
            float:left;
            overflow:hidden;
            width:0;
            max-height:0;
            line-height:0;
            mso-hide:all;
        }
        [data-ogsb] .es-button {
            border-width:0!important;
            padding:10px 15px 10px 15px!important;
        }
        @media only screen and (max-width:600px) {p, ul li, ol li, a { line-height:150%!important } h1, h2, h3, h1 a, h2 a, h3 a { line-height:120%!important } h1 { font-size:30px!important; text-align:left } h2 { font-size:20px!important; text-align:left } h3 { font-size:16px!important; text-align:left } h1 a { text-align:left } .es-header-body h1 a, .es-content-body h1 a, .es-footer-body h1 a { font-size:30px!important } h2 a { text-align:left } .es-header-body h2 a, .es-content-body h2 a, .es-footer-body h2 a { font-size:20px!important } h3 a { text-align:left } .es-header-body h3 a, .es-content-body h3 a, .es-footer-body h3 a { font-size:16px!important } .es-menu td a { font-size:14px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:14px!important } .es-content-body p, .es-content-body ul li, .es-content-body ol li, .es-content-body a { font-size:14px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:12px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:11px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:inline-block!important } a.es-button, button.es-button { font-size:18px!important; display:inline-block!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0px!important } .es-m-p0r { padding-right:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p0t { padding-top:0px!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } tr.es-desk-hidden, td.es-desk-hidden, table.es-desk-hidden { width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } tr.es-desk-hidden { display:table-row!important } table.es-desk-hidden { display:table!important } td.es-desk-menu-hidden { display:table-cell!important } .es-menu td { width:1%!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } .stack { display:block!important } .h-resize20px { height:20px!important } .reveal-mobile-2 { display:block!important; width:100%!important; max-height:inherit!important; overflow:visible!important; text-align:right!important } .content-open { border-radius:30px; padding:4px; display:inline-block; text-align:center; width:20px; height:20px; position:relative; top:12px; font-size:18px; font-family:Arial, sans-serif; margin-right:10px; vertical-align:middle!important } .body-content-1, .body-content-2, .body-content-3 { max-height:0; overflow:hidden; margin:0 } #content-1:target div.body-content-1, #content-2:target div.body-content-2, #content-3:target div.body-content-3 { -webkit-transition:all 0.5s ease-in-out; -moz-transition:all 0.5s ease-in-out; -ms-transition:all 0.5s ease-in-out; -o-transition:all 0.5s ease-in-out; transition:all 0.5s ease-in-out; max-height:999px } .es-desk-hidden { display:table-row!important; width:auto!important; overflow:visible!important; max-height:inherit!important } .h-auto { height:auto!important } }
    </style>
</head>
<body style="width:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;font-family:georgia, times, 'times new roman', serif;padding:0;Margin:0">
<div class="es-wrapper-color" style="background-color:#F7F7F7"><!--[if gte mso 9]>
    <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
    <v:fill type="tile" color="#f7f7f7"></v:fill>
    </v:background>
    <![endif]-->
    <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;background-color:#F7F7F7">
        <tr style="border-collapse:collapse">
            <td valign="top" style="padding:0;Margin:0">
                <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                    <tr style="border-collapse:collapse">
                        <td class="es-adaptive" align="center" style="padding:0;Margin:0">
                            <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" align="center">
                                <tr style="border-collapse:collapse">
                                    <td align="left" style="padding:10px;Margin:0">
                                        <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                            <tr style="border-collapse:collapse">
                                                <td valign="top" align="center" style="padding:0;Margin:0;width:580px">
                                                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                        <tr style="border-collapse:collapse">
                                                            <td class="es-infoblock" align="center" style="padding:0;Margin:0;line-height:13px;font-size:11px;color:#999999"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:georgia, times, 'times new roman', serif;line-height:13px;color:#999999;font-size:11px">Si no puedes ver la información. <a href="{{ route('front.newsletter.see', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$newsletterSend->id}-{$newsletterSend->newsletter->company->id}")]) }}" target="_blank" style="text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#3D5CA3;font-size:11px">Pulsa aquí</a></p></td>
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                        </table></td>
                                </tr>
                            </table></td>
                    </tr>
                </table>
                <table class="es-header" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top">
                    <tr style="border-collapse:collapse">
                        <td class="es-adaptive" align="center" style="padding:0;Margin:0">
                            <table class="es-header-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#3d5ca3;width:600px" cellspacing="0" cellpadding="0" bgcolor="#3d5ca3" align="center">
                                <tr style="border-collapse:collapse">
                                    <td style="Margin:0;padding-top:20px;padding-bottom:20px;padding-left:20px;padding-right:20px;background-color:#ffffff" bgcolor="#ffffff" align="left"><!--[if mso]><table style="width:560px" cellpadding="0"
                                                                                                                                                                                                               cellspacing="0"><tr><td style="width:270px" valign="top"><![endif]-->
                                        <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                                            <tr style="border-collapse:collapse">
                                                <td class="es-m-p20b" align="left" style="padding:0;Margin:0;width:270px">
                                                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                        <tr style="border-collapse:collapse">
                                                            <td class="es-m-p0l es-m-txt-c" align="left" style="padding:0;Margin:0;font-size:0px"><a href="javascript:void(0);" target="_blank" style="text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#F6B26B;font-size:14px"><img src="{{ asset("images/{$newsletterSend->newsletter->banner}") }}" alt="{{ $newsletterSend->newsletter->name }}" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" height="56"></a></td>
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                        </table><!--[if mso]></td><td style="width:20px"></td><td style="width:270px" valign="top"><![endif]-->
                                        <table class="es-right" cellspacing="0" cellpadding="0" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right">
                                            <tr style="border-collapse:collapse">
                                                <td align="left" style="padding:0;Margin:0;width:270px">
                                                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                        <tr style="border-collapse:collapse">
                                                            @php
                                                                $day = date('Y-m-d H:i:s');
                                                            @endphp
                                                            <td align="right" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:georgia, times, 'times new roman', serif;line-height:21px;color:#666666;font-size:14px">{{ ucfirst(Illuminate\Support\Carbon::parse($day)->formatLocalized('%A %d de %B %Y')) }}</p></td>
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                        </table><!--[if mso]></td></tr></table><![endif]--></td>
                                </tr>
                            </table></td>
                    </tr>
                </table>
                @foreach ($newsletterSend->newsletter->company->themes as $theme)
                    @if($newsletterSend->newsletter_theme_news->where('newsletter_theme_id', $theme->id)->count())
                        <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%"> <!-- Campo de tema -->
                            <tr style="border-collapse:collapse">
                                <td align="center" style="padding:0;Margin:0">
                                    <table class="es-content-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px">
                                        <tr style="border-collapse:collapse">
                                            <td align="left" style="padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px">
                                                <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                    <tr style="border-collapse:collapse">
                                                        <td align="center" valign="top" style="padding:0;Margin:0;width:560px">
                                                            <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                                <tr style="border-collapse:collapse">
                                                                    @php
                                                                        $countNotes = $newsletterSend
                                                                            ->newsletter_theme_news->where('newsletter_theme_id', $theme->id)
                                                                            ->count();
                                                                    @endphp
                                                                    <td align="left" bgcolor="#273095" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:georgia, times, 'times new roman', serif;line-height:27px;color:#efefef;font-size:18px"><strong>&nbsp;{{ strtoupper($theme->name) }} | </strong><span style="font-size:14px">Noticias encontradas : <strong>{{ $countNotes }}</strong></span><strong></strong></p></td>
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
                        </table> <!-- Fin de campo de tema -->
                    @endif
                    @foreach ($newsletterSend->newsletter_theme_news as $note)
                        @if($note->theme->id == $theme->id)
                            <table class="es-content es-visible-simple-html-only" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                                <tr style="border-collapse:collapse">
                                    <td align="center" style="padding:0;Margin:0">
                                        <table class="es-content-body" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px">
                                            <tr style="border-collapse:collapse">
                                                <td style="padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px;background-position:center top" align="left">
                                                    <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                        <tr style="border-collapse:collapse">
                                                            <td valign="top" align="center" style="padding:0;Margin:0;width:560px">
                                                                <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                                    <tr style="border-collapse:collapse">
                                                                        <td class="h-auto" align="left" valign="middle" height="73" style="padding:0;Margin:0;padding-bottom:10px"><h2 style="Margin:0;line-height:22px;mso-line-height-rule:exactly;font-family:georgia, times, 'times new roman', serif;font-size:18px;font-style:normal;font-weight:normal;color:#2c348b"><strong><a target="_blank" style="text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#273095;font-size:18px;line-height:22px;font-family:georgia, times, 'times new roman', serif" href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}">{{ $note->news->title }}</a></strong></h2></td>
                                                                    </tr>
                                                                    <tr style="border-collapse:collapse">
                                                                        <td align="left" style="padding:0;Margin:0;padding-bottom:5px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:georgia, times, 'times new roman', serif;line-height:21px;color:#333333;font-size:14px">{!! $note->news->synthesis !!} ({{ $note->news->news_date->format('d-m-Y') }})</p></td>
                                                                    </tr>
                                                                    <tr style="border-collapse:collapse">
                                                                        <td align="left" style="padding:0;Margin:0;padding-bottom:10px"><h2 style="Margin:0;line-height:14px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:12px;font-style:normal;font-weight:normal;color:#3d85c6"><strong>{{ $note->news->mean->name }}, {{ $note->news->source->name ?? 'N/E' }}, {{ $note->news->author }}</strong></h2></td>
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
                            </table> <!-- Fin de la tabla de contenido -->
                        @endif
                    @endforeach
                @endforeach
                <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                    <tr style="border-collapse:collapse">
                        <td align="center" style="padding:0;Margin:0">
                            <table class="es-content-body" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px">
                                <tr style="border-collapse:collapse">
                                    <td style="Margin:0;padding-left:10px;padding-right:10px;padding-top:15px;padding-bottom:15px;background-color:#cccccc" bgcolor="#cccccc" align="left"><!--[if mso]><table style="width:580px" cellpadding="0"
                                                                                                                                                                                                               cellspacing="0"><tr><td style="width:202px" valign="top"><![endif]-->
                                        <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                                            <tr style="border-collapse:collapse">
                                                <td class="es-m-p0r es-m-p20b" align="center" style="padding:0;Margin:0;width:182px">
                                                    <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                        <tr style="border-collapse:collapse">
                                                            <td align="center" style="padding:0;Margin:0;display:none"></td>
                                                        </tr>
                                                    </table></td>
                                                <td class="es-hidden" style="padding:0;Margin:0;width:20px"></td>
                                            </tr>
                                        </table><!--[if mso]></td><td style="width:179px" valign="top"><![endif]-->
                                        <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                                            <tr style="border-collapse:collapse">
                                                <td class="es-m-p20b" align="center" style="padding:0;Margin:0;width:179px">
                                                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                        <tr style="border-collapse:collapse">
                                                            <td align="center" style="padding:0;Margin:0;font-size:0px"><img class="adapt-img" src="{{ asset('images/opemedios_logo.png') }}" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="179"></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table><!--[if mso]></td><td style="width:20px"></td><td style="width:179px" valign="top"><![endif]-->
                                        <table class="es-right" cellspacing="0" cellpadding="0" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right">
                                            <tr style="border-collapse:collapse">
                                                <td align="center" style="padding:0;Margin:0;width:179px">
                                                    <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                        <tr style="border-collapse:collapse">
                                                            <td align="center" style="padding:0;Margin:0;display:none"></td>
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                        </table><!--[if mso]></td></tr></table><![endif]--></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table class="es-footer" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top">
                    <tr style="border-collapse:collapse">
                        <td align="center" style="padding:0;Margin:0">
                            <table class="es-footer-body" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px">
                                <tr style="border-collapse:collapse">
                                    <td align="left" style="padding:0;Margin:0;padding-left:10px;padding-right:10px;padding-top:20px"><!--[if mso]><table style="width:580px" cellpadding="0"
                                                                                                                                                          cellspacing="0"><tr><td style="width:190px" valign="top"><![endif]-->
                                        <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                                            <tr style="border-collapse:collapse">
                                                <td class="es-m-p0r es-m-p20b" valign="top" align="center" style="padding:0;Margin:0;width:190px">
                                                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                        <tr style="border-collapse:collapse">
                                                            <td class="es-m-txt-c" esdev-links-color="#666666" align="right" style="padding:0;Margin:0;padding-top:5px"><h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;color:#666666">Síguenos:</h4></td>
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                        </table><!--[if mso]></td><td style="width:20px"></td><td style="width:370px" valign="top"><![endif]-->
                                        <table cellspacing="0" cellpadding="0" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                            <tr style="border-collapse:collapse">
                                                <td align="left" style="padding:0;Margin:0;width:370px">
                                                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                        <tr style="border-collapse:collapse">
                                                            <td class="es-m-txt-c" align="left" style="padding:0;Margin:0;font-size:0">
                                                                <table class="es-table-not-adapt es-social" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                                    <tr style="border-collapse:collapse">
                                                                        <td valign="top" align="center" style="padding:0;Margin:0;padding-right:15px"><a target="_blank" href="javascript:void(0);" style="text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#666666;font-size:12px"><img title="Facebook" src="{{ asset('images/facebook-rounded-gray.png') }}" alt="Fb" width="32" height="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></a></td>
                                                                        <td valign="top" align="center" style="padding:0;Margin:0;padding-right:15px"><a target="_blank" href="javascript:void(0);" style="text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#666666;font-size:12px"><img title="Twitter" src="{{ asset('images/twitter-rounded-gray.png') }}" alt="Tw" width="32" height="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></a></td>
                                                                        <td valign="top" align="center" style="padding:0;Margin:0;padding-right:15px"><a target="_blank" href="javascript:void(0);" style="text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#666666;font-size:12px"><img title="Instagram" src="{{ asset('images/instagram-rounded-gray.png') }}" alt="Inst" width="32" height="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></a></td>
                                                                        <td valign="top" align="center" style="padding:0;Margin:0;padding-right:15px"><a target="_blank" href="javascript:void(0);" style="text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#666666;font-size:12px"><img title="Youtube" src="{{ asset('images/youtube-rounded-gray.png') }}" alt="Yt" width="32" height="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></a></td>
                                                                        <td valign="top" align="center" style="padding:0;Margin:0;padding-right:15px"><a target="_blank" href="javascript:void(0);" style="text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#666666;font-size:12px"><img title="Linkedin" src="{{ asset('images/linkedin-rounded-gray.png') }}" alt="In" width="32" height="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></a></td>
                                                                        <td valign="top" align="center" style="padding:0;Margin:0;padding-right:10px"><a target="_blank" href="javascript:void(0);" style="text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#666666;font-size:12px"><img title="Pinterest" src="{{ asset('images/pinterest-rounded-gray.png') }}" alt="P" width="32" height="32" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></a></td>
                                                                    </tr>
                                                                </table></td>
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                        </table><!--[if mso]></td></tr></table><![endif]--></td>
                                </tr>
                                <tr style="border-collapse:collapse">
                                    <td align="left" style="Margin:0;padding-top:5px;padding-bottom:10px;padding-left:10px;padding-right:10px">
                                        <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                            <tr style="border-collapse:collapse">
                                                <td valign="top" align="center" style="padding:0;Margin:0;width:580px">
                                                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                        <tr style="border-collapse:collapse">
                                                            <td align="center" style="padding:0;Margin:0;padding-top:5px;padding-bottom:10px"><h5 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;color:#666666">Contactanos: 55-5584-64-10 | <a target="_blank" href="mailto:contacto@opemedios.com.mx" style="text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#666666;font-size:12px">contacto@opemedios.com.mx</a></h5></td>
                                                        </tr>
                                                        <tr style="border-collapse:collapse">
                                                            <td align="center" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:georgia, times, 'times new roman', serif;line-height:18px;color:#666666;font-size:12px">This daily newsletter was sent to <a target="_blank" href="mailto:contacto@opemedios.com.mx" style="text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#666666;font-size:12px">contacto@opemedios.com.mx</a> from company name because you subscribed.</p></td>
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                        </table></td>
                                </tr>
                            </table></td>
                    </tr>
                </table></td>
        </tr>
    </table>
</div>
</body>
</html>
