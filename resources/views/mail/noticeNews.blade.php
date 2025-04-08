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
    <body style="margin: 0; padding: 0; background-color: #0c0a75">
        <!-- Main Content Table -->
        <table
            align="center"
            border="0"
            cellpadding="0"
            cellspacing="0"
            width="500"
            style="
                border-collapse: collapse;
                background-color: #f2f2f2;
                width: 100%;
                max-width: 500px;
            "
        >
            <tr>
                <td style="padding: 0px 20px 0px 20px">
                    <table
                        border="0"
                        cellpadding="0"
                        cellspacing="0"
                        width="100%"
                    >
                        <tr>
                            <td style="padding-bottom: 30px">
                                <table
                                    align="center"
                                    border="0"
                                    cellpadding="0"
                                    cellspacing="0"
                                >
                                    <tr>
                                        <td
                                            style="
                                                padding: 15px 10px;
                                                border-radius: 0 0 10px 10px;
                                                background: #ffffff;
                                            "
                                        >
                                            <img
                                                src="https://opemedios.com.mx/images/opemedios-logo.png"
                                                width="120" height="48" style="width: 120px; height: auto;"
                                            />
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-bottom: 15px">
                                <table
                                    border="0"
                                    cellpadding="0"
                                    cellspacing="0"
                                    width="100%"
                                    align="center"
                                    style="padding-bottom: 20px"
                                >
                                    <tr>
                                        <td
                                            style="
                                                border-left: 5px solid #bb1449;
                                                padding-right: 10px;
                                            "
                                        ></td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td
                                                        style="
                                                            font-family: Arial,
                                                                sans-serif;
                                                            font-size: 17px;
                                                            font-weight: bold;
                                                            color: #000000;
                                                            mso-line-height-rule: exactly;
                                                            line-height: 26px;
                                                        "
                                                    >
                                                    {{ $news->title }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="
                                                            padding-top: 15px;
                                                            font-family: Arial,
                                                                sans-serif;
                                                            font-size: 14px;
                                                            color: #222222;
                                                            mso-line-height-rule: exactly;
                                                            line-height: 25px;
                                                        "
                                                    >
                                                    {!! Illuminate\Support\Str::limit($news->synthesis, 200) !!}
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
        <table
            align="center"
            border="0"
            cellpadding="0"
            cellspacing="0"
            width="500"
            style="
                border-collapse: collapse;
                background-color: #ffffff;
                width: 100%;
                max-width: 500px;
            "
        >
            <tr>
                <td style="padding: 0px 10px 0px 10px">
                    <table
                        border="0"
                        cellpadding="0"
                        cellspacing="0"
                        width="100%"
                    >
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
                                    background: #ffffff;
                                    font-family: Arial, sans-serif;
                                    font-size: 14px;
                                    color: #222222;
                                    padding: 15px 15px 15px 15px;
                                    mso-line-height-rule: exactly;
                                    line-height: 26px;
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
                                                padding-right: 1px;
                                                vertical-align: top;
                                                padding-left: 10px;
                                            "
                                        >
                                            Fuente:
                                        </td>
                                        <td
                                            style="
                                                font-weight: bold;
                                                padding-left: 10px;
                                            "
                                        >
                                            {{ $news->source->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="height: 10px"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="
                                                height: 1px;
                                                background: #b2b2b2;
                                            "
                                        ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td style="height: 10px"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="
                                                padding-right: 1px;
                                                vertical-align: top;
                                                padding-left: 10px;
                                            "
                                        >
                                            Alcance:
                                        </td>
                                        <td
                                            style="
                                                font-weight: bold;
                                                padding-left: 10px;
                                            "
                                        >
                                            {{ $scope['value'] }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="height: 10px"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="
                                                height: 1px;
                                                background: #b2b2b2;
                                            "
                                        ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td style="height: 10px"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="
                                                padding-right: 1px;
                                                vertical-align: top;
                                                padding-left: 10px;
                                            "
                                        >
                                            Costo:
                                        </td>
                                        <td
                                            style="
                                                font-weight: bold;
                                                padding-left: 10px;
                                            "
                                        >
                                            {{ $cost['value'] }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table
            align="center"
            border="0"
            cellpadding="0"
            cellspacing="0"
            width="500"
            style="
                border-collapse: collapse;
                background-color: #f2f2f2;
                width: 100%;
                max-width: 500px;
            "
        >
            <tr>
                <td style="padding: 0px 20px 30px 20px">
                    <table
                        border="0"
                        cellpadding="0"
                        cellspacing="0"
                        width="100%"
                    >
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
                                    background-color: #bd174b;
                                    padding: 17px 20px;
                                    border-width: 1px;
                                    border-style: solid;
                                    border-color: #bd174b;
                                "
                            >
                                <a
                                    href="#"
                                    class="button"
                                    style="
                                        display: inline-block;

                                        color: #ffffff;
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
                background-color: #0c0a75;
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
                        background-color: #0c0a75;
                    "
                >
                    <p style="margin: 0; font-size: 12px; color: #999999">
                        &copy; {{ date('Y') }} Opemedios. Todos los derechos reservados.
                    </p>
                </td>
            </tr>
        </table>
    </body>
</html>
