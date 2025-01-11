<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" style="width:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
 <head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <meta name="x-apple-disable-message-reformatting">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="telephone=no" name="format-detection">
  <title>Newsletter - Opemedios</title><!--[if (mso 16)]>
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
  <style>a[x-apple-data-detectors]{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}u+#body a{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}#MessageViewBody a{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}:root{color-scheme:light dark;supported-color-schemes:light dark;}tr{vertical-align:middle;}p,a,li{mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;}p:first-child{margin-top:0!important;}p:last-child{margin-bottom:0!important;}a{text-decoration:underline;color:inherit;}@media only screen and (max-width:599px){.full-width-mobile{width:100%!important;height:auto!important;}.mobile-padding{padding-left:10px!important;padding-right:10px!important;}.mobile-stack{display:block!important;width:100%!important;}}
  </style>
  @php
    $day = date('Y-m-d H:i:s');

    $colorsConfig = unserialize($newsletterSend->newsletter->colors);
    $bodyBgColor = isset($colorsConfig['body_bg']) ? $colorsConfig['body_bg'] : "#F7F7F7";
    $mainBgColor = isset($colorsConfig['main_bg']) ? $colorsConfig['main_bg'] : "#ffffff";
    $linksBgColor = isset($colorsConfig['links_bg']) ? $colorsConfig['links_bg'] : "#f6f1df";
    $linksButtonTextColor = isset($colorsConfig['links_button_text']) ? $colorsConfig['links_button_text'] : "#444444";
    $dateBgColor = isset($colorsConfig['date_bg']) ? $colorsConfig['date_bg'] : "#0c0d0d";
    $dateTextColor = isset($colorsConfig['date_text']) ? $colorsConfig['date_text'] : "#f6f5f4";
    $themeBgColor = isset($colorsConfig['theme_bg']) ? $colorsConfig['theme_bg'] : "#e4e2d0";
    $themeBorderColor = isset($colorsConfig['theme_border']) ? $colorsConfig['theme_border'] : "#888260";
    $themeTextColor = isset($colorsConfig['theme_text']) ? $colorsConfig['theme_text'] : "#888260";
    $newsBgColor = isset($colorsConfig['news_bg']) ? $colorsConfig['news_bg'] : "#f9f8e8";
    $newsBorderColor = isset($colorsConfig['news_border']) ? $colorsConfig['news_border'] : "#0b5394";
    $newsTitleColor = isset($colorsConfig['news_title']) ? $colorsConfig['news_title'] : "#0B5394";
    $newsTextColor = isset($colorsConfig['news_text']) ? $colorsConfig['news_text'] : "#666666";
    $footerBgColor = isset($colorsConfig['footer_bg']) ? $colorsConfig['footer_bg'] : "#0c0d0d";
    $footerTextColor = isset($colorsConfig['footer_text']) ? $colorsConfig['footer_text'] : "#f6f5f4";
    $linksAllowed = array_chunk($linksAllowed, 2, true);
@endphp
 </head>
 <body style="width:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;padding:0px 0px 0px 0px;Margin:0px 0px 0px 0px;background-color:{{ $bodyBgColor }};">
  <div class="es-wrapper-color" style="background-color:background-color:{{ $bodyBgColor }};"><!--[if gte mso 9]>
			<v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
				<v:fill type="tile" color="{{ $bodyBgColor }}"></v:fill>
			</v:background>
		<![endif]-->
   <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;background-color:{{ $bodyBgColor }};">
     <tr style="border-collapse:collapse">
      <td valign="top" style="padding:0;Margin:0">
       <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
         <tr style="border-collapse:collapse">
          <td class="es-adaptive" align="center" style="padding:0;Margin:0">
           <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:{{ $dateBgColor }};width:600px" cellspacing="0" cellpadding="0" bgcolor="{{ $dateBgColor }}" align="center">
             <tr style="border-collapse:collapse">
              <td align="left" bgcolor="{{ $dateBgColor }}" style="Margin:0;padding-bottom:5px;padding-left:5px;padding-right:5px;padding-top:20px;background-color:{{ $dateBgColor }};border-radius:15px 15px 0px 0px">
               <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                 <tr style="border-collapse:collapse">
                  <td valign="top" align="center" style="padding:0;Margin:0;width:590px">
                   <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                     <tr style="border-collapse:collapse">
                      <td class="es-infoblock" align="left" style="padding:0;Margin:0;padding-top:5px;padding-bottom:10px;padding-left:25px;line-height:13px;font-size:11px;color:{{ $dateTextColor }};">
                          <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:16px;color:{{ $dateTextColor }};;font-size:16px">NOTICIAS DEL DÍA&nbsp; |&nbsp;&nbsp;<span style="font-size:14px">
                                  <strong>
                                      {{-- Fecha del newsletter--}}
                                      {{ Illuminate\Support\Carbon::parse(
                                            $newsletterSend->date_sending
                                          )->formatLocalized('%A %d de %B %Y')
                                      }}
                                  </strong></span>
                          </p>
                      </td>
                     </tr>
                   </table></td>
                 </tr>
               </table></td>
             </tr>
           </table></td>
         </tr>
       </table>
       <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
         <tr style="border-collapse:collapse">
          <td align="center" style="padding:0;Margin:0">
           <table class="es-content-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px">
             <tr style="border-collapse:collapse">
              <td align="left" style="Margin:0;">
               <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                 <tr style="border-collapse:collapse">
                  <td valign="top" align="center" style="padding:0;Margin:0;width:590px">
                   <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                     <tr style="border-collapse:collapse">
                      <td class="es-infoblock made_with" align="left" style="Margin:0;line-height:0px;font-size:0px;color:#999999"><a target="_blank" href="{{ route('front.newsletter.see', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$newsletterSend->id}-{$newsletterSend->newsletter->company->id}")]) }}" style="text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:11px;line-height:0;"><img src="{{ asset("images/{$newsletterSend->newsletter->banner}") }}" alt="{{ $newsletterSend->newsletter->name }}" style="display:block;border:0;outline:none;text-decoration:none;width:100%;-ms-interpolation-mode:bicubic"></a></td>
                     </tr>
                   </table></td>
                 </tr>
               </table></td>
             </tr>
             <tr style="border-collapse:collapse">
              <td align="left" bgcolor="{{ $mainBgColor }}" style="Margin:0;padding-left:5px;padding-right:5px;padding-top:40px;padding-bottom:40px;background-color:{{ $mainBgColor }};background-image:url({{ asset("images/opemedios_news7_minibanner.jpeg") }});background-repeat:no-repeat;background-position:center top" background="{{ asset("images/opemedios_news7_minibanner.jpeg") }}">
               <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                 <tr style="border-collapse:collapse">
                  <td valign="top" align="center" style="padding:0;Margin:0;width:590px">
                   <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                     <tr style="border-collapse:collapse">
                      <td class="es-infoblock" align="left" style="padding:0;Margin:0;padding-left:25px;line-height:13px;font-size:11px;color:#999999"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:16px;color:#fffff0;font-size:13px"><br></p></td>
                     </tr>
                   </table></td>
                 </tr>
               </table></td>
             </tr>
           </table></td>
         </tr>
       </table>
      {{-- Links de portadas--}}
        @foreach($linksAllowed as $tableNumber => $links)
              <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                  <tr style="border-collapse:collapse">
                      <td class="es-adaptive" align="center" style="padding:0;Margin:0">
                          <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:{{ $linksBgColor }};width:600px" cellspacing="0" cellpadding="0" bgcolor="{{ $linksBgColor }}" align="center">
                              <tr style="border-collapse:collapse">
                                  <td align="left" bgcolor="{{ $linksBgColor }}" style="padding:5px;Margin:0;background-color:{{ $linksBgColor }}"><!--[if mso]><table style="width:590px" cellpadding="0" cellspacing="0"><tr><td style="width:285px" valign="top"><![endif]-->
                                      @foreach($links as $slug => $link)
                                          <table cellspacing="0" cellpadding="0" align="left" class="es-left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                                              <tr style="border-collapse:collapse">
                                                  <td class="es-m-p20b" valign="top" align="center" style="padding:0;Margin:0;width:285px">
                                                      <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                          <tr style="border-collapse:collapse">
                                                              <td align="left" style="padding:0;Margin:0;padding-left:10px">
                                                                  <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:21px;color:{{ $linksButtonTextColor }};font-size:14px">
                                                                      <a href="{{ $link }}" target="_blank" style="text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:{{ $linksButtonTextColor }};font-size:14px">
                                                                          ➜ <strong>{{ $covers->where('slug', $slug)->first()->name }}</strong>
                                                                      </a>
                                                                  </p>
                                                              </td>
                                                          </tr>
                                                      </table>
                                                  </td>
                                              </tr>
                                          </table><!--[if mso]></td><td style="width:20px"></td><td style="width:285px" valign="top"><![endif]-->
                                      @endforeach
                                  </td>
                              </tr>
                          </table>
                      </td>
                  </tr>
              </table>
       @endforeach
      {{-- Comienzan las noticias--}}
          @php
              $countIteratorThemes = 1;
              $isEvent = false;
          @endphp
      @foreach ($newsletterSend->newsletter->company->themes as $theme)
            <table class="es-content es-visible-simple-html-only" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                <tr style="border-collapse:collapse">
                  <td align="center" style="padding:0;Margin:0">
                   <table class="es-content-body" cellspacing="0" cellpadding="0" bgcolor="{{ $mainBgColor }}" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:{{ $mainBgColor }};width:600px">
                    @if($newsletterSend->newsletter_theme_news->where('newsletter_theme_id', $theme->id)->count())
                        <tr style="border-collapse:collapse">
                            <td align="left" {{ ($countIteratorThemes % 2) == 0 ? 'bgcolor='.$themeBgColor : '' }} style="padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px;{{ ($countIteratorThemes % 2) == 0 ? 'background-color:'.$themeBgColor : '' }}">
                                <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                    <tr style="border-collapse:collapse">
                                        <td valign="top" align="center" style="padding:0;Margin:0;width:560px">
                                            <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-position:left top" width="100%" cellspacing="0" cellpadding="0" role="presentation">
                                                <tr style="border-collapse:collapse">
                                                    <td align="left" style="padding:0;Margin:0;padding-left:15px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:20px;color:{{ $themeTextColor }};font-size:13px"><strong>{{ strtoupper($theme->name) }}</strong></p></td>
                                                </tr>
                                                <tr style="border-collapse:collapse">
                                                    <td align="center" style="Margin:0;padding-top:5px;padding-bottom:15px;padding-left:15px;padding-right:15px;font-size:0">
                                                       <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                         <tr style="border-collapse:collapse">
                                                          <td style="padding:0;Margin:0;border-bottom:2px solid {{ $themeBorderColor }};background:unset;height:1px;width:100%;margin:0px"></td>
                                                         </tr>
                                                       </table>
                                                    </td>
                                                </tr>
                                            </table></td>
                                    </tr>
                                </table></td>
                        </tr>
                       @php
                           if($countIteratorThemes % 2 == 0){
                               $isEvent = true;
                           }
                           $countIteratorThemes ++;
                       @endphp
                    @endif
                    @foreach ($newsletterSend->newsletter_theme_news as $note)
                        @if($note->theme->id == $theme->id)
                         <tr style="border-collapse:collapse">
                          <td align="left" {{ ($isEvent) ? 'bgcolor='.$newsBgColor : '' }} style="padding:0;Margin:0;padding-top:5px;padding-left:20px;padding-right:20px;{{ ($isEvent) ? 'background-color:'.$newsBgColor : '' }}">
                           <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                             <tr style="border-collapse:collapse">
                              <td align="center" valign="top" style="padding:0;Margin:0;width:560px">
                               <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                 <tr style="border-collapse:collapse">
                                     <td class="es-m-txt-c" align="left" style="padding:0;Margin:0;padding-bottom:5px;padding-top:10px"><a target="_blank" style="text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:{{ $newsTitleColor }};font-size:14px" href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}"><h2 class="name" style="Margin:0;line-height:16px;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;font-size:16px;font-style:normal;font-weight:bold;color:{{ $newsTitleColor }}">{{ $note->news->title }}</h2></a></td>
                                 </tr>
                                 <tr style="border-collapse:collapse">
                                  <td class="es-m-txt-c" align="left" style="padding:0;Margin:0;padding-top:5px;padding-right:5px;padding-bottom:20px"><p class="title2" style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:18px;color:{{ $newsTextColor }};font-size:12px"> {!! $note->news->synthesis !!} ({{ $note->news->news_date->format('d-m-Y') }})</p></td>
                                 </tr>
                                 <tr style="border-collapse:collapse">
                                  <td class="es-m-txt-c" align="left" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:21px;color:{{ $newsTextColor }};font-size:14px"><a target="_blank" style="text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:{{ $newsTextColor }};font-size:14px" href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}">{{ $note->news->mean->name }}, <strong>{{ $note->news->source->name ?? 'N/E' }}</strong>, {{ $note->news->author }}</a></p></td>
                                 </tr>
                                 <tr style="border-collapse:collapse">
                                  <td align="center" style="padding:20px;Margin:0;font-size:0">
                                   <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                     <tr style="border-collapse:collapse">
                                      <td style="padding:0;Margin:0;border-bottom:1px solid {{ $newsBorderColor }};background:unset;height:1px;width:100%;margin:0px"></td>
                                     </tr>
                                   </table></td>
                                 </tr>
                               </table></td>
                             </tr>
                           </table></td>
                         </tr>
                        @endif
                    @endforeach
                   @php
                        $isEvent = false;
                   @endphp
                   </table></td>
                </tr>
            </table>
      @endforeach
       <table class="es-content es-visible-simple-html-only" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
         <tr style="border-collapse:collapse">
          <td align="center" style="padding:0;Margin:0">
           <table class="es-content-body" cellspacing="0" cellpadding="0" bgcolor="{{ $footerBgColor }}" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:{{ $footerBgColor }};width:600px">
             <tr style="border-collapse:collapse">
              <td align="left" bgcolor="{{ $footerBgColor }}" style="padding:0;Margin:0;padding-top:10px;padding-left:20px;padding-right:20px;background-color:{{ $footerBgColor }}">
               <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                 <tr style="border-collapse:collapse">
                  <td align="center" valign="top" style="padding:0;Margin:0;width:560px">
                   <table cellpadding="0" cellspacing="0" width="100%" bgcolor="{{ $footerBgColor }}" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:{{ $footerBgColor }}" role="presentation">
                     <tr style="border-collapse:collapse">
                      <td align="left" style="padding:0;Margin:0">
                          <p style="padding: 20px  0 20px 0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:21px;color:{{ $footerTextColor }};font-size:14px; text-align: center; font-weight: bold;">
                              Newsletter - Opemedios {{ date('Y') }}
                          </p>
                      </td>
                         {{--<td colspan="2" bgcolor="{{ $footerBgColor }}" style="padding: 30px  0 30px 0;background-color: {{ $footerBgColor }};">
                             <p style="color: {{ $footerTextColor }};text-decoration: none;">Newsletter - Opemedios {{ date('Y') }}</p>
                         </td> --}}
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
