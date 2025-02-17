<!DOCTYPE html>
<html
    xmlns="http://www.w3.org/1999/xhtml"
    xmlns:o="urn:schemas-microsoft-com:office:office"
>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="format-detection" content="telephone=no" />
        <title>{{ "Opemedios - {$news->title}" }}</title>
        @php
            $day = date('Y-m-d H:i:s');

            $colorsConfig = unserialize($newsletterSend->newsletter->colors);

            $bodyBgColor = isset($colorsConfig['body_bg']) ? $colorsConfig['body_bg'] : "#d0d0d0";

            $mainBgColor = isset($colorsConfig['main_bg']) ? $colorsConfig['main_bg'] : "#f2f2f2";
            
            $dateBorderColor = isset($colorsConfig['date_border']) ? $colorsConfig['date_border'] : "#b2b2b2";
            $dateTextColor = isset($colorsConfig['date_text']) ? $colorsConfig['date_text'] : "#222222";

            $newsBorderColor = isset($colorsConfig['news_border']) ? $colorsConfig['news_border'] : "#b0b0b0";
            $newsTitleColor = isset($colorsConfig['news_title']) ? $colorsConfig['news_title'] : "#000000";
            $newsTextColor = isset($colorsConfig['news_text']) ? $colorsConfig['news_text'] : "#222222";

            $newsButtonBgColor = isset($colorsConfig['news_button_bg']) ? $colorsConfig['news_button_bg'] : "#444444";
            $newsButtonBorderColor = isset($colorsConfig['news_button_border']) ? $colorsConfig['news_button_border'] : "#444444";
            $newsButtonTextColor = isset($colorsConfig['news_button_text']) ? $colorsConfig['news_button_text'] : "#ffffff";

            $footerBgColor = isset($colorsConfig['footer_bg']) ? $colorsConfig['footer_bg'] : "#bbbbbb";
            $footerTextColor = isset($colorsConfig['footer_text']) ? $colorsConfig['footer_text'] : "#444444";
        @endphp
        <style type="text/css">
            /* Reset styles for email clients */
            body,
            table,
            td,
            a {
                -webkit-text-size-adjust: 100%;
                -ms-text-size-adjust: 100%;
            }
            table,
            td {
                mso-table-lspace: 0pt;
                mso-table-rspace: 0pt;
            }
            img {
                -ms-interpolation-mode: bicubic;
            }
            /* Outlook link fix */
            a[x-apple-data-detectors] {
                color: inherit !important;
                text-decoration: none !important;
                font-size: inherit !important;
                font-family: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
            }
        </style>
    </head>
    <body style="margin: 0; padding: 0; background-color: {{ $bodyBgColor }}">
        <!-- Preheader -->
        <div style="display:none;font-size:1px;color:{{ $bodyBgColor }};line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;"></div> <span style="display:none!important;visibility:hidden;mso-hide:all;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;"> {{ config('app.name', 'Opemedios') }}&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;</span>
        <!-- Main Content Table -->
        <table
            align="center"
            border="0"
            cellpadding="0"
            cellspacing="0"
            width="500"
            style="
                border-collapse: collapse;
                background-color: {{ $mainBgColor }};
                width: 100%;
                max-width: 500px;
            "
        >
            <tr>
                <td style="padding: 30px 20px 30px 20px">
                    <!-- Title -->
                    <table
                        border="0"
                        cellpadding="0"
                        cellspacing="0"
                        width="100%"
                    >
                        <tr>
                            <td style="padding-bottom: 15px">
                                <table
                                    border="0"
                                    cellpadding="0"
                                    cellspacing="0"
                                    width="100%"
                                >
                                    <tr>
                                        <td
                                            style="
                                                border-left: 1px solid
                                                    {{ $newsBorderColor }};
                                                padding-right: 9px;
                                            "
                                        ></td>
                                        <td
                                            style="
                                                font-family: Arial, sans-serif;
                                                font-size: 17px;
                                                font-weight: bold;
                                                color: {{ $newsTitleColor }};
                                                mso-line-height-rule: exactly;
                                                line-height: 26px;
                                            "
                                        >
                                        {{ $news->title }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <!-- Content -->
                    <table
                        border="0"
                        cellpadding="0"
                        cellspacing="0"
                        width="100%"
                    >
                        <tr>
                            <td
                                style="
                                    font-family: Arial, sans-serif;
                                    font-size: 14px;
                                    color: {{ $newsTextColor }};
                                    padding-bottom: 30px;
                                    mso-line-height-rule: exactly;
                                    line-height: 20px;
                                    padding-left: 10px;
                                "
                            >
                            {!! Illuminate\Support\Str::limit($news->synthesis, 200) !!}
                            </td>
                        </tr>
                    </table>

                    <!-- Source -->
                    <table
                        border="0"
                        cellpadding="0"
                        cellspacing="0"
                        width="100%"
                    >
                        <tr>
                            <td
                                style="
                                    font-family: Arial, sans-serif;
                                    font-size: 14px;
                                    color: {{ $dateTextColor }};
                                    padding-top: 15px;
                                    padding-bottom: 10px;
                                    mso-line-height-rule: exactly;
                                    line-height: 26px;
                                    border-top: 1px solid {{ $dateBorderColor }};
                                "
                            >
                                <table
                                    border="0"
                                    cellpadding="0"
                                    cellspacing="0"
                                >
                                    <tr>
                                        <td
                                            style="
                                                padding-right: 5px;
                                                vertical-align: top;
                                            "
                                        >
                                            &bull; Fuente:
                                        </td>
                                        <td style="font-weight: bold">
                                        {{ $news->source->name }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <!-- Metrics -->
                    <table
                        border="0"
                        cellpadding="0"
                        cellspacing="0"
                        width="100%"
                    >
                        <tr>
                            <td
                                style="
                                    font-family: Arial, sans-serif;
                                    font-size: 14px;
                                    color: {{ $dateTextColor }};
                                    padding-bottom: 15px;
                                    border-bottom: 1px solid
                                        {{ $dateBorderColor }};
                                    mso-line-height-rule: exactly;
                                    line-height: 26px;
                                "
                            >
                                <table
                                    border="0"
                                    cellpadding="0"
                                    cellspacing="0"
                                    width="100%"
                                    style="width: 100%"
                                >
                                    <tr>
                                        <td
                                            style="
                                                padding-right: 10px;
                                                width: 50%;
                                            "
                                        >
                                            &bull; Alcance:
                                            <span style="font-weight: bold"
                                                >{{ $scope['value'] }}</span
                                            >
                                        </td>
                                        <td>
                                            &bull; Costo:
                                            <span style="font-weight: bold"
                                                >{{ $cost['value'] }}</span
                                            >
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <!-- Button -->
                    <table
                        border="0"
                        cellpadding="0"
                        cellspacing="0"
                        align="center"
                        style="padding-top: 30px"
                    >
                        <tr>
                            <td
                                align="center"
                                style="
                                    background-color: {{ $newsButtonBgColor }};
                                    padding: 10px 20px;
                                    border-radius: 5px;
                                    border-width: 1px;
                                    border-style: solid;
                                    border-color: {{ $newsButtonBorderColor }};
                                "
                            >
                                <a
                                    href="{{ route('front.detail.news', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$news->id}-{$news->title}-{$theme->company->id}")]) }}"
                                    class="button"
                                    style="
                                        display: inline-block;

                                        color: {{ $newsButtonTextColor }};
                                        text-decoration: none;
                                        font-size: 16px;
                                        font-family: Arial, sans-serif;
                                    "
                                    >{{ __('Ver noticia completa') }}</a
                                >
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Footer -->
        <table
            align="center"
            border="0"
            cellpadding="0"
            cellspacing="0"
            width="500"
            style="
                border-collapse: collapse;
                background-color: {{ $footerBgColor }};
                width: 100%;
                max-width: 500px;
            "
        >
            <tr>
                <td
                    class="footer"
                    style="
                        padding: 20px;
                        text-align: center;
                        background-color: {{ $footerBgColor }};
                    "
                >
                    <p
                        style="
                            margin: 0;
                            font-size: 12px;
                            color: {{ $footerTextColor }};
                        "
                    >
                        &copy; {{ date('Y') }}  Opemedios. Todos los derechos reservados.
                    </p>
                </td>
            </tr>
        </table>
    </body>
</html>
