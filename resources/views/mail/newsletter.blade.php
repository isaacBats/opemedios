<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
</head>
<body style="background: #f8f8f8;">
<table style="width: 100%; border-collapse: collapse;">
    <tr>
        <td>
            <table style="width: 580px;border-collapse: collapse;" align="center">
                <tr>
                    <td style="margin:0;padding: 0;border: 0">
                        <img src="{{ asset("images/{$newsletter->banner}") }}" alt="{{ $newsletter->name }}" style="max-width: 100%;display: block;">
                    </td>
                </tr>
            </table>
            <table style="width: 580px;border-collapse: collapse;font-size: 12px;font-family: Arial, Helvetica, sans-serif;" align="center">
                <tr>
                    <td style="padding: 15px 30px;background: #000000;text-align: right; color: #fff">
                        {{ Illuminate\Support\Carbon::parse($newsletter->created_at)->formatLocalized('%A %d de %B %Y') }}
                    </td>
                </tr>

               
                @foreach ($news as $ns) 
                    <tr>
                        <td style="padding: 15px 30px;background: white;border-bottom: solid 1px #e8e8e8">
                            <p style="margin: 0;padding: 0;font-size: 12px;font-family: Arial, Helvetica, sans-serif;line-height: 1.25;font-weight: normal;text-align: left !important;"><span style="font-weight: bold">CATEGORIA O TEMA</span><br><a href="http://sistema.opemedios.com.mx/ver_noticia_internet_ns.php?id_noticia=995708" style="color: #015199;font-weight: bold;text-decoration:none">{{ $ns->encabezado }}</a><br>
                                {{ $ns->sintesis }}<br><span style="color: #950a16;font-weight: bold;">Prensa | Publimetro, Economía, Pag. 08, Daniel Casillas</span>
                            </p>
                        </td>
                    </tr>
                @endforeach

            </table>
            <table style="width: 580px;border-collapse: collapse;font-size: 12px;font-family: Arial, Helvetica, sans-serif;" align="center">
                <tr>
                    <td style="padding: 30px 30px;">
                        <p style="margin: 0;padding: 0;text-align: center;">
                            <a href="#" style="color: #015199;text-decoration: none;">PRIMERAS PLANAS</a>
                            <a href="#" style="color: #015199;text-decoration: none;"> | PORTADAS NEGOCIOS</a>
                            <a href="#" style="color: #015199;text-decoration: none;"> | CARTONES</a>
                            <a href="#" style="color: #015199;text-decoration: none;"> | COLUMNAS NEGOCIOS</a>
                            <a href="#" style="color: #015199;text-decoration: none;"> | COLUMNAS POLÍTICAS</a>
                            <a href="#" style="color: #015199;text-decoration: none;"> | PORTADA ESPECTACULOS</a>
                         </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>