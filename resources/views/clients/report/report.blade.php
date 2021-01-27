<table>
    <thead>
        <tr>
            <td height="24"style="font-weight: bold; font-size: 20px" colspan="4">
                {{ $company->name }}
            </td>
        </tr>
        <tr>
            <td height="20"></td>
        </tr>
        <tr>
            <th colspan="5">Reporte generado el {{ $filterData['today'] }}</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <table>
                <thead>
                    <tr>
                        <td height="40"></td>
                    </tr>
                    <tr>
                        <th>Noticias</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Id Noticia</th>
                        <th>Tema</th>
                        @foreach ($last->metas() as $meta)
                            @if($meta['label'] == 'Hora' || 
                               $meta['label'] == 'Duración' || 
                               $meta['label'] == 'Tipo de página' ||
                               $meta['label'] == 'Número de página' ||
                               $meta['label'] == 'Tamaño de página' ||
                               $meta['label'] == 'URL' ||
                               $meta['label'] == 'Creador') 
                                    @continue
                            @endif
                            <th>{{ $meta['label'] }}</th>
                        @endforeach
                        <th>Link</th>
                    </tr>
                    @foreach($collection as $note)
                        <tr>
                            @foreach ($note as $key => $value)
                                @if($key == 'Link')
                                    <td><a href="{{ $value }}">Ir a la noticia</a></td>
                                    @continue
                                @endif
                                <td>{{ $value }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </tr>
    </tbody>
</table>
