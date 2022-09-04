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
jQuery(document).ready(function(){
    /*used for put a count on the themes titles*/
    $('span.count').each(function( ){
        if($("#"+$(this).attr('target')))
            $("#"+$(this).attr('target')).text( "("+$(this).text() + ")");
    });

    // spinner in off
    $('.loader').hide();
    // $('#list-news h2.theme-name').addClass("uk-hidden");
    // $('#list-news h2.theme-name').text( $( "select.opciones-temas-ajax option:selected" ).html() );





    // configuration UIkit

    if( $("ul.pagination").length ){
          $("ul.pagination").addClass("uk-pagination");
          $("ul.pagination li.active").addClass("uk-active");
          $("ul.pagination li.disabled").addClass("uk-disabled");
        }
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

          $options = {
            "offset": $("body > header").height(),
            "animation" : "uk-animation-slide-bottom",
          };
          UIkit.sticky(".sticky-this", $options);

        // change company
        $('select#select-parent').on('change', function(){
            var slug = $(this).val();
            window.location = `/cambio-empresa?slug=${slug}`
        });
})

