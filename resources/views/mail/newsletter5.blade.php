<html xmlns="http://www.w3.org/TR/REC-html40" xmlns:m="http://schemas.microsoft.com/office/2004/12/omml" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        News Openpay, {{ Illuminate\Support\Carbon::parse($newsletterSend->date_sending)
            ->formatLocalized('%A %d de %B %Y') }}
    </title>
    <meta http-equiv="Content-Type" content="text/html; ">
    <style>a[x-apple-data-detectors]{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}u+#body a{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}#MessageViewBody a{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}:root{color-scheme:light dark;supported-color-schemes:light dark;}tr{vertical-align:middle;}p,a,li{mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;}p:first-child{margin-top:0!important;}p:last-child{margin-bottom:0!important;}a{text-decoration:underline;color:inherit;}@media only screen and (max-width:599px){.full-width-mobile{width:100%!important;height:auto!important;}.mobile-padding{padding-left:10px!important;padding-right:10px!important;}.mobile-stack{display:block!important;width:100%!important;}}
    </style>
    @php
      $day = date('Y-m-d H:i:s');

      $colorsConfig = unserialize($newsletterSend->newsletter->colors);

      $bodyBgColor = isset($colorsConfig['body_bg']) ? $colorsConfig['body_bg'] : "#ffffff";

      $mainBgColor = isset($colorsConfig['main_bg']) ? $colorsConfig['main_bg'] : "#ffffff";

      $linksButtonTextColor = isset($colorsConfig['links_button_text']) ? $colorsConfig['links_button_text'] : "#013B76";

      $dateBgColor = isset($colorsConfig['date_bg']) ? $colorsConfig['date_bg'] : "#ffffff";
      $dateTextColor = isset($colorsConfig['date_text']) ? $colorsConfig['date_text'] : "#000000";

      $themeBgColor = isset($colorsConfig['theme_bg']) ? $colorsConfig['theme_bg'] : "#013B76";
      $themeBorderColor = isset($colorsConfig['theme_border']) ? $colorsConfig['theme_border'] : "#013B76";
      $themeTextColor = isset($colorsConfig['theme_text']) ? $colorsConfig['theme_text'] : "#ffffff";

      $newsBorderColor = isset($colorsConfig['news_border']) ? $colorsConfig['news_border'] : "#444444";
      $newsTitleColor = isset($colorsConfig['news_title']) ? $colorsConfig['news_title'] : "#000000";
      $newsTextColor = isset($colorsConfig['news_text']) ? $colorsConfig['news_text'] : "#222222";
  @endphp
</head>
<body style="padding:0px 0px 0px 0px; margin:0px 0px 0px 0px;background-color:{{ $bodyBgColor }};">
    <table align="center" style="width:100%;max-width:600px;background:white;margin:0 auto 0 auto;background-color:{{ $mainBgColor }};" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td style="padding:0px 0px 0px 0px;">
                <table cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td valign="top" style="text-align:center;width:60%;">
                            <img src="{{ asset("images/{$newsletterSend->newsletter->banner}") }}" alt="{{ $newsletterSend->newsletter->name }}" style="width: 100%; display: block;">
                        </td>
                        <td style="width:40%;padding:0px 20px 0px 20px;background:{{ $dateBgColor }};">
                            <p style="text-align:right;font-size:13px;color:{{ $dateTextColor }};line-height:16px;">
                                {{-- Fecha del newsletter--}}
                                {{ Illuminate\Support\Carbon::parse(
                                      $newsletterSend->date_sending
                                    )->formatLocalized('%A %d de %B %Y')
                                }}
                            </p>
                        </td>
                    </tr>
                </table>
                <table cellspacing="0" cellpadding="0" border="0">
                    <tr>
                      <td style="background:{{ $mainBgColor }};padding:0px 0px 0px 0px" valign="top">
                        @foreach ($newsletterSend->newsletter->company->themes as $theme)
                          @if($newsletterSend->newsletter_theme_news->where('newsletter_theme_id', $theme->id)->count())
                            <table style="width:100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                  <td bgcolor="{{ $themeBgColor }}" style="width: 95%;background:{{ $themeBgColor }};padding:15px 20px 15px 20px;">
                                    <p style="color:{{ $themeTextColor }};text-decoration:none;font-weight:bold;">
                                      <a href="#" style="color:{{ $themeTextColor }};text-decoration:none;font-weight:bold;">
                                            {{ strtoupper($theme->name) }}
                                      </a>
                                    </p>
                                  </td>
                                  <td bgcolor="{{ $themeBgColor }}" style="width:5.0%;background:{{ $themeBgColor }};padding:0px 0px 0px 0px;">
                                    <p style="text-align:center" align="center">
                                        <a href="javascript:void(0);" title="Subir" style="text-decoration:none;color:{{ $themeTextColor }};">
                                            <span style="font-size:16px;font-family:'Arial',sans-serif;color:{{ $themeTextColor }};text-decoration:none">
                                              &nbsp;&nbsp;&nbsp;▲&nbsp;&nbsp;&nbsp;
                                            </span>
                                        </a>
                                    </p>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="padding:10px 20px 10px 20px;">
                                    <table>
                                        <tr>
                                            <td style="border-width: 1px; border-style: solid; border-color:{{ $themeBorderColor }}; padding: 2px 10px 2px 10px;">
                                                <p style="font-size: 12px;color:{{ $newsTextColor }}">
                                                    @php
                                                      $countNotes = $newsletterSend
                                                        ->newsletter_theme_news->where('newsletter_theme_id', $theme->id)
                                                        ->count();
                                                    @endphp
                                                    {{ "Noticias encontradas: {$countNotes}" }}
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                  </td>
                                </tr>
                            </table>
                          @endif
                          @foreach ($newsletterSend->newsletter_theme_news as $note)
                            @if($note->theme->id == $theme->id)
                              <table style="width:100%" cellspacing="0" cellpadding="0" border="0" align="left">
                                  <tr>
                                    <td style="padding:0px 20px 30px 20px;">
                                        <table>
                                            <tr>
                                                <td style="padding-bottom:15px;border-top:1px solid {{ $newsBorderColor }};padding-top: 20px;">
                                                    <a href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}" style="text-decoration:none;">
                                                        <b>
                                                            <span style="font-size:16px;color:{{ $newsTitleColor }};text-decoration:none;">
                                                            {{ $note->news->title }}
                                                            </span>
                                                        </b>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-bottom:15px;">
                                                    <p style="font-size:12px;color:{{ $newsTextColor }}">
                                                      {{ $note->news->news_date->format('d/m/Y') }} &nbsp;
                                                      <a href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}" target="_blank" style="color:{{ $newsTextColor }}">
                                                        <span style="text-decoration:none;color:{{ $newsTextColor }}">»
                                                          {{ $note->news->source->name ?? 'N/E' }}
                                                        </span>
                                                      </a>,
                                                      &nbsp;{{ $note->news->author }}
                                                      <br>
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p style="font-size:14px;color:{{ $newsTextColor }}">
                                                      @php
                                                        $news_metas = unserialize($note->news->metas_news);
                                                        $noteUrl = '';
                                                        if($note->news->mean->short_name == 'int') {
                                                          $noteUrl = $news_metas['url'];
                                                        }
                                                      @endphp
                                                      {!! $note->news->synthesis !!} &nbsp;{!! $noteUrl !!}
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                  </tr>
                              </table>
                            @endif
                          @endforeach
                        @endforeach

                            <table style="width:100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td bgcolor="{{ $themeBgColor }}" style="background:{{ $themeBgColor }};padding:15px 20px 15px 20px">
                                      <p>
                                        <b>
                                          <span style="font-size:14px;color:{{ $themeTextColor }}">
                                            &nbsp;PRIMERAS PLANAS
                                          </span>
                                        </b>
                                      </p>
                                    </td>
                                </tr>
                            </table>

                            <table style="width:100%;text-align:center;padding:10px 15px 10px 15px;" cellspacing="0" cellpadding="0" border="0">
                              @foreach ($linksAllowed as $key => $link)
                                @if ($loop->odd)
                                  <tr>
                                    <td style="padding:5px 0px 5px 0px;">
                                      <a href="{{ $link }}" style="font-weight:normal;color:{{ $linksButtonTextColor }};mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;font-size:14px;margin-top:0!important;margin-bottom:0!important;">
                                        {{ $covers->where('slug', $key)->first()->name }}
                                      </a>
                                    </td>
                                @else
                                    <td style="padding:5px 0px 5px 0px;">
                                      <a href="{{ $link }}" style="font-weight:normal;color:{{ $linksButtonTextColor }};mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;font-size:14px;margin-top:0!important;margin-bottom:0!important;">
                                        {{ $covers->where('slug', $key)->first()->name }}
                                      </a>
                                    </td> 
                                  </tr>
                                @endif
                                @if ($loop->last && $loop->odd)
                                    <td style="padding:5px 0px 5px 0px;">
                                    </td> 
                                  </tr>
                                @endif
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
