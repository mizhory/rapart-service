$(function () {
  /* $('#fullpage').fullpage({
    navigation: true,
    responsiveWidth: 768,
    scrollBar: true,
    scrollingSpeed: 1200,
    responsiveHeight: 600,
    verticalCentered: true,
  });
*/
  new WOW().init({
    mobile: false,
  });

  // Menu top fixed
  var shrinkHeader = 100;
  $(window).scroll(function () {
    var scroll = getCurrentScroll();
    if (scroll >= shrinkHeader) {
      $('.header-nav').addClass('shrink');
    }
    else {
      $('.header-nav').removeClass('shrink');
    }
  });
  function getCurrentScroll() {
    return window.pageYOffset || document.documentElement.scrollTop;
  }

  // Toggle menu
  $(".toggle").click(function () {
    $(this).closest("body").toggleClass("toggle-active");
  });

  // Slider advantages
  $('.advantages__slide').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: true,
    prevArrow: '<div class="arrow arrow1"></div>',
    nextArrow: '<div class="arrow arrow2"></div>',
    responsive: [
      {
        breakpoint: 1100,
        settings: {
          slidesToShow: 2,
        }
      },
      {
        breakpoint: 850,
        settings: {
          slidesToShow: 1,
        }
      }
    ]
  });

  $('.popup').magnificPopup({
    type: 'inline',
    fixedContentPos: false,
    fixedBgPos: true,
    overflowY: 'auto',
    closeBtnInside: true,
    preloader: false,
    midClick: true,
    removalDelay: 300,
    mainClass: 'my-mfp-zoom-in'
  });

  $('.image-popup-vertical-fit').magnificPopup({
    type: 'image',
    closeOnContentClick: true,
    mainClass: 'mfp-img-mobile',
    image: {
      verticalFit: true
    }

  });

	$(".product__btn").on('click', function(event){
		var id = $(this).data("id")
		var quantity   = $('#myForm'+id).serialize();

			$.ajax({
			  type: "POST",
			  url: "/ajax/add_cart.php",
			  data: 'id='+id+'&quantity='+quantity,
			  success: function(msg){
			    //alert( "Прибыли данные: " + msg );
			  }
			});

		});	

	$(".shop-product__btn").on('click', function(event){
	var id = $(this).data("id")
	var quantity   = $(".product__value_num").val();
		$.ajax({
		  type: "POST",
		  url: "/ajax/add_cart.php",
		  data: 'id='+id+'&quantity='+quantity,
		  success: function(msg){

			//alert( "Прибыли данные: " + msg );
		  }
		});
	});

$('.product__delete').click(function(){
    var id=$(this).data("id");
    $.get(
        "/ajax/removeBasked.php",
        {
            id: id
        },
        function (data) {
            location.reload();
        }
    );
    return false;
}); 



$(function() {
  // Owl Carousel
  var owl = $(".owl-carousel");
  owl.owlCarousel({
    items: 2,
    margin: 10,
    loop: true,
    nav: false
  });
});



/* изменение количества в корзине
$('.product__value_plus').on('click', function() {

  count = parseInt( $('.product__value_num').val() );

  $('.product__value_num').val(count);
  updatePrice(count);
});

$('.product__value_minus').on('click', function() {

  count = parseInt( $('.product__value_num').val() );


  $('.product__value_num').val(count);
  updatePrice(count);
});

function updatePrice(count) {

  $('.quant').text(count);
}
*/


  // var isPhoneDevice = "ontouchstart" in document.documentElement;
  // $(document).ready(function () {
  //   if (isPhoneDevice) {
  //     //mobile
  //   }
  //   else {
  //     //desktop               
  //     $.fn.fullpage();
  //   }
  // });

});