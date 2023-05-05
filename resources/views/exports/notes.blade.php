<table>
    <tbody>
        @php $num = 0; @endphp
        @foreach($themes_group as $key => $itm)
            @php
                $obj_dd = $notes[$key][1];
            @endphp
            <tr>
                <th colspan="10">theme|Tema:&nbsp;{{ $notes[$key][0] }}</th>
            </tr>
            <tr>
                <th>colhead|ID</th>
                <th>colhead|Título</th>
                <th>colhead|Síntesis</th>
                <th>colhead|Autor</th>
                <th>colhead|Fuente</th>
                <th>colhead|Fecha nota</th>
                <th>colhead|Costo</th>
                <th>colhead|Tendencia</th>
                <th>colhead|Medio</th>
                <th>colhead|Alcance</th>
            </tr>
            @foreach($obj_dd->get() as $note)
                @php 
                    $num++; 
                    $trend = $note->trend == 1 ? 'Positiva' : ($note->trend == 2 ? 'Neutral' : 'Negativa');
                    $link = route('front.detail.news', ['qry' => \Illuminate\Support\Facades\Crypt::encryptString("{$note->id}-{$note->title}-{$company->id}")]);
                @endphp
                <tr>
                    <td>{{ $num . "-OPE-{$note->id}" }}</td>
                    <td>{{ $note->title . "|" . $link }}</td>
                    <td>{{ $note->synthesis }}</td>
                    <td>{{ $note->author }}</td>
                    <td>{{ ($note->source->name ?? 'N/E') }}</td>
                    <td>{{ $note->news_date->format('Y-m-d') }}</td>
                    <td>{{ $note->cost }}</td>
                    <td>{{ $trend }}</td>
                    <td>{{ $note->mean->name ?? 'N/E' }}</td>
                    <td>{{ $note->scope }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>