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
/*-----------------------------> Scroll anchor <-----------------------------*/
$('.scroll-to a').click( function(e){
    // Prevent a page reload when a link is pressed
    e.preventDefault();
    // Call the scroll function
    goToByScroll(this.id);
});
// This is a functions that scrolls to #{blah}link
function goToByScroll(id) {
    // Remove "link" from the ID
    id = id.replace("link", "");
    console.log(id);
    // Scroll
    $('html,body').animate({
        scrollTop: -150 + $("#" + id).offset().top
    }, 'slow');
}
});
