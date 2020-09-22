$(document).ready(function(){
/*-----------------------------> Home menu are transparent and is hover background <-----------------------------*/
$('.home .expertos').css("margin-top","-"+jQuery('header nav').height()+"px");
/*-----------------------------> Home accordion <-----------------------------*/
$('.accordion-h a').click( function(){
    jQuery('.accordion-open').removeClass('uk-padding-large');
    jQuery('.accordion-open').removeClass('uk-flex-column');
    jQuery('.accordion-open').removeClass('accordion-open');
    jQuery('.accordion-h a').removeClass('fade-in');
    jQuery('.accordion-h p').removeClass('fade-in');
    jQuery(this).parent().addClass('accordion-open');
    jQuery(this).parent().addClass('uk-padding-large');
    jQuery(this).parent().addClass('uk-flex-column');
    jQuery(this).addClass('fade-in');
    jQuery(this).next().addClass('fade-in');
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
/*-----------------------------> SCROLL TOP <-----------------------------*/

	$(document).scroll(function() {
        scroll_pos = $(this).scrollTop();
        if(scroll_pos > 100) {
            $("header").addClass('active');
            $(".top").addClass('active');
        } else {
        	$("header").removeClass('active');
            $(".top").removeClass('active');
        }
    });
/*-----------------------------> GO TOP <-----------------------------*/

	$(document).on('click','.top',function(e) {
		var body = $("html, body");
		body.stop().animate({scrollTop:0}, 500, 'swing', function() {
		});
	});
});


