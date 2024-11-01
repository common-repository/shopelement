;(function($) {
    $(function() {
        /*----------------------------
            Customer Review Carousel
        ------------------------------ */
        if ($('#nxtcode-review__carousel').length) {
            var ReviewCarousel = $('#nxtcode-review__carousel');
            ReviewCarousel.slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: false,
            infinite: true,
            swipeToSlide: true,
            pauseOnHover: false,
            responsive: [
                {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3
                }
                },
                {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2
                }
                }
            ]
            });
        }
    })
}(jQuery));
