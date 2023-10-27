<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" style="width:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
@php
    $colorsConfig = unserialize($newsletterSend->newsletter->colors);
    $bgPrimary = isset($colorsConfig['bg_primary']) ? $colorsConfig['bg_primary'] : "#ffffff";
    $bgCovers = isset($colorsConfig['bg_covers']) ? $colorsConfig['bg_covers'] : "#283593";
    $bgFontCovers = isset($colorsConfig['bg_font_covers']) ? $colorsConfig['bg_font_covers'] : "#ffffff";
    $bgTitleSecond = isset($colorsConfig['bg_title_second']) ? $colorsConfig['bg_title_second'] : "#283593";
    $bgBodyThemeSecond = isset($colorsConfig['bg_body_theme_second']) ? $colorsConfig['bg_body_theme_second'] : "#263238";
    $linksAllowed = array_chunk($linksAllowed, 3, true);
@endphp
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Newsletter Opemedios</title>
	<style type="text/css">
		body, table, td, a{-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;} /* Prevent WebKit and Windows mobile changing default text sizes */
	    table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt;} /* Remove spacing between tables in Outlook 2007 and up */
	    img{-ms-interpolation-mode: bicubic;} /* Allow smoother rendering of resized image in Internet Explorer */
	    /* RESET STYLES */
	    img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;}
	    table{border-collapse: collapse !important;}
	    body{height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important;}
	    /* iOS BLUE LINKS */
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
<body style="background-color: #E8EAF6;font-family: Arial, Helvetica, sans-serif;">
<table  style="width: 100%;border-collapse: collapse;">
	<tr>
		<td>
			<table align="center" style="width: 580px;background-color: #ffffff;padding: 20px;border: 0;border-collapse: collapse;color: #263238;">
				<tr>
					<td bgcolor="{{ $bgCovers }}" style="background-color: {{ $bgCovers }};color: {{ $bgFontCovers }};text-align: right;font-size: 12px;padding: 20px 20px 20px 0; font-weight: bold;">
						@php
                            $day = date('Y-m-d H:i:s');
                        @endphp
                        {{ Illuminate\Support\Carbon::parse($day)->formatLocalized('%A %d de %B %Y') }}
					</td>
				</tr>
			</table>
			<table align="center" style="width: 580px;padding: 0;border: 0;border-collapse: collapse;background-color: #ffffff;">
				<tr>
					<td>
						<img src="{{ asset("images/{$newsletterSend->newsletter->banner}") }}" alt="{{ $newsletterSend->newsletter->name }}" style="width: 100%;height: auto;">
					</td>
				</tr>
			</table>
			<table align="center" style="width: 580px;padding: 0;border: 0;border-collapse: collapse;background-color: {{ $bgPrimary }};margin-bottom: 100px;">
                <tr valign="top" style="font-size: 14px;line-height: 24px;border-top: 1px solid #E3F2FD;">
                    @foreach($linksAllowed as $tableNumber => $links)
                        <td bgcolor="{{ $bgCovers }}" style="padding: 30px  0 30px 60px;background-color: {{ $bgCovers }};">
                            @foreach($links as $slug => $link)
                                <a href="{{ $link }}" style="color: {{ $bgFontCovers }};text-decoration: none;">&#9656; {{ $covers->where('slug', $slug)->first()->name }}</a><br>
                            @endforeach
                        </td>
                    @endforeach
                </tr>
				<tr>
					<td colspan="2" style="padding: 20px;">
					</td>
				</tr>
				@foreach ($newsletterSend->newsletter->company->themes as $theme)
					@if($newsletterSend->newsletter_theme_news->where('newsletter_theme_id', $theme->id)->count())
						<tr>
							<td colspan="2">
								<table style="width: 580px;border: 0;border-collapse: collapse;">
									<tr>
										<td bgcolor="{{ $bgTitleSecond }}" style="width: 20px;background-color: {{ $bgTitleSecond }};"></td>
										<td style="padding-left: 10px;font-size: 16px;color: {{ $bgTitleSecond }};">
											{{ strtoupper($theme->name) }}
										</td>
									</tr>
									<tr>
										<td colspan="2" style="padding: 15px;"></td>
									</tr>
								</table>
							</td>
						</tr>
					@endif
					@foreach ($newsletterSend->newsletter_theme_news as $note)
						@if($note->theme->id == $theme->id)
						<tr>
							<td colspan="2" style="padding: 10px 30px;">
								<a href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}" style="font-size: 18px;color: {{ $bgBodyThemeSecond }};text-decoration: none;" target="_blank">{{ strtoupper($note->news->title) }}</a>
								<p style="color: {{ $bgBodyThemeSecond }};font-size: 14px;margin: 0;margin-top: 10px;margin-bottom: 10px; line-height: 20px;">{!! $note->news->synthesis !!} </p>
								<p style="font-size: 12px;margin-bottom: 20px;margin-top: 5px;color: {{ $bgBodyThemeSecond }};"> {{ $note->news->mean->name }} / {{ $note->news->source->name }}, {{ $note->news->author }}</p>
							</td>
						</tr>
                        <tr>
                            <td colspan="2" style="padding: 12px;"></td>
                        </tr>
						@endif
					@endforeach
				@endforeach
				<!-- start footer -->
				<tr valign="top" style="text-align: center; font-size: 14px;line-height: 24px;border-top: 1px solid #E3F2FD;">
                    <td colspan="2" bgcolor="{{ $bgCovers }}" style="padding: 30px  0 30px 0;background-color: {{ $bgCovers }};">
                        <p style="color: {{ $bgFontCovers }};text-decoration: none;">Newsletter - Opemedios {{ date('Y') }}</p>
                    </td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
