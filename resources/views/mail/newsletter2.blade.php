<!DOCTYPE html>
<html>
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
					<td style="padding: 20px 0 20px 20px;">
						{{-- <img src="" width="150px"> --}}
					</td>
					<td style="text-align: right;font-size: 12px;padding: 20px 20px 20px 0; font-weight: bold;">
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
			<table align="center" style="width: 580px;padding: 0;border: 0;border-collapse: collapse;background-color: #ffffff;margin-bottom: 100px;">
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
										<td style="width: 20px;background-color: #283593;"></td>
										<td style="padding-left: 10px;font-size: 16px;color: #283593;">
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
								<a href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}" style="font-size: 18px;color: #1976D2;text-decoration: none;" target="_blank">{{ strtoupper($note->news->title) }}</a>
								<p style="color: #263238;font-size: 14px;margin: 0;margin-top: 10px;margin-bottom: 10px; line-height: 20px;">{!! $note->news->synthesis !!} </p>
								<p style="font-size: 12px;margin-bottom: 20px;margin-top: 5px;color: #546E7A;"> {{ $note->news->mean->name }} / {{ $note->news->source->name }}, {{ $note->news->author }}</p>
							</td>
						</tr>
						@endif
					@endforeach
					<tr>
						<td colspan="2" style="padding: 12px;"></td>
					</tr>
				@endforeach
				<!-- start footer -->
				<tr valign="top" style="font-size: 14px;line-height: 24px;border-top: 1px solid #E3F2FD;background-color: #283593;color: #ffffff;">
					<td style="padding: 30px  0 30px 60px;">
						&#9656; &nbsp; <a href="{{ $covers['primeras_planas'] }}" style="color: #ffffff;text-decoration: none;">Primeras Planas</a><br>
						&#9656; &nbsp; <a href="{{ $covers['portadas_financieras'] }}" style="color: #ffffff;text-decoration: none;">Portadas Financieras</a><br>
						&#9656; &nbsp; <a href="{{ $covers['cartones'] }}" style="color: #ffffff;text-decoration: none;">Cartones</a>
					</td>
					<td style="padding: 30px  60px 30px 0;">
						&#9656; &nbsp; <a href="{{ $covers['columnas_financieras'] }}" style="color: #ffffff;text-decoration: none;">Columnas Financieras</a><br>
						&#9656; &nbsp; <a href="{{ $covers['portadas_politicas'] }}" style="color: #ffffff;text-decoration: none;">Portadas Politicas</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>