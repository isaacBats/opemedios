<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" style="width:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Newsletter Opemedios</title>
	<style>a[x-apple-data-detectors]{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}u+#body a{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}#MessageViewBody a{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}:root{color-scheme:light dark;supported-color-schemes:light dark;}tr{vertical-align:middle;}p,a,li{mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;}p:first-child{margin-top:0!important;}p:last-child{margin-bottom:0!important;}a{text-decoration:underline;color:inherit;}@media only screen and (max-width:599px){.full-width-mobile{width:100%!important;height:auto!important;}.mobile-padding{padding-left:10px!important;padding-right:10px!important;}.mobile-stack{display:block!important;width:100%!important;}}
    </style>
    @php
        $day = date('Y-m-d H:i:s');

        $colorsConfig = unserialize($newsletterSend->newsletter->colors);

        $bodyBgColor = isset($colorsConfig['body_bg']) ? $colorsConfig['body_bg'] : "#E8EAF6";

        $mainBgColor = isset($colorsConfig['main_bg']) ? $colorsConfig['main_bg'] : "#ffffff";

        $linksBgColor = isset($colorsConfig['links_bg']) ? $colorsConfig['links_bg'] : "#283593";
        $linksButtonTextColor = isset($colorsConfig['links_button_text']) ? $colorsConfig['links_button_text'] : "#ffffff";

        $dateBgColor = isset($colorsConfig['date_bg']) ? $colorsConfig['date_bg'] : "#283593";
        $dateTextColor = isset($colorsConfig['date_text']) ? $colorsConfig['date_text'] : "#ffffff";

        $themeBgColor = isset($colorsConfig['theme_bg']) ? $colorsConfig['theme_bg'] : "#283593";
        $themeTextColor = isset($colorsConfig['theme_text']) ? $colorsConfig['theme_text'] : "#283593";

        $newsTitleColor = isset($colorsConfig['news_title']) ? $colorsConfig['news_title'] : "#283593";
        $newsTextColor = isset($colorsConfig['news_text']) ? $colorsConfig['news_text'] : "#283593";

        $footerBgColor = isset($colorsConfig['footer_bg']) ? $colorsConfig['footer_bg'] : "#283593";
        $footerTextColor = isset($colorsConfig['footer_text']) ? $colorsConfig['footer_text'] : "#ffffff";
    @endphp
</head>
<body style="background-color:{{ $bodyBgColor }};font-family:Arial,Helvetica,sans-serif;padding:0px 0px 0px 0px;margin:0px 0px 0px 0px;">
<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;border-collapse: collapse; max-width: 580px; margin: 0 auto 0 auto;background-color:{{ $mainBgColor }};">
	<tr>
		<td>
			<table border="0" cellpadding="0" cellspacing="0" align="center" style="max-width: 580px;width:100%;background-color:{{ $dateBgColor }};padding:20px 20px 20px 20px;border:0;border-collapse:collapse;color:{{ $dateTextColor }};">
				<tr>
					<td bgcolor="{{ $dateBgColor }}" style="background-color:{{ $dateBgColor }};color:{{ $dateTextColor }};text-align:right;font-size:12px;padding:20px 30px 20px 0;font-weight:bold;">
						{{ Illuminate\Support\Carbon::parse($day)->formatLocalized('%A %d de %B %Y') }}
					</td>
				</tr>
			</table>
			<table border="0" cellpadding="0" cellspacing="0" align="center" style="max-width: 580px;width:100%;padding: 0;border: 0;border-collapse: collapse;background-color: #ffffff;">
				<tr>
					<td style="text-align: center;">
						<img src="{{ asset("images/{$newsletterSend->newsletter->banner}") }}" alt="{{ $newsletterSend->newsletter->name }}" style="width: 100%; max-width: 580px; height: auto; display: block;">
					</td>
				</tr>
			</table>
			<table border="0" cellpadding="0" cellspacing="0" align="center" style="max-width:580px;width:100%;padding:0 0 0 0;border:0;background-color:{{ $mainBgColor }};">
                <tr valign="top" style="font-size: 14px;line-height: 24px;">
                    <td bgcolor="{{ $linksBgColor }}" style="padding:10px 15px 10px 15px;background-color:{{ $linksBgColor }};width:100%;">
                        <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="400" style="border-collapse:collapse;max-width:400px;width:100%;background-color:{{ $linksBgColor }};text-align:left;">
                            @foreach ($linksAllowed as $key => $link)
                                @if ($loop->odd)
                                    <tr>
                                    	<td style="color:{{ $linksButtonTextColor }};width: 15px;">&#9656;</td>
                                        <td style="padding:5px 0px 5px 0px;">
                                            <a href="{{ $link }}" style="font-weight:normal;color:{{ $linksButtonTextColor }};mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;font-size:14px;margin-top:0!important;margin-bottom:0!important;text-decoration:none;">
                                                {{ $covers->where('slug', $key)->first()->name }}
                                            </a>
                                        </td>
                                    @if ($loop->last)
	                                		<td style="width: 15px;"></td>
	                                        <td style="padding:5px 0px 5px 0px;">
	                                        </td> 
	                                    </tr>
                                	@endif
                                @else
                                        <td style="color:{{ $linksButtonTextColor }};width: 15px;">&#9656;</td>
                                        <td style="padding:5px 0px 5px 0px;">
                                            <a href="{{ $link }}" style="font-weight:normal;color:{{ $linksButtonTextColor }};mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;font-size:14px;margin-top:0!important;margin-bottom:0!important;text-decoration:none;">
                                                {{ $covers->where('slug', $key)->first()->name }}
                                            </a>
                                        </td> 
                                    </tr>
                                @endif
                            @endforeach
						</table>
                    </td>
                </tr>
				@foreach ($newsletterSend->newsletter->company->themes as $theme)
					@if($newsletterSend->newsletter_theme_news->where('newsletter_theme_id', $theme->id)->count())
						<tr>
							<td colspan="2" style="padding-top: 30px;"></td>
						</tr>
						<tr>
							<td colspan="2" style="padding:10px 0px 30px 0;">
								<table border="0" cellpadding="0" cellspacing="0" style="max-width:580px;width:100%;border:0;">
									<tr>
										<td bgcolor="{{ $themeBorderColor }}" style="width:20px;background-color:{{ $themeBgColor }};"></td>
										<td style="padding-left:10px;padding-right:30px;font-size:16px;color:{{ $themeTextColor }};">
											{{ strtoupper($theme->name) }}
										</td>
									</tr>
								</table>
							</td>
						</tr>
					@endif

					@foreach ($newsletterSend->newsletter_theme_news as $note)
						@if($note->theme->id == $theme->id)
							<tr>
								<td colspan="2" style="padding: 10px 30px 20px 30px;">
									<a href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}" style="font-size:18px;color:{{ $newsTitleColor }};text-decoration:none;" target="_blank">
										{{ strtoupper($note->news->title) }}
									</a>
									<p style="color:{{ $newsTextColor }};font-size:14px;margin:0;margin-top:10px;margin-bottom:10px;line-height:20px;">
										{!! $note->news->synthesis !!}
									</p>
									<p style="font-size:13px;margin-bottom:20px;margin-top:5px;color:{{ $newsTextColor }};">
										{{ $note->news->mean->name }} / {{ $note->news->source->name }}, {{ $note->news->author }}
									</p>
								</td>
							</tr>
						@endif
					@endforeach
				@endforeach

				<!-- start footer -->
				<tr>
					<td colspan="2" style="padding-top: 20px;"></td>
				</tr>
				<tr valign="top">
                    <td colspan="2" bgcolor="{{ $footerBgColor }}" style="padding:30px 0 30px 0;background-color:{{ $footerBgColor }};">
                        <p style="text-align:center;line-height:24px;font-size:14px;color:{{ $footerTextColor }};text-decoration:none;">Newsletter - Opemedios {{ date('Y') }}</p>
                    </td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
