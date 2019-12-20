@extends('layouts.home2')
@section('title', " - Mis temas")
@section('content')
    <!--Page Content -->
    <div class="container op-content-mt">
        <div class="row card-company">
            <div class="col-sm-3">
                <img src="{{ asset("images/{$company->logo}") }}" alt="{{ $company->name }}">
            </div>
            <div class="col-sm-8 page-header card-company-name">
                <h1>{{ $company->name }}</h1>
            </div>
        </div>
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
                @include('components/listNews')
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

        // get new by theme
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
                    themeid: themeid,
                    companyslug: companyslug
                }).error(
                    function (data) {
                        spinner.hide() 

                        var beautifullHTML = `<div class="jumbotron">
                                <p>Tenemos problemas con su petición. Intentelo mas tarde... =)</p>
                            </div>`

                        container.append(beautifullHTML)
                        // TODO: poner el error en un log
                        console.log(`Error-Themes: ${data.responseJSON.message}`)
                    }
                ).success(
                    function (news) {

                        spinner.hide()
                        container.html(news)
                        
                    }
                )
       })    

        // pagination 
        $(document).on('click', '#news-pagination .pagination a', function(event){
            event.preventDefault()
            var page = $(this).attr('href').split('page=')[1];
            fetch_data(page);
        });

        function fetch_data(page) {
            var themeid = $('#news-pagination').data('themeid')
            var companyid = $('#news-pagination').data('companyid')
            var companyslug = $('#news-pagination').data('companyslug')
            var container = $('#news-by-theme')
            var spinner = $('.loader')

            container.empty()
            spinner.show()

            $.ajax({
                type: 'POST',
                url:`/${companyslug}/news-by-theme?page=${page}`,
                data: {
                    '_token': $('meta[name=csrf-token]').attr('content'), 
                    companyid: companyid, 
                    themeid: themeid,
                    companyslug: companyslug
                },
                success:function(news) {
                    spinner.hide()
                    container.html(news)
                },
                error: function(data) {
                    spinner.hide() 
                    var beautifullHTML = `<div class="jumbotron">
                            <p>Tenemos problemas con su petición. Intentelo mas tarde... =)</p>
                        </div>`

                    container.append(beautifullHTML)
                    // TODO: poner el error en un log
                    console.log(`Error-Pagination: ${data.responseJSON.message}`)
                }
            });
        }

    })
</script>
@endsection