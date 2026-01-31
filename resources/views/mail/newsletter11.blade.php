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
		$bodyBgColor = isset($colorsConfig['body_bg']) ? $colorsConfig['body_bg'] : "#ffffff";
		$mainBgColor = isset($colorsConfig['main_bg']) ? $colorsConfig['main_bg'] : "#f6f1df";
		$linksBgColor = isset($colorsConfig['links_bg']) ? $colorsConfig['links_bg'] : "#e0e7c8";
		$linksButtonBorderColor = isset($colorsConfig['links_button_border']) ? $colorsConfig['links_button_border'] : "#2b2a27";
		$linksButtonTextColor = isset($colorsConfig['links_button_text']) ? $colorsConfig['links_button_text'] : "#2b2a27";
		$bannerBgColor = isset($colorsConfig['banner_bg']) ? $colorsConfig['banner_bg'] : "#ffffff";
		$dateBgColor = isset($colorsConfig['date_bg']) ? $colorsConfig['date_bg'] : "#013b76";
		$dateTextColor = isset($colorsConfig['date_text']) ? $colorsConfig['date_text'] : "#ffffff";
		$themeBgColor = isset($colorsConfig['theme_bg']) ? $colorsConfig['theme_bg'] : "#0113b76";
		$themeBorderColor = isset($colorsConfig['theme_border']) ? $colorsConfig['theme_border'] : "#e7d8c8";
		$themeTextColor = isset($colorsConfig['theme_text']) ? $colorsConfig['theme_text'] : "#ffffff";
		$newsBorderColor = isset($colorsConfig['news_border']) ? $colorsConfig['news_border'] : "#e7d8c8";
		$newsTitleColor = isset($colorsConfig['news_title']) ? $colorsConfig['news_title'] : "#000000";
		$newsTextColor = isset($colorsConfig['news_text']) ? $colorsConfig['news_text'] : "#2b2a27";
		$newsButtonBorderColor = isset($colorsConfig['news_button_border']) ? $colorsConfig['news_button_border'] : "#a69c8e";
		$newsButtonTextColor = isset($colorsConfig['news_button_text']) ? $colorsConfig['news_button_text'] : "#2b2a27";
		$footerBgColor = isset($colorsConfig['footer_bg']) ? $colorsConfig['footer_bg'] : "#14c8be";
		$footerTextColor = isset($colorsConfig['footer_text']) ? $colorsConfig['footer_text'] : "#ffffff";
	@endphp
</head>
<body style="background-color:{{ $bodyBgColor }};margin:0px 0px 0px 0px;padding:0px 0px 0px 0px;">
	<table style="font-family: Arial, sans-serif; max-width: 600px; width: 100%; margin: 0 auto 0 auto; background-color:{{ $mainBgColor }};" border="0" cellpadding="0" cellspacing="0" align="center">

		<tr>
			<td style="background-color:{{ $linksBgColor }};">
				<p style="white-space: nowrap; font-size: 5px;">&nbsp;</p>
				<table border="0" cellpadding="0" cellspacing="0" align="center" style="border-spacing: 0; max-width: 600px; width: 100%; border: none;background-color:{{ $linksBgColor }};">
					<tr>
						<td style="width: 15px; background-color:{{ $themeBgColor }};"></td>
						<td style="width: 10px;"></td>
						<td style="background-color:{{ $themeBgColor }}; padding: 15px 15px 15px 15px;">
							<table border="0" cellpadding="0" cellspacing="0" align="center" style="border-spacing: 0; border: none;">
								<td>
									<p style="font-weight: bold; font-size: 16px; color:{{ $themeTextColor }};">PRIMERAS PLANAS</p>
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
				<table border="0" cellpadding="0" cellspacing="0" align="center" style="background-color:{{ $linksBgColor }}; max-width: 600px; width: 100%; font-size: 15px;">
					<tr>
						<td style="padding: 25px 15px 25px 15px;">
							<table border="0" cellpadding="0" cellspacing="0" align="center" style="background-color:{{ $linksBgColor }};">
								<tr>
									<td style="width: 8px;"></td>
									<td style="width: 1px; background-color:{{ $linksButtonBorderColor }};"></td>
									<td style="width: 4px;"></td>
									<td style="padding-left: 15px;">
										@foreach ($linksAllowed as $key => $link)
											<a href="{{ $link }}" style="text-decoration: underline; color:{{ $linksButtonTextColor }}; display: inline-block; white-space: nowrap; margin: 5px 0 5px 0;">
												{{ $covers->where('slug', $key)->first()->name }}
											</a>
											<span style="white-space: nowrap;">&nbsp;&nbsp;&nbsp;&nbsp;</span>
										@endforeach
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td style="text-align: center;background-color:{{ $bannerBgColor }}">
				<img src="{{ asset("images/{$newsletterSend->newsletter->banner}") }}" alt="{{ $newsletterSend->newsletter->name ?? 'N/E' }}" style="display:block;width: 100%;">
			</td>
		</tr>
		<tr>
			<td style="background-color:{{ $dateBgColor }};padding: 10px 15px 10px 15px;text-align:center;">
				<p style="font-weight: bold;font-size:14px;color:{{ $dateTextColor }};">
					{{ Illuminate\Support\Carbon::parse($newsletterSend->date_sending)
                                    ->locale('es')
                                    ->formatLocalized('%A %d de %B %Y') }}
				</p>
			</td>
		</tr>
		
		@foreach ($newsletterSend->newsletter->company->themes as $theme)
			@if($newsletterSend->newsletter_theme_news->where('newsletter_theme_id', $theme->id)->count())
				<tr>
					<td>
						<p style="white-space: nowrap; font-size: 5px;">&nbsp;</p>
						<table border="0" cellpadding="0" cellspacing="0" align="center" style="border-spacing: 0; max-width: 600px; width: 100%; border: none;background-color:{{ $mainBgColor }};">
							<tr>
								<td style="width: 15px; background-color:{{ $themeBgColor }};"></td>
								<td style="width: 10px;"></td>
								<td style="background-color:{{ $themeBgColor }}; padding: 15px 15px 15px 15px;">
									<table border="0" cellpadding="0" cellspacing="0" align="center" style="border-spacing: 0; border: none;background-color:{{ $themeBgColor }}">
										<td>
											<p style="font-weight:bold; font-size:16px;color:{{ $themeTextColor }}">
												{{ strtoupper($theme->name) }}
											</p>
										</td>
									</table>
								</td>
								<td style="width: 10px;"></td>
								<td style="width: 15px;background-color:{{ $themeBgColor }}"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table border="0" cellpadding="0" cellspacing="0" align="center" style="border-spacing: 0; max-width: 600px; width: 100%; border: none;background-color:{{ $mainBgColor }};">
							<tr>
								<td style="width: 35px;"></td>
								<td style="background-color:{{ $themeBorderColor }}; font-size: 5px;">&nbsp;&nbsp;</td>
								<td style="width: 35px;"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style="text-align: center;padding:5px 15px 10px 15px;">
						<p style="font-size:13px;line-height:20px;color:{{ $newsTextColor }};">
							@php
								$countNotes = $newsletterSend->newsletter_theme_news->where('newsletter_theme_id', $theme->id)->count();
							@endphp
							{{ "Noticias encontradas: {$countNotes}" }}
						</p>
					</td>
				</tr>
			@endif
			@foreach ($newsletterSend->newsletter_theme_news as $note)
				@if($note->theme->id == $theme->id)
					<tr>
						<td>
							<table border="0" cellpadding="0" cellspacing="0" align="center" style="background-color:{{ $mainBgColor }}">

								<tr>
									<td style="width: 25px;"></td>
									<td style="width: 1px; background-color:{{ $newsBorderColor }};"></td>
									<td>
										<table style="font-size: 15px;" cellpadding="0" cellspacing="0">
											<tr>
												<td style="width: 20px;"></td>
												<td>
													<p style="height: 10px; font-size: 10px;">&nbsp;</p>
													<p style="font-size: 15px; font-weight: normal;">
														<a href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}" style="color:{{ $newsTitleColor }}; text-decoration: none; font-size: 15px;font-weight:bold;">
																{{ strtoupper($note->news->title) }}
														</a>
													</p>
												</td>
												<td style="width: 30px;"></td>
											</tr>
											<tr>
												<td style="width: 20px;"></td>
												<td>
													<p style="height: 10px; font-size: 10px;">&nbsp;</p>
													<hr height="1" style="height:1px; border:0 none; color:{{ $newsBorderColor }}; background-color:{{ $newsBorderColor }};">
													<p style="height: 10px; font-size: 10px;">&nbsp;</p>
												</td>
												<td style="width: 30px;"></td>
											</tr>
											<tr>
												<td style="width: 20px;"></td>
												<td>
													<p style="font-size: 14px;color:{{ $newsTextColor }};" class="fuenteNoticia">
														<span style="white-space:nowrap;">&#8226; {{ $note->news->mean->name }}</span> <span style="white-space:nowrap;">&#8226; {{ $note->news->source->name }}</span> <span style="white-space:nowrap;">&#8226; {{ $note->news->author }}</span>
													</p>
													<p style="height: 10px; font-size: 10px;">&nbsp;</p>
												</td>
												<td style="width: 30px;"></td>
											</tr>
											<tr>
												<td style="width: 20px;"></td>
												<td>
													<p style="font-size: 14px;color:{{ $newsTextColor }};">
														{!! $note->news->synthesis !!}
													</p>
													<p style="height: 10px; font-size: 10px;">&nbsp;</p>
												</td>
												<td style="width: 30px;"></td>
											</tr>
											<tr>
												<td style="width: 20px;"></td>
												<td>
													<table cellpadding="0" cellspacing="0">
														<tr>
															<td style="border: 1px solid {{ $newsButtonBorderColor }}; padding: 10px 15px 10px 15px;">
																<a href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}" style="color:{{ $newsButtonTextColor }};text-decoration:none;">
																	Ver detalle nota
																</a>
															</td>
														</tr>
														<tr>
															<td>
																<table style="width: 100%;" cellpadding="0"  cellspacing="0">
																	<tr>
																		<td style="width: 10px; font-size: 5px;">&nbsp;</td>
																		<td style="background-color:{{ $themeBorderColor }}; font-size: 5px;">&nbsp;</td>
																		<td style="width: 10px; font-size: 5px;">&nbsp;</td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
												<td style="width: 30px;"></td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>
							<p style="font-size: 25px;">&nbsp;</p>
						</td>
					</tr>
				@endif
			@endforeach
		@endforeach

		<tr>
			<td style="background-color:{{ $footerBgColor }};">
				<table border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; width: 100%;background-color:{{ $footerBgColor }};">
					<tr>
						<td style="padding: 15px 15px 15px 15px;">
							<p style="font-weight: bold; font-size: 14px; color:{{ $footerTextColor }};">
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