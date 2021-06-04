<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ config('app.name', 'Opemedios Newsletter') }}</title>
    <style>
        body, .body{
          margin: 0;
          Margin: 0;
          padding: 0;
          border: 0;
          outline: 0;
          width: 100%;
          min-width: 100%;
          height: 100%;
          -webkit-text-size-adjust: 100%;
          -ms-text-size-adjust: 100%;
          font-family: $font-family-sans-serif;
          line-height: $line-height-base * $font-size-base;
          font-weight: normal;
          font-size: $font-size-base;
          -moz-box-sizing: border-box;
          -webkit-box-sizing: border-box;
          box-sizing: border-box;
        }

        /*img{
          border: 0 none;
          height: auto;
          line-height: 100%;
          outline: none;
          text-decoration: none;
        }*/

        img {
            border: none;
            -ms-interpolation-mode: bicubic;
            max-width: 100%; 
        }

        a img{
          border: 0 none;
        }

        table {
            border-collapse: separate;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
            width: 100%;
        }
        
        table td {
            font-family: sans-serif;
            font-size: 14px;
            vertical-align: top; 
        }
        th,
        td,
        p {
          line-height: $line-height-base * $font-size-base;
          font-size: $font-size-base;
          margin: 0;
        }

        .container {
            display: block;
            margin: 0 auto !important;
            /* makes it centered */
            max-width: 580px;
            padding: 10px;
            width: 580px; 
        }

        /* This should also be a block element, so that it will fill 100% of the .container */
        .content {
            box-sizing: border-box;
            display: block;
            margin: 0 auto;
            max-width: 580px;
            padding: 10px; 
        }

        .main {
            background: #ffffff;
            border-radius: 3px;
            width: 100%; 
        }

        .wrapper {
            box-sizing: border-box;
            padding: 20px; 
        }

        @media only screen and (max-width: 620px) {
                table[class=body] h1 {
                  font-size: 28px !important;
                  margin-bottom: 10px !important; 
                }
                table[class=body] p,
                table[class=body] ul,
                table[class=body] ol,
                table[class=body] td,
                table[class=body] span,
                table[class=body] a {
                  font-size: 16px !important; 
                }
                table[class=body] .wrapper,
                table[class=body] .article {
                  padding: 10px !important; 
                }
                table[class=body] .content {
                  padding: 0 !important; 
                }
                table[class=body] .container {
                  padding: 0 !important;
                  width: 100% !important; 
                }
                table[class=body] .main {
                  border-left-width: 0 !important;
                  border-radius: 0 !important;
                  border-right-width: 0 !important; 
                }
                table[class=body] .btn table {
                  width: 100% !important; 
                }
                table[class=body] .btn a {
                  width: 100% !important; 
                }
                table[class=body] .img-responsive {
                  height: auto !important;
                  max-width: 100% !important;
                  width: auto !important; 
                }
              }

              /* -------------------------------------
                  PRESERVE THESE STYLES IN THE HEAD
              ------------------------------------- */
              @media all {
                .ExternalClass {
                  width: 100%; 
                }
                .ExternalClass,
                .ExternalClass p,
                .ExternalClass span,
                .ExternalClass font,
                .ExternalClass td,
                .ExternalClass div {
                  line-height: 100%; 
                }
                .apple-link a {
                  color: inherit !important;
                  font-family: inherit !important;
                  font-size: inherit !important;
                  font-weight: inherit !important;
                  line-height: inherit !important;
                  text-decoration: none !important; 
                }
                #MessageViewBody a {
                  color: inherit;
                  text-decoration: none;
                  font-size: inherit;
                  font-family: inherit;
                  font-weight: inherit;
                  line-height: inherit;
                }
                .btn-primary table td:hover {
                  background-color: #34495e !important; 
                }
                .btn-primary a:hover {
                  background-color: #34495e !important;
                  border-color: #34495e !important; 
                } 
              }

    </style>
  </head>
  <body class="">
    <table class="body">
        <tbody>
            <tr>
                <td class="container">
                    <div class="content">
                        <table class="main">
                            <tbody>
                                <tr>
                                    <td align="center" class="wrapper">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <!-- Banner -->
                                                        <img src="{{ asset("images/{$newsletterSend->newsletter->banner}") }}" alt="{{ $newsletterSend->newsletter->name }}" style="width: 100%;">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    @php
                                                        $day = date('Y-m-d H:i:s');
                                                    @endphp
                                                    <td align="right" style="padding: 15px 0;"><b>{{ Illuminate\Support\Carbon::parse($day)->formatLocalized('%A %d de %B %Y') }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td align="center">
                                                        <h3 style="border-bottom: 1px solid #f2f2f2; padding-bottom: 15px;">Resumen Diario</h3>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center">
                                                        {{-- HAGA CLIC EN EL NOMBRE DE LA SECCIÓN PARA VISUALIZAR LA INFORMACIÓN<br> --}}
                                                        <br>
                                                    </td>
                                                </tr>
                                                @foreach ($newsletterSend->newsletter_theme_news as $note)
                                                    <tr>
                                                        <td style="background-color:#f2f2f2;font-size:18px;color:#251d93;text-align:center;border:1px solid #f2eeee;border-radius:5px; padding: 15px 10px;">
                                                            <a href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}" style="color:#251d93;text-decoration:none" rel="noreferrer" target="_blank">{{ strtoupper($note->news->title) }}</a>
                                                        </td>
                                                    </tr>
                                                    <tr style="height:12px">
                                                        <td></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%">
                        </table>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
  </body>
</html>
