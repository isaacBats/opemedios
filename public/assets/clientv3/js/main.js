$(function($) {

  "use strict";


  /*=========================== preloader ===========================*/
  // Wait for window load
  $(window).on('load', function() {
     $(".se-pre-con").fadeOut("slow");;
  });

  /*=========================== preloader ===========================*/

  /*=========================== meanmenu active ===========================*/
  
  $('.mean-menu').meanmenu({
      meanScreenWidth: "992"
   });
/*=========================== meanmenu close ===========================*/

/*=========================== sticky menu active ===========================*/
$(window).on('scroll', function() {
    if ($(this).scrollTop() > 100) {
        $('.navbar-area').addClass("is-sticky");
    } else {
        $('.navbar-area').removeClass("is-sticky");
    }
});
/*=========================== sticky menu close ===========================*/


  /*=========================== poup search ===========================*/

 
$('a[href="#search"]').on('click', function(event) {
        event.preventDefault();
        $('#search').addClass('open');
        $('#search > form > input[type="search"]').focus();
    });
    
    $('#search, #search button.close').on('click keyup', function(event) {
        if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
            $(this).removeClass('open');
        }
    });
    
/*=========================== poup search ===========================*/


/*=========================== click to top ===========================*/
  // ===== Scroll to Top ==== 
  $(window).scroll(function() {
      if ($(this).scrollTop() >= 100) {        // If page is scrolled more than 100px
          $('#return-to-top').fadeIn(200);    // Fade in the arrow
      } else {
          $('#return-to-top').fadeOut(200);   // Else fade out the arrow
      }
  });
  $('#return-to-top').on('click',function() {      // When arrow is clicked
      $('body,html').animate({
          scrollTop : 0                       // Scroll to top of body
      }, 500);
  });

  /*=========================== click to top ===========================*/

   /*=========================== country flag  active ===========================*/
      //country flag
      $('#options').flagStrap({
        countries: {
            "AU": "Australia",
            "FR": "France",
            "US": "English"
        },
        buttonSize: "btn-sm",
        buttonType: "btn-info",
        labelMargin: "10px",
        scrollable: false,
        scrollableHeight: "350px"
      });
   /*=========================== close country flag  active ===========================*/

     /*=========================== quantity add  active ===========================*/
     $('.quantity-button').off('click').on('click', function () {
    
        if ($(this).hasClass('quantity-add')) {
          var addValue = parseInt($(this).parent().find('input').val()) + 1;
              $(this).parent().find('input').val(addValue).trigger('change');
          }
    
          if ($(this).hasClass('quantity-remove')) {
          var removeValue = parseInt($(this).parent().find('input').val()) - 1;
              if( removeValue == 0 ) {
            removeValue = 1;
              }
              $(this).parent().find('input').val(removeValue).trigger('change');
          }
    
        });
  
/*=========================== close quantity add  active ===========================*/


/*=========================== modal video player  active ===========================*/
  
    //modal video play
    var $videoSrc;  
    $('.video-btn').on('click',function() {
        $videoSrc = $(this).data( "src" );
    });
  
    $('#myModalVideo').on('shown.bs.modal', function (e) {
        $("#video").attr('src',$videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0" ); 
    })
    $('#myModalVideo').on('hide.bs.modal', function (e) {
        $("#video").attr('src',$videoSrc); 
    }) 
  /*=========================== close modal video player  active ===========================*/

   /*=========================== Testimonial active ===========================*/
   $('.testimonial-slider-slick').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    focusOnSelect: true,
    dots:true,
    autoplay: false,
    autoplaySpeed: 5000,
    appendDots: $('.custom-paging-testi'),
    responsive: [{
        breakpoint: 767,
        settings: {
          autoplay:false
        }
      }, {
        breakpoint: 420,
        settings: {
          autoplay:false
      }
    }]
  });
  $('a[data-slide]').click(function(e) {
    e.preventDefault();
    var slideno = $(this).data('slide');
    $('.testimonial-slider-slick').slick('slickGoTo', slideno - 1);
  });

  /*=========================== close Testimonial active ===========================*/

     /*=========================== portfolio slider ===========================*/
     $('.portfolio-slider-wrap').slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      arrows: true,
      prevArrow:'<button class="prev-port"><i class="bx bx-arrow-back"></i></button>',
      nextArrow:'<button class="next-port"><i class="bx bx-arrow-back bx-rotate-180" ></i></button>',
      focusOnSelect: true,
      dots:false,
      autoplay: false,
      autoplaySpeed: 5000,
      responsive: [{
          breakpoint: 1200,
          settings: {
            slidesToShow: 3,
          }
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 2,
        }
      }, {
          breakpoint: 720,
          settings: {
            slidesToShow: 1,
        }
      }
    ]
    });
  
/*=========================== close portfolio slider ===========================*/

/*=========================== partner slider ===========================*/
$('.partner-logo-slider').slick({
  slidesToShow: 5,
  slidesToScroll: 1,
  arrows: false,
  focusOnSelect: true,
  dots:false,
  autoplay: false,
  autoplaySpeed: 5000,
  responsive: [{
      breakpoint: 992,
      settings: {
        slidesToShow: 3,
        autoplay: true,
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 2,
        autoplay: true,
    }
  }, {
      breakpoint: 420,
      settings: {
        slidesToShow: 1,
        autoplay: true,
    }
  }
]
});

/*=========================== close partner slider ===========================*/

/*=========================== Portfolio slider ===========================*/
  $('.portfolio-item-slider').slick({
    arrows: false,
    cssEase: 'cubic-bezier(0.7, 0, 0.3, 1)',
    slidesToShow: 1,
    centerMode: true,
    centerPadding: '25%',
    responsive: [
    {
      breakpoint: 1100,
      settings: {
        slidesToShow: 1,
        centerMode: true,
        centerPadding: '20%'
      }
    },
    {
      breakpoint: 991,
      settings: {
        slidesToShow: 1,
        centerMode: true,
        centerPadding: '10%'
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        centerPadding: '5%'
      }
    }
  ]
  });
  
  $(document).on('click', '.prevSlide', function(){
    $('.portfolio-item-slider').slick('slickPrev');
  });
  
  $(document).on('click', '.nextSlide', function(){
    $('.portfolio-item-slider').slick('slickNext');
  });
    
  $(document).on('click', '.filter-option-portfolio li a', function(){
      $('.filter-option-portfolio li a').removeClass('active');
        $(this).addClass('active');

        var cat = $(this).attr('data-category');

        if(cat !== 'all'){
          $('.portfolio-item-slider').slick('slickUnfilter');

          $('.portfolio-item-slider li').each(function(){
            $(this).removeClass('slide-shown');
          });

          $('.portfolio-item-slider li[data-match='+ cat +']').addClass('slide-shown');

          $('.portfolio-item-slider').slick('slickFilter', '.slide-shown');
        }
    
        else{
          $('.portfolio-item-slider li').each(function(){
            $(this).removeClass('slide-shown');
          });
          $('.portfolio-item-slider').slick('slickUnfilter');
        }
    });
/*=========================== close Portfolio slider ===========================*/

/*=========================== portfolio slider ===========================*/
  $('.testimonial-slider-v3').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: true,
      prevArrow:'.prev-testim',
      nextArrow:'.next-testim',
      focusOnSelect: true,
      dots:false,
      autoplay: false,
      autoplaySpeed: 5000,
      responsive: [{
          breakpoint: 1200,
          settings: {
            slidesToShow: 1,
          }
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 1,
        }
      }, {
          breakpoint: 720,
          settings: {
            slidesToShow: 1,
        }
      }
    ]
    });
  
/*=========================== close portfolio slider ===========================*/

/*=========================== similar slider ===========================*/
$('.similar-slider-wrap').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  arrows: true,
  prevArrow:'.prev-similar',
  nextArrow:'.next-similar',
  focusOnSelect: true,
  dots:false,
  autoplay: false,
  autoplaySpeed: 5000,
  infinite: false,
  responsive: [{
      breakpoint: 992,
      settings: {
        slidesToShow: 2,
        autoplay: true,
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 1,
        autoplay: true,
    }
  }, {
      breakpoint: 420,
      settings: {
        slidesToShow: 1,
        autoplay: true,
    }
  }
]
});

/*=========================== close similar slider ===========================*/

/*=========================== testimonial slider v3.1 ===========================*/
$('.testimonial-slider-v3_1').slick({
  slidesToShow: 2,
  slidesToScroll: 1,
  arrows: false,
  focusOnSelect: true,
  dots:true,
  autoplay: false,
  autoplaySpeed: 5000,
  responsive: [{
      breakpoint: 992,
      settings: {
        slidesToShow: 2,
        autoplay: true,
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 1,
        autoplay: true,
    }
  }, {
      breakpoint: 420,
      settings: {
        slidesToShow: 1,
        autoplay: true,
    }
  }
]
});

/*=========================== close testimonial slider v3.1 ===========================*/

/*=========================== testimonial slider v3.1 ===========================*/
$('.testimonial-slider-v3_2').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: true,
  prevArrow:'<button class="prev-testi_v3"><i class="bx bx-arrow-back"></i></button>',
  nextArrow:'<button class="next-testi_v3"><i class="bx bx-arrow-back bx-rotate-180" ></i></button>',
  focusOnSelect: true,
  dots:false,
  autoplay: false,
  autoplaySpeed: 5000,
});

/*=========================== close testimonial slider v3.1 ===========================*/

/*=========================== products details image active ===========================*/
$('.product-main-image-slider').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  fade: true,
  asNavFor: '.product-navigation-slider',
  touchMove: false,
  verticalSwiping:true,
  focusOnSelect: true,
});
$('.product-navigation-slider').slick({  
  slidesToShow: 4,
  slidesToScroll: 1,
  asNavFor: '.product-main-image-slider',
  dots: false,
  arrows: false,
  centerMode: false,
  focusOnSelect: true,
  vertical:true,
  swipe: false,
  responsive: [
    {
        breakpoint: 992,
        settings: {
          vertical: true,
        }
    },
    {
      breakpoint: 768,
      settings: {
        vertical: false,
        slidesToShow: 4,
      }
    },
    {
      breakpoint: 580,
      settings: {
        vertical: false,
        slidesToShow: 3,
      }
    },
    {
      breakpoint: 380,
      settings: {
        vertical: false,
        slidesToShow: 3,
      }
    }
  ]
  
});
/*=========================== close products details image active ===========================*/

/*=========================== similar slider ===========================*/
$('.related-products-slider').slick({
  slidesToShow: 4,
  slidesToScroll: 1,
  arrows: true,
  prevArrow:'.prev-rlts',
  nextArrow:'.next-rlts',
  focusOnSelect: true,
  dots:false,
  autoplay: false,
  autoplaySpeed: 5000,
  infinite: false,
  responsive: [{
      breakpoint: 1100,
      settings: {
        slidesToShow: 3,
        autoplay: true,
      }
    },
    {
      breakpoint: 991,
      settings: {
        slidesToShow: 2,
        autoplay: true,
    }
  }, {
      breakpoint: 500,
      settings: {
        slidesToShow: 1,
        autoplay: true,
    }
  }
]
});

/*=========================== close similar slider ===========================*/

/*=========================== price range ui active ===========================*/
if(document.getElementById('slider-range') != null ){ 
  $( "#slider-range" ).slider({
    range: true,
    min: 0,
    max: 500,
    values: [ 100, 250 ],
    slide: function( event, ui ) {
    $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
    }
  });
  $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
    " - $" + $( "#slider-range" ).slider( "values", 1 ) );
}
if(document.getElementById('slider-range2') != null ){ 
  $( "#slider-range2" ).slider({
    range: true,
    min: 0,
    max: 500,
    values: [ 100, 250 ],
    slide: function( event, ui ) {
    $( "#amount2" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
    }
  });
  $( "#amount2" ).val( "$" + $( "#slider-range2" ).slider( "values", 0 ) +
    " - $" + $( "#slider-range2" ).slider( "values", 1 ) );
}
 /*===========================close price range ui active ===========================*/

 // ------------------------------- AOS Animation 
        AOS.init({
          duration: 1000,
          mirror: false,
          disable: function() {
            var maxWidth = 1100;
            return window.innerWidth < maxWidth;
          }
        
        });



});

