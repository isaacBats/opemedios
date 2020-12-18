/**
  *-------------------------------------------------------------------------------------
  * Developer Information
  *-------------------------------------------------------------------------------------
  * @author Isaac Daniel Batista <daniel@danielbat.com>
  * @link https://danielbat.com Web Autor's site
  * @see https://twitter.com/codeisaac <@codeisaac>
  * @copyright 2019
  * @version 1.0.0
  * Type: Javascript
  * Description: Description
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */
$(document).ready(function(){
        /*used for put a count on the themes titles*/
        $('span.count').each(function( ){
          if($("#"+$(this).attr('target')))
            $("#"+$(this).attr('target')).text( "("+$(this).text() + ")");
        });
     
        // spinner in off
        $('.loader').hide();
        $('#list-news h2.theme-name').text( $('#list-group-themes li.uk-active a').html() );


        if( $("ul.pagination").length ){
          $("ul.pagination").addClass("uk-pagination");
          $("ul.pagination li.active").addClass("uk-active");
          $("ul.pagination li.disabled").addClass("uk-disabled");
        }

        // get new by theme
        $('ul.list-group').on('click', 'a.item-theme', function(event){
            var themeid = $(this).data('themeid')
            var companyid = $(this).data('companyid')
            var companyslug = $(this).data('companyslug')
            var item = $(this)
            var container = $('#news-by-theme')
            var spinner = $('.loader')
            var listThemes = $('#list-group-themes')
            

            container.empty()
            spinner.show()
            var news = $.post( `/${companyslug}/news-by-theme` , { '_token': $('meta[name=csrf-token]').attr('content'), companyid: companyid, themeid: themeid, companyslug: companyslug } , function(news) {
              spinner.hide();
              container.html(news);
              $('#list-news h2.theme-name').text( $('#list-group-themes li.active a').html() );
            }).fail(function(data) {
                spinner.hide() 

                        var beautifullHTML = `<div class="uk-alert-warning uk-padding-large">
                                <p>Tenemos problemas con su petición. Intentelo mas tarde... =)</p>
                            </div>`

                        container.append(beautifullHTML)
                        // TODO: poner el error en un log
                        console.log(`Error-Themes: ${data.responseJSON.message}`)
              });
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
                    spinner.hide();
                    container.html(news);
                    $('#list-news h2.theme-name').text($('#list-group-themes li.uk-active a').text());
                },
                error: function(data) {
                    spinner.hide() 
                    var beautifullHTML = `<div class="uk-alert-warning uk-padding-large">
                                <p>Tenemos problemas con su petición. Intentelo mas tarde... =)</p>
                            </div>`

                    container.append(beautifullHTML)
                    // TODO: poner el error en un log
                    console.log(`Error-Pagination: ${data.responseJSON.message}`)
                }
            });
        }

        // search news
        $('#input-search').on('keypress', function(event){
          if(event.keyCode == 13) {
          event.preventDefault()
          var input = $('#input-search')
          var companyid = input.data('companyid')
          var companyslug = input.data('companyslug')
          var token = $('meta[name=csrf-token]').attr('content')
          var container = $('#list-news')
          var spinner = $('.loader')
          var uri = window.location.pathname
          var last = uri.split('/').pop()

          container.empty()
          spinner.show()

          $('.scroll-to.uk-list').hide();

            var news = $.get( `/${companyslug}/search?company=${companyid}&query=${input.val()}&last=${last}&_token=${token}` , function(news) {
              spinner.hide()
              var titleHTML = `
                <h2>Resultados de la busqueda: ${input.val()}</h2>
              `;
              container.append(titleHTML)
              container.append(news)
            }).fail(function(err) {
                spinner.hide() 
              var beautifullHTML = `<div class="jumbotron">
                      <p>Tenemos problemas con su petición. Intentelo mas tarde... =)</p>
                  </div>`

              container.append(beautifullHTML)
              // TODO: poner el error en un log
              console.error(`Error-search: ${err.responseJSON.message}`)
              });
          }
        })
  /* Display more news on dashboard by theme*/
  $('.more-theme-news').click(function(e){
    $(this).parent().parent().find('.news-single').removeClass("uk-hidden");
    e.stopPropagation();
    e.preventDefault();
    $(this).addClass("uk-hidden");
  });


  var slider = UIkit.slider('#slider', {
    finite : false,
  });

  $(window).resize(function(){

    $options = {
      "offset": $("body > header").height(),
      "animation" : "uk-animation-slide-bottom",
    };
    UIkit.sticky(".sticky-this", $options);
  });


  $(".uk-subnav.uk-slider-items a").click(function(){
    $toShow = $(this).parent().attr("uk-filter-control");    
    $(".js-temas .row").fadeOut();
    $(".js-temas .row"+$toShow).fadeIn();
    $(".uk-subnav.uk-slider-items li").removeClass("active");
    $(this).parent().addClass("active");
  })

  $options = {
    "offset": $("body > header").height(),
    "animation" : "uk-animation-slide-bottom",
  };
  UIkit.sticky(".sticky-this", $options);

})

