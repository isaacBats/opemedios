<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ config('app.name', 'Opemedios Newsletter') }}</title>
	<meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
	<style>a[x-apple-data-detectors]{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}u+#body a{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}#MessageViewBody a{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important;}:root{color-scheme:light dark;supported-color-schemes:light dark;}tr{vertical-align:middle;}p,a,li{mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;}p:first-child{margin-top:0!important;}p:last-child{margin-bottom:0!important;}a{text-decoration:underline;color:inherit;}@media only screen and (max-width:599px){.full-width-mobile{width:100%!important;height:auto!important;}.mobile-padding{padding-left:10px!important;padding-right:10px!important;}.mobile-stack{display:block!important;width:100%!important;}}
    </style>
    @php
	    $day = date('Y-m-d H:i:s');

	    $colorsConfig = unserialize($newsletterSend->newsletter->colors);
	    $bodyBgColor = isset($colorsConfig['body_bg']) ? $colorsConfig['body_bg'] : "#f2f2f2";
	    $mainBgColor = isset($colorsConfig['main_bg']) ? $colorsConfig['main_bg'] : "#f6f1df";
	    $dateBgColor = isset($colorsConfig['date_bg']) ? $colorsConfig['date_bg'] : "#ffffff";
	    $dateTextColor = isset($colorsConfig['date_text']) ? $colorsConfig['date_text'] : "#000000";
	    $themeBgColor = isset($colorsConfig['theme_bg']) ? $colorsConfig['theme_bg'] : "#ffffff";
	    $themeBorderColor = isset($colorsConfig['theme_border']) ? $colorsConfig['theme_border'] : "#e7d8c8";
	    $themeTextColor = isset($colorsConfig['theme_text']) ? $colorsConfig['theme_text'] : "#000000";
		$newsBorderColor = isset($colorsConfig['news_border']) ? $colorsConfig['news_border'] : "#e7d8c8";
	    $newsButtonBgColor = isset($colorsConfig['news_button_bg']) ? $colorsConfig['news_button_bg'] : "#f6f1df";
	    $newsButtonBorderColor = isset($colorsConfig['news_button_border']) ? $colorsConfig['news_button_border'] : "#a69c8e";
	    $newsButtonTextColor = isset($colorsConfig['news_button_text']) ? $colorsConfig['news_button_text'] : "#2b2a27";
	    $footerBgColor = isset($colorsConfig['footer_bg']) ? $colorsConfig['footer_bg'] : "#ffffff";
	    $footerTextColor = isset($colorsConfig['footer_text']) ? $colorsConfig['footer_text'] : "#222222";
	@endphp

</head>
<body style="background-color:{{ $bodyBgColor }}; margin: 0px 0px 0px 0px;padding:0px 0px 0px 0px;">
	<table style="font-family: Arial, sans-serif; max-width: 400px; width: 100%; margin: 0 auto 0 auto; background-color:{{ $mainBgColor }};" cellpadding="0" cellspacing="0">
		<tr>
			<td style="text-align: center;">
				<img src="{{ asset("images/{$newsletterSend->newsletter->banner}") }}" alt="{{ $newsletterSend->newsletter->name ?? 'N/E' }}" style="width: 100%; height: auto; display: block;">
			</td>
		</tr>
		<tr>
			<td style="background-color:{{ $dateBgColor }};">
				<table style="text-align: right; width: 100%;">
					<tr>
						<td style="padding: 15px 25px 15px 15px;">
							<p style="font-weight: 700; font-size: 14px; color:{{ $dateTextColor }}">
								{{ Illuminate\Support\Carbon::parse($day)->formatLocalized('%A %d de %B %Y') }}
							</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<p style="white-space: nowrap; font-size: 5px;">&nbsp;</p>
				<table style="border-spacing: 0; max-width: 400px; width: 100%; border: none;">
					<tr>
						<td style="width: 15px; background-color:{{ $themeBgColor }};"></td>
						<td style="width: 10px;"></td>
						<td style="background-color:{{ $themeBgColor }}; padding: 20px 15px 20px 20px;">
							<table style="border-spacing: 0; border: none;">
								<td>
									<p style="font-weight: 700; font-size: 16px; color:{{ $themeTextColor }};">
										Resumen Diario
									</p>
								</td>
							</table>
						</td>
						<td style="width: 10px;"></td>
						<td style="width: 15px; background-color:{{ $themeBgColor }};"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table style="border-spacing: 0; max-width: 400px; width: 100%; border: none;" cellpadding="0" cellspacing="0">
					<tr>
						<td style="width: 35px;"></td>
						<td style="background-color:{{ $themeBorderColor }}; font-size: 5px;">&nbsp;&nbsp;</td>
						<td style="width: 35px;"></td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td>
				<p style="font-size: 25px;">&nbsp;</p>
			</td>
		</tr>

		<tr>
			<td>
				<table border="0" cellpadding="0" cellspacing="0">
					@foreach ($newsletterSend->newsletter_theme_news as $note)
						<tr>
							<td style="width: 25px;"></td>
							<td style="width: 1px; background-color:{{ $newsBorderColor }}"></td>
							<td>
								<table style="font-size: 15px;" cellpadding="0" cellspacing="0">
									<tr>
										<td style="width: 20px;"></td>
										<td>
											<table cellpadding="0" cellspacing="0">
												<tr>
													<td style="border: 1px solid {{ $newsButtonBorderColor }}; padding: 15px 20px 15px 20px;background-color:{{ $newsButtonBgColor }};">
														<a href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}" style="color:{{ $newsButtonTextColor }};text-decoration:none;">
															{{ strtoupper($note->news->title) }}
														</a>
													</td>
												</tr>
												<tr>
													<td>
														<table style="width: 100%;" cellpadding="0"  cellspacing="0">
															<tr>
																<td style="width: 10px; font-size: 5px;">&nbsp;</td>
																<td style="background-color:{{ $newsBorderColor }}; font-size: 5px;">&nbsp;</td>
																<td style="width: 10px; font-size: 5px;">&nbsp;</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
											<p style="height: 5px; font-size: 5px;">&nbsp;</p>
										</td>
										<td style="width: 30px;"></td>
									</tr>
									
								</table>
							</td>
						</tr>
					@endforeach
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<p style="font-size: 25px;">&nbsp;</p>
			</td>
		</tr>


		<tr>
			<td style="background-color:{{ $footerBgColor }};">
				<table style="text-align: center; width: 100%;">
					<tr>
						<td style="padding: 15px 15px 15px 15px;">
							<p style="font-weight: 700; font-size: 14px; color:{{ $footerTextColor }};">
								Newsletter - Opemedios {{ date('Y') }}
							</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>