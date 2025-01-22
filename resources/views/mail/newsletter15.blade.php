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
	    $linksButtonTextColor = isset($colorsConfig['links_button_text']) ? $colorsConfig['links_button_text'] : "#000000";
	    $dateBgColor = isset($colorsConfig['date_bg']) ? $colorsConfig['date_bg'] : "#ffffff";
	    $bannerBorderColor = isset($colorsConfig['banner_border']) ? $colorsConfig['banner_border'] : "green";
	    $dateTextColor = isset($colorsConfig['date_text']) ? $colorsConfig['date_text'] : "#000000";
	    $themeBgColor = isset($colorsConfig['theme_bg']) ? $colorsConfig['theme_bg'] : "#ffffff";
	    $themeBorderColor = isset($colorsConfig['theme_border']) ? $colorsConfig['theme_border'] : "#e7d8c8";
	    $themeTextColor = isset($colorsConfig['theme_text']) ? $colorsConfig['theme_text'] : "#000000";
		$newsBorderColor = isset($colorsConfig['news_border']) ? $colorsConfig['news_border'] : "#e7d8c8";
	    $newsButtonBgColor = isset($colorsConfig['news_button_bg']) ? $colorsConfig['news_button_bg'] : "#f6f1df";
	    $newsButtonBorderColor = isset($colorsConfig['news_button_border']) ? $colorsConfig['news_button_border'] : "#a69c8e";
	    $newsButtonTextColor = isset($colorsConfig['news_button_text']) ? $colorsConfig['news_button_text'] : "#2b2a27";
	    $newsTitleColor = isset($colorsConfig['news_title']) ? $colorsConfig['news_title'] : "#000000";
	    $newsTextColor = isset($colorsConfig['news_text']) ? $colorsConfig['news_text'] : "#222222";
	    $footerBgColor = isset($colorsConfig['footer_bg']) ? $colorsConfig['footer_bg'] : "#ffffff";
	    $footerTextColor = isset($colorsConfig['footer_text']) ? $colorsConfig['footer_text'] : "#222222";
    @endphp
</head>
<body style="background-color:{{ $bodyBgColor }}; margin: 0px 0px 0px 0px;padding:0px 0px 0px 0px">
	<table style="font-family: Arial, sans-serif; max-width: 600px; width: 100%; margin: 0 auto 0 auto; background-color:{{ $mainBgColor }};" cellpadding="0" cellspacing="0">
		<tr>
			<td style="text-align: center;background-color:{{ $bodyBgColor }};padding:25px 0px 0px 0px;">
				<img src="{{ asset("images/{$newsletterSend->newsletter->banner}") }}" alt="{{ $newsletterSend->newsletter->name ?? 'N/E' }}" style="width: 100%; height: auto; display: block;margin:0px auto 0px auto;">
			</td>
		</tr>

		<tr>
			<td>
				<table style="width: 100%; background-color:{{ $bodyBgColor }};" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td style="width:30px;"></td>
						<td style="padding: 4px;background-color:{{ $bannerBorderColor }};"></td>
						<td style="width:30px;"></td>
					</tr>
				</table>
			</td>
		</tr>

		<tr style="vertical-align:middle;" valign="middle">
                <td align="center" style="padding-bottom: 10px;background-color:{{ $bodyBgColor }};padding-top: 10px;">
                    <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" width="520" style="border-collapse:collapse;max-width:600px;width:100%;background-color:{{ $bodyBgColor }};">
                    	@foreach ($linksAllowed as $key => $link)
                        	@if ($loop->odd)
		                        <tr style="vertical-align:middle;" valign="middle">
		                            <td align="center" style="padding:7px 20px 7px 20px;">
		                                <p style="mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;font-size:14px;color:{{ $linksButtonTextColor }};margin-top:0!important;margin-bottom:0!important;">
		                                    <a href="{{ $link }}" style="mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;text-decoration:none;font-size:14px;color:{{ $linksButtonTextColor }};">
		                                    	{{ $covers->where('slug', $key)->first()->name }}
		                                    </a>
		                                </p>
		                            </td>
		                    @else
		                            <td align="center" style="padding:7px 20px 7px 20px;">
		                                <p style="mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;font-size:14px;color:{{ $linksButtonTextColor }};margin-top:0!important;margin-bottom:0!important;">
		                                    <a href="{{ $link }}" style="mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;text-decoration:none;font-size:14px;color:{{ $linksButtonTextColor }};">
		                                    	{{ $covers->where('slug', $key)->first()->name }}
		                                    </a>
		                                </p>
		                            </td>
		                        </tr>
		                    @endif
                        @if ($loop->last && $loop->odd)
                                	<td align="center" style="padding:7px 20px 7px 20px;">
		                                <p style="mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;font-size:14px;color:{{ $linksButtonTextColor }};margin-top:0!important;margin-bottom:0!important;">
		                                </p>
		                            </td>
		                        </tr>
                        @endif
                    @endforeach

                    </table>
                </td>
            </tr>

		<tr>
			<td style="padding: 15px 25px 15px 15px;">
				<p style="font-size: 14px; color:{{ $dateTextColor }};text-align:center;">
					{{ Illuminate\Support\Carbon::parse($day)->formatLocalized('%A %d de %B %Y') }}
				</p>
			</td>
		</tr>

		@foreach ($newsletterSend->newsletter->company->themes as $theme)
            @if($newsletterSend->newsletter_theme_news->where('newsletter_theme_id', $theme->id)->count())
				<tr>
					<td style="padding:0px 35px 20px 35px;">
						<p style="font-weight: 700; font-size: 16px; color:{{ $themeTextColor }};text-align:center;">
							{{ strtoupper($theme->name) }}
						</p>
					</td>
				</tr>
				<tr>
					<td>
						<table style="border-spacing: 0; max-width: 600px; width: 100%; border: none;background-color:{{ $mainBgColor }};" cellpadding="0" cellspacing="0">
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
			@endif

				<tr>
					<td>
						<table border="0" cellpadding="0" cellspacing="0" style="background-color:{{ $mainBgColor }};">

							<tr>
								<td style="width: 20px;"></td>
								<td style="width: 1px; background-color:{{ $newsBorderColor }};"></td>
								<td>

							        @foreach ($newsletterSend->newsletter_theme_news as $note)
							            @if($note->theme->id == $theme->id)

											<table style="font-size: 15px;" cellpadding="0" cellspacing="0">
												<tr>
													<td style="width: 10px;"></td>
													<td>
														<table cellpadding="0" cellspacing="0">
															<tr>
																<td style="border: 1px solid {{ $newsBorderColor }}; padding: 15px 20px 15px 20px;">
																	<p style="border-bottom:1px solid {{ $newsBorderColor }};padding-bottom: 10px;color:{{ $newsTitleColor }};">
																		<a href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}" style="text-decoration:none;color:{{ $newsTitleColor }};">
																			{{ strtoupper($note->news->title) }} 
																		</a>
																	</p>
																	<p style="color:{{ $newsTextColor }};">
																		&#95; {{ $note->news->mean->name }} - {{ $note->news->source->name }} , {{ $note->news->author }}
																	</p>
																	<p style="color:{{ $newsTextColor }};">
																		{!! $note->news->synthesis !!}
																	</p>
																	<p style="color:{{ $newsButtonTextColor }};font-size:13px;mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif; text-align: center;border-top:1px solid {{ $newsButtonBorderColor }};padding-top: 10px;">
																		<a href="{{ route('newsletter.shownew', ['qry' => Illuminate\Support\Facades\Crypt::encryptString("{$note->news_id}-{$note->news->title}-{$newsletterSend->newsletter->company->id}")]) }}" style="font-size:13px;mso-line-height-rule:exactly;line-height:24px;font-family:Arial,sans-serif;text-decoration:none;color:{{ $newsButtonTextColor }};">
																			VER NOTA
																		</a>
																	</p>
																</td>
															</tr>
															<tr>
																<td>
																	<table style="width: 100%;" cellpadding="0"  cellspacing="0">
																		<tr>
																			<td style="width: 10px; font-size: 5px;">&nbsp;</td>
																			<td style="background-color: {{ $themeBorderColor }}; font-size: 5px;">&nbsp;</td>
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
										@endif
							        @endforeach

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
        @endforeach

		<tr>
			<td style="background-color:{{ $bodyBgColor }};">
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