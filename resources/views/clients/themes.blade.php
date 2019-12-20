@extends('layouts.home2')
@section('title', " - Mis temas")
@section('content')
    <!--Page Content -->
    <div class="container op-content-mt">
        <h1 class="page-header"> Noticias por tema</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        Temas
                    </div>
                    <div class="panel-body themes-list-p0">
                        <ul class="list-group" id="list-group-themes">
                            @foreach ($themes as $theme)
                                <li class="list-group-item theme-transition"><a class="item-theme" href="javascript:void(0)" data-companyslug="{{ $company->slug }}" data-companyid="{{ $idCompany }}" data-themeid="{{ $theme->id_tema }}">@if($theme->id_tema == $defaultThemeId) <i id="item-indicator" class="fa fa-arrow-right" style="color: #005b8a;"></i> @endif {{ $theme->nombre }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="loader">Cargando...</div>
            <div id="news-by-theme" class="col-md-9">
                @foreach($news as $new)
                    <div class="row f-col">
                        <div class="col-md-4">
                            <div class="bloque-new item-center">
                                <a class="img-responsive">
                                    {{-- TODO: cuando los logos se alojen en la nueva aplataforma, se va a cambiar esta url --}}
                                  <img src="http://sistema.opemedios.com.mx/data/fuentes/{{ $new->logo }}" alt="{{ $new->nombre}}">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h4 class="f-h4 text-muted">
                                {{ $new->nombre }} | {{ Illuminate\Support\Carbon::parse($new->fecha)->diffForHumans() }}
                            </h4>
                            <h3 class="f-h3">
                                {{ $new->encabezado  }}
                            </h3>
                            <p class="text-muted f-p">
                                 {{ $new->empresa }} | Autor: {{ $new->autor }}
                            </p>
                            <p class="f-p">{{ Illuminate\Support\Str::limit($new->sintesis, 200) }}</p>
                            <a class="btn btn-primary" href="{{ route('client.shownew', ['id' => $new->id_noticia, 'company' => $company->slug ]) }}">Ver más</a>
                        </div>
                    </div>
                @endforeach
                <div class="text-right">
                    {{ $news->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- /.container -->
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        
        // spinner in off
        $('.loader').hide()


        $('ul.list-group').on('click', 'a.item-theme', function(event){
            event.preventDefault()
            var themeid = $(this).data('themeid')
            var companyid = $(this).data('companyid')
            var companyslug = $(this).data('companyslug')
            var item = $(this)
            var container = $('#news-by-theme')
            var spinner = $('.loader')
            var listThemes = $('#list-group-themes')
            
            listThemes.find('#item-indicator').remove()
            item.prepend(`<i id="item-indicator" class="fa fa-arrow-right" style="color: #005b8a;"></i> `)
            container.empty()
            spinner.show()

            var news = $.post(`/${companyslug}/news-by-theme`, 
                {
                    '_token': $('meta[name=csrf-token]').attr('content'), 
                    companyid: companyid, 
                    themeid: themeid
                }).error(
                    function (data) {
                        spinner.hide() 
                        var beautifullHTML = `<div class="jumbotron">
                                <p>Tenemos problemas con su petición. Intentelo mas tarde... =)</p>
                            </div>`

                        container.append(beautifullHTML)
                        // TODO: poner el error en un log
                        // console.log(`Error: ${data.responseJSON.message}`)
                    }
                ).success(
                    function (data) {

                        var req = JSON.parse(JSON.stringify(data))
                        spinner.hide()
                        data.data.forEach( function(item) {
                            container.append(getTemplate(item))
                        })
                        console.log(data)
                        container.append(`<div class="text-right">${req.links}</div>`)
                        // var html = getTemplate(data)
                        // // console.log(html)
                        // // debugger
                        // container.html(getTemplate(data))

                    }
                )

            var getTemplate = function (data) {
                return `
                        <div class="row f-col">
                            <div class="col-md-4">
                                <div class="bloque-new item-center">
                                    <a class="img-responsive">
                                        {{-- TODO: cuando los logos se alojen en la nueva aplataforma, se va a cambiar esta url --}}
                                      <img src="http://sistema.opemedios.com.mx/data/fuentes/${data.logo}" alt="${data.nombre}">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h4 class="f-h4 text-muted">
                                    ${data.nombre} | ${data.fecha}
                                </h4>
                                <h3 class="f-h3">
                                    ${data.encabezado}
                                </h3>
                                <p class="text-muted f-p">
                                     ${data.empresa } | Autor: ${data.autor}
                                </p>
                                <p class="f-p">${data.sintesis.substr(0, 200)}</p>
                                <a class="btn btn-primary" href="/${companyslug}/noticia/${data.id_noticia}">Ver más</a>
                            </div>
                        </div>`
            }

       })    



    })
</script>
@endsection