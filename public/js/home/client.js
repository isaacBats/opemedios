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
        // spinner in off
        $('.loader').hide();
        $('span.tema-actual').text($('ul.list-group li.uk-active a').text());

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
            
            $('ul.list-group li').removeClass('uk-active');
            $(this).parent().addClass("uk-active");
            $('span.tema-actual').text($('ul.list-group li.uk-active a').text());

            container.empty()
            spinner.show()
            var news = $.post( `/${companyslug}/news-by-theme` , { '_token': $('meta[name=csrf-token]').attr('content'), companyid: companyid, themeid: themeid, companyslug: companyslug } , function(news) {
              spinner.hide()
              container.html(news)
            }).fail(function(data) {
                spinner.hide() 

                        var beautifullHTML = `<div class="jumbotron">
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

        // search news
        $('#btn-search').on('click', function(event){
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
                <h2>Resultados de la busqueda</h2>
                <hr>
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


        })

    })
