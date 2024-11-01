
	(function($){
		$(document).ready(function(){
			$('#ldups-edd-product-lists').slick({
				dots: false,
				infinite: true,
				speed: 300,
				slidesToShow: 4,
				slidesToScroll: 1,
                nextArrow: '<button type="button" class="slick-next">&#8592;</button>',
                prevArrow: '<button type="button" class="slick-prev">&#8594;</button>', 
				responsive: [
					{
					breakpoint: 1300,
					settings: {
						slidesToShow: 3,
						slidesToScroll: 3,
                        arrows:false,
						dots: true
					}
					},
					{
					breakpoint: 780,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 2,
                        arrows:false,
						dots: true
					}
					},
					{
					breakpoint: 480,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1,
                        arrows:false,
						dots: true
					}
					}
					// You can unslick at a given breakpoint now by adding:
					// settings: "unslick"
					// instead of a settings object
				]
				});

		});
	})(jQuery);
