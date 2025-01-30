<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Newsletter Opemedios</title>
  @php
    $day = date('Y-m-d H:i:s');

    $colorsConfig = unserialize($newsletterSend->newsletter->colors);

    $bodyBgColor = isset($colorsConfig['body_bg']) ? $colorsConfig['body_bg'] : "#f4f4f4";

    $mainBgColor = isset($colorsConfig['main_bg']) ? $colorsConfig['main_bg'] : "#ffffff";
    $mainBorderColor = isset($colorsConfig['main_border']) ? $colorsConfig['main_border'] : "#dddddd";

    $linksBgColor = isset($colorsConfig['links_bg']) ? $colorsConfig['links_bg'] : "#007bff";
    $linksButtonTextColor = isset($colorsConfig['links_button_text']) ? $colorsConfig['links_button_text'] : "#ffffff";

    $dateTextColor = isset($colorsConfig['date_text']) ? $colorsConfig['date_text'] : "#666666";

    $themeTextColor = isset($colorsConfig['theme_text']) ? $colorsConfig['theme_text'] : "#000000";

    $newsBgColor = isset($colorsConfig['news_bg']) ? $colorsConfig['news_bg'] : "#f9f9f9";
    $newsBorderColor = isset($colorsConfig['news_border']) ? $colorsConfig['news_border'] : "#eeeeee";
    $newsTitleColor = isset($colorsConfig['news_title']) ? $colorsConfig['news_title'] : "#007bff";
    $newsTextColor = isset($colorsConfig['news_text']) ? $colorsConfig['news_text'] : "#222222";

    $newsButtonBgColor = isset($colorsConfig['news_button_bg']) ? $colorsConfig['news_button_bg'] : "#007bff";
    $newsButtonBorderColor = isset($colorsConfig['news_button_border']) ? $colorsConfig['news_button_border'] : "#007bff";
    $newsButtonTextColor = isset($colorsConfig['news_button_text']) ? $colorsConfig['news_button_text'] : "#ffffff";

    $footerBgColor = isset($colorsConfig['footer_bg']) ? $colorsConfig['footer_bg'] : "#f4f4f4";
    $footerTextColor = isset($colorsConfig['footer_text']) ? $colorsConfig['footer_text'] : "#777777";
  @endphp
  <style>
    /* Reset styles for email clients */
    body, table, td, a {
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
    }
    table, td {
      mso-table-lspace: 0pt;
      mso-table-rspace: 0pt;
    }
    img {
      -ms-interpolation-mode: bicubic;
      border: 0;
      height: auto;
      line-height: 100%;
      outline: none;
      text-decoration: none;
    }
    /* General styles */
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background-color: {{ $bodyBgColor  }};
    }
    .email-container {
      max-width: 600px;
      margin: 0 auto;
      background-color: {{ $mainBgColor }};
      border-radius: 8px;
      overflow: hidden;
      border-width: 1px;
      border-style: solid;
      border-color: {{ $mainBorderColor }};
    }
    .header-image {
      text-align: center;
    }
    .header-image img {
      width: 100%;
      height: auto;
      display: block;
      margin: 0 0 0 0;
      padding: 0 0 0 0;
    }
    .content {
      padding: 20px;
    }
    .grid-links {
      text-align: center;
      padding: 15px 0;
      background: {{ $linksBgColor }};
    }
    .link-container {
      padding: 5px 0px 5px 0px;
    }
    .grid-links a {
      display: inline-block;
      margin: 0 10px;
      color: {{ $linksButtonTextColor }};
      text-decoration: none;
      font-size: 14px;
      font-weight: bold;
    }
    .date {
      font-size: 12px;
      color: {{ $dateTextColor }};
      margin-bottom: 20px;
      text-align: center;
    }
    .title {
      font-size: 19px;
      font-weight: bold;
      color: {{ $themeTextColor }};
      margin-bottom: 30px;
      text-align: center;
      line-height: 30px;
    }
    .article {
      margin-bottom: 30px;
      padding: 15px;
      background-color: {{ $newsBgColor }};
      border-radius: 5px;
      border-width: 1px;
      border-style: solid;
      border-color: {{ $newsBorderColor }};
    }
    .article-title {
      font-size: 17px;
      font-weight: bold;
      color: {{ $newsTitleColor }};
      margin-bottom: 15px;
      line-height: 25px;
    }
    .article-title a {
      color: {{ $newsTitleColor }};
      text-decoration: none;
    }
    .fuente{
      font-weight: bold;
    }
    .article-source {
      font-size: 14px;
      color: {{ $newsTextColor }};
      opacity: 0.7;
      margin-bottom: 15px;
      line-height: 20px;
    }
    .article-source a {
      color: {{ $newsTextColor }};
    }
    .article-summary {
      font-size: 15px;
      color: {{ $newsTextColor }};
      margin-bottom: 20px;
      line-height: 24px;
    }
    .link-article{
      background-color:{{ $newsButtonBgColor }};
      padding:5px 10px 5px 10px;
      border: 1px;
      border-style: solid;
      border-color: {{ $newsButtonBorderColor }};
    }
    .article-button {
      display: inline-block;
      background-color: {{ $newsButtonBgColor }};
      color: {{ $newsButtonTextColor }};
      text-decoration: none;
      font-size: 14px;
      padding: 5px 7px 5px 7px;
    }
    .footer {
      text-align: center;
      padding: 20px;
      background-color: {{ $footerBgColor }};
      font-size: 12px;
      color: {{ $footerTextColor }};
    }
    .footer a {
      color: {{ $footerTextColor }};
    }
  </style>
</head>
<body>
  <table class="email-container" width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
      <td class="grid-links">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
          @foreach ($linksAllowed as $key => $link)
            @if ($loop->odd)
                <tr>
                    <td class="link-container">
                        <a href="{{ $link }}">
                            {{ $covers->where('slug', $key)->first()->name }}
                        </a>
                    </td>
            @else
                    <td class="link-container">
                        <a href="{{ $link }}">
                            {{ $covers->where('slug', $key)->first()->name }}
                        </a>
                    </td>
                </tr>
            @endif
            @if ($loop->last && $loop->odd)
                    <td class="link-container">
                    </td> 
                </tr>
            @endif
          @endforeach
        </table>
      </td>
    </tr>

    <tr>
      <td class="header-image">
        <img src="{{ asset("images/{$newsletterSend->newsletter->banner}") }}" alt="{{ $newsletterSend->newsletter->name ?? 'N/E' }}">
      </td>
    </tr>

    <tr>
      <td class="content">
        <div class="date">{{ Illuminate\Support\Carbon::parse($day)->formatLocalized('%A %d de %B %Y') }}</div>

        @foreach ($newsletterSend->newsletter->company->themes as $theme)
          @if($newsletterSend->newsletter_theme_news->where('newsletter_theme_id', $theme->id)->count())
            <div class="title">{{ strtoupper($theme->name) }}</div>
          @endif

          @foreach ($newsletterSend->newsletter_theme_news as $note)
            @if($note->theme->id == $theme->id)
              <div class="article">
                <div class="article-title">
                  <a href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}">
                    {{ strtoupper($note->news->title) }}
                  </a>
                </div>
                <div class="article-source"><span class="fuente">Fuente:&lowbar;&nbsp;</span> {{ $note->news->mean->name ?? 'N/E' }} / {{ $note->news->source->name ?? 'N/E' }}, {{ $note->news->author }}</div>
                <div class="article-summary">{!! $note->news->synthesis !!}</div>
                <table>
                  <tr>
                    <td class="link-article">
                      <a href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}" class="article-button">Ir a nota</a>
                    </td>
                  </tr>
                </table>
              </div>
            @endif
          @endforeach
        @endforeach

      </td>
    </tr>

    <!-- Footer -->
    <tr>
      <td class="footer">
        Newsletter <a href="https://opemedios.com.mx" class="link-footer">Opemedios</a> {{ date('Y') }}.
      </td>
    </tr>
  </table>
</body>
</html>