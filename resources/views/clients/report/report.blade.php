@extends('layouts.report')
@section('content')
<h1>Reporte Opemedios</h1>
<table>
    <thead>
        <tr>
            <th>Reporte generado el 24 de Enero del 2021</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <table>
                <tbody>
                    <tr>
                        <td>
                            <div id="basicflot" class="flot-chart"></div>
                        </td>
                        <td></td>
                        <td>
                            <div id="piechart" class="flot-chart"></div>
                        </td>
                    </tr>
                    
                </tbody>
            </table>
        </tr>
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
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            'use strict';

            function showTooltip(x, y, contents) {
                $('<div id="tooltip" class="tooltipflot">' + contents + '</div>').css( {
                  position: 'absolute',
                  display: 'none',
                  top: y + 5,
                  left: x + 5
                }).appendTo('body').fadeIn(200);
            }

            var newCust = [[0, 0], [1, 10], [2,5], [3, 12], [4, 5], [5, 8], [6, 0]];
            var retCust = [[0, 0], [1, 8], [2,3], [3, 10], [4, 3], [5, 6], [6,0]];
            
            var plot = $.plot($('#basicflot'),[
            {
                data: newCust,
                label: 'New Customer',
                color: '#03c3c4'
            },
            {
                data: retCust,
                label: 'Returning Customer',
                color: '#905dd1'
            }],
            {
                series: {
                    lines: {
                        show: false
                    },
                    splines: {
                        show: true,
                        tension: 0.4,
                        lineWidth: 1,
                        fill: 0.4
                    },
                    shadowSize: 0
                },
                points: {
                    show: true,
                },
                legend: {
                    container: '#basicFlotLegend',
                    noColumns: 0
                },
                grid: {
                    hoverable: true,
                    clickable: true,
                    borderColor: '#ddd',
                    borderWidth: 0,
                    labelMargin: 5,
                    backgroundColor: '#fff'
                },
                yaxis: {
                    min: 0,
                    max: 15,
                    color: '#eee'
                },
                xaxis: {
                    color: '#eee'
                }
            });
            var previousPoint = null;

            $('#basicflot').bind('plothover', function (event, pos, item) {
                $('#x').text(pos.x.toFixed(2));
                $('#y').text(pos.y.toFixed(2));

                if(item) {
                    if (previousPoint != item.dataIndex) {
                        previousPoint = item.dataIndex;

                        $('#tooltip').remove();
                        var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1].toFixed(2);

                        showTooltip(item.pageX, item.pageY, item.series.label + ' of ' + x + ' = ' + y);
                    }
                } else {
                    
                    $('#tooltip').remove();
                    previousPoint = null;
                }
            });

            $('#basicflot').bind('plotclick', function (event, pos, item) {
                if (item) {
                    plot.highlight(item.series, item.datapoint);
                }
            });
        })

            /***** PIE CHART *****/
            var piedata = [
                { label: 'Televisión', data: [[1,10]], color: '#D9534F'},
                { label: 'Radio', data: [[1,30]], color: '#1CAF9A'},
                { label: 'Periodico', data: [[1,90]], color: '#F0AD4E'},
                { label: 'Revistas', data: [[1,70]], color: '#428BCA'},
                { label: 'Internet', data: [[1,80]], color: '#5BC0DE'}
            ];

            $.plot('#piechart', piedata, {
                series: {
                    pie: {
                        show: true,
                        radius: 1,
                        label: {
                            show: true,
                            radius: 2/3,
                            formatter: labelFormatter,
                            threshold: 0.1
                        }
                    }
                },
                grid: {
                    hoverable: true,
                    clickable: true
                }
            });

            function labelFormatter(label, series) {
                return '<div style="font-size:8pt; text-align:center; padding:2px; color:white;">' + label + '<br>' + Math.round(series.percent) + '%</div>';
            }
    </script>
@endsection
@section('styles')
    <style type="text/css">
        .flot-chart{
            width: 600px;
            height: 300px;
        }
    </style>
@endsection