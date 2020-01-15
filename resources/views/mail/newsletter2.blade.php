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
						<img src="<?=$logo?>" width="150px">
					</td>
					<td style="text-align: right;font-size: 12px;padding: 20px 20px 20px 0;">
						<?=$currentDate;?>
					</td>
				</tr>
			</table>
			<table align="center" style="width: 580px;padding: 0;border: 0;border-collapse: collapse;background-color: #ffffff;">
				<tr>
					<td>
						<img src="<?=$pathBanner?>" style="width: 100%;height: auto;">
					</td>
				</tr>
			</table>
			<table align="center" style="width: 580px;padding: 0;border: 0;border-collapse: collapse;background-color: #ffffff;margin-bottom: 100px;">
				<tr>
					<td colspan="2" style="padding: 30px;">
					</td>
				</tr>
				<?php
				if (is_array($noticias)) {
					$indexColor = 0;
					foreach($noticias as $theme => $item) { 
				?>
					<tr>
						<td colspan="2">
							<table style="width: 580px;border: 0;border-collapse: collapse;">
								<tr>
									<td style="width: 20px;height: 30px;background-color: <?=$aBgColors[$indexColor]?>;"></td>
									<td style="padding-left: 10px;font-size: 20px;font-family: &quot;Times New Roman&quot;, Times, serif;color: <?=$aBgColors[$indexColor]?>;">
										<?=strtoupper($theme)?>
									</td>
								</tr>
								<tr>
									<td colspan="2" style="padding: 15px;"></td>
								</tr>
							</table>
						</td>
					</tr>
					<?php foreach($item as $key => $n) { ?>
					<tr>
						<td colspan="2" style="padding: 10px 30px;">
							<a href="<?=$n['urlOpemedios']?>" style="font-size: 14px;color: #1976D2;text-decoration: none;"><?=strtoupper($n['title'])?></a>
							<p style="color: #263238;font-size: 14px;margin: 0;margin-top: 2px;margin-bottom: 5px;"><?=$n['extract']?> </p>
							<p style="font-size: 11px;margin-bottom: 20px;margin-top: 5px;color: #546E7A;"> <?=$n['tipoFuente']?> / <?=$n['fuente']?>, <?=$n['seccion']?>, <?=$n['autor']?></p>
						</td>
					</tr>
					<?php } ?>
					<tr>
						<td colspan="2" style="padding: 15px;"></td>
					</tr>
				<?php
					$indexColor++;
					$indexColor = ($indexColor >= 5) ? 0: $indexColor; 
					}
				} //end if  
				?>
				<!-- start footer -->
				<tr valign="top" style="font-size: 14px;line-height: 24px;border-top: 1px solid #E3F2FD;background-color: #283593;color: #ffffff;">
					<td style="padding: 30px  0 30px 60px;">
						&#9656; &nbsp; <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/primeras-planas" style="color: #ffffff;text-decoration: none;">Primeras Planas</a><br>
						&#9656; &nbsp; <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/portadas-financieras" style="color: #ffffff;text-decoration: none;">Portadas Financieras</a><br>
						&#9656; &nbsp; <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/cartones" style="color: #ffffff;text-decoration: none;">Cartones</a>
					</td>
					<td style="padding: 30px  60px 30px 0;">
						&#9656; &nbsp; <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/columnas-financieras" style="color: #ffffff;text-decoration: none;">Columnas Financieras</a><br>
						&#9656; &nbsp; <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/columnas-politicas" style="color: #ffffff;text-decoration: none;">Portadas Politicas</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>