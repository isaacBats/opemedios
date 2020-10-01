jQuery(document).ready(function($) {
$('.sidebar-left').css("max-height", $(window).height() - $('header').height() +"px");
$('.sidebar-left').css("padding-bottom", $('footer').height() + 70 +"px");
/*-----------------------------> Home menu are transparent and is hover background <-----------------------------*/
$('.home .expertos').css("margin-top","-"+$('header nav').height()+"px");
/*-----------------------------> Home accordion <-----------------------------*/
$('.accordion-h a').click( function(){
    $('.accordion-open').removeClass('uk-padding-large');
    $('.accordion-open').removeClass('uk-flex-column');
    $('.accordion-open').removeClass('accordion-open');
    $('.accordion-h a').removeClass('fade-in');
    $('.accordion-h p').removeClass('fade-in');
    $(this).parent().addClass('accordion-open');
    $(this).parent().addClass('uk-padding-large');
    $(this).parent().addClass('uk-flex-column');
    $(this).addClass('fade-in');
    $(this).next().addClass('fade-in');
});
/**/
$('#doc #lightbox a').click( function(){
    if( $('#doc img.img-responsive').attr('src') ){
        const img = new Image();
        img.src = $('#doc img.img-responsive').attr('src');
        img.onload = function() {
            console.log( this.height );
            if( this.height > $(window).height() ){ 
               $('body').addClass('img-top-lightbox');
            }
        }
    }
});
/**/
if( $(window).width() < 960 ){
    $('#menu-sitio').attr("uk-offcanvas","mode: push; overlay: true;");
    $('#menu-sitio ul.uk-navbar-nav').addClass("uk-offcanvas-bar");
}
$(window).resize( function(){
    if( $(window).width() < 960 ){
        $('#menu-sitio').attr("uk-offcanvas","mode: push; overlay: true;");
        $('#menu-sitio ul.uk-navbar-nav').addClass("uk-offcanvas-bar");
    }
    else{
        $('#menu-sitio').removeClass("uk-offcanvas");
        $('#menu-sitio').removeAttr("uk-offcanvas");
        $('#menu-sitio ul.uk-navbar-nav').removeClass("uk-offcanvas-bar");
    }
});
});
