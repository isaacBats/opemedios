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

                    spinner.hide()
                    var html = getTemplate(data)
                    console.log(html)
                    debugger
                    container.html(getTemplate(data))

                }
            )

        var getTemplate = function (data) {
            var req = JSON.parse(JSON.stringify(data))
            var btyhtml = $.each(req.data, function (key, notice){
                // console.log(notice.logo)
                return `
                    <div class="row f-col">
                        <div class="col-md-4">
                            <div class="bloque-new item-center">
                                <a class="img-responsive">
                                    {{-- TODO: cuando los logos se alojen en la nueva aplataforma, se va a cambiar esta url --}}
                                  <img src="http://sistema.opemedios.com.mx/data/fuentes/${notice.logo}" alt="${notice.nombre}">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h4 class="f-h4 text-muted">
                                ${notice.nombre}
                            </h4>
                            <h3 class="f-h3">
                                ${notice.encabezado}
                            </h3>
                            <p class="text-muted f-p">
                                 ${notice.empresa } | Autor: ${notice.autor}
                            </p>
                        </div>
                    </div>
                `
            })


            // return $.each(data, function(notice) {
            //     return `
            //             <div class="row f-col">
            //                 <div class="col-md-4">
            //                     <div class="bloque-new item-center">
            //                         <a class="img-responsive">
            //                             {{-- TODO: cuando los logos se alojen en la nueva aplataforma, se va a cambiar esta url --}}
            //                           <img src="http://sistema.opemedios.com.mx/data/fuentes/${notice.logo}" alt="${notice.nombre}">
            //                         </a>
            //                     </div>
            //                 </div>
            //                 <div class="col-md-8">
            //                     <h4 class="f-h4 text-muted">
            //                         ${notice.nombre}
            //                     </h4>
            //                     <h3 class="f-h3">
            //                         ${notice.encabezado}
            //                     </h3>
            //                     <p class="text-muted f-p">
            //                          ${notice.empresa } | Autor: ${notice.autor}
            //                     </p>
            //                 </div>
            //             </div>
            // `})
        }

   })    



})
