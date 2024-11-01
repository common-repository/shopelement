jQuery(function($){
  /*---------------------
    Logo Carousel
  ---------------------*/
  if ($('.nxtcode-product-carousel__info---').length) {
    var LogoSlider=$('.nxtcode-product-carousel__info---');
    LogoSlider.slick({
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

  /*---------------------
    Pricing Count
  ---------------------*/
  $('.nxtcode-product-view__quantity .plus').click(function () {
    var th = $(this).closest('.nxtcode-product-view__quantity').find('.qty');
    th.val(+th.val() + 1);
  });
  $('.nxtcode-product-view__quantity .minus').click(function () {
    var th = $(this).closest('.nxtcode-product-view__quantity').find('.qty');
      if (th.val() > 1) th.val(+th.val() - 1);
  });

  /*----------------------------
    Product slider
  ------------------------------ */
  $('.nxtcode-product-view__info .nxtcode-product-view__thumbnails-slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    fade: true,
    arrows: false,
    asNavFor: '.nxtcode-product-view__info .nxtcode-product-view__thumbs',
  });
  $('.nxtcode-product-view__info .nxtcode-product-view__thumbs').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    asNavFor: '.nxtcode-product-view__info .nxtcode-product-view__thumbnails-slider',
    focusOnSelect: true,
    infinite: true,
    arrows: false,
  });

  /*---------------------
    Cart Count
  ---------------------*/
  $('.nxtcode-cart__quantity .plus').click(function () {
    var th = $(this).closest('.nxtcode-cart__quantity').find('.qty');
    th.val(+th.val() + 1);
  });
  $('.nxtcode-cart__quantity .minus').click(function () {
    var th = $(this).closest('.nxtcode-cart__quantity').find('.qty');
      if (th.val() > 1) th.val(+th.val() - 1);
  });

  /*----------------------------
    Quickview Product slider
  ------------------------------ */
  $('.nxtcode-quickview__info .nxtcode-product-view__thumbnails-slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    fade: true,
    arrows: true,
    dots: true,
    asNavFor: '.nxtcode-quickview__info .nxtcode-product-view__thumbs',
  });
  $('.nxtcode-quickview__info .nxtcode-product-view__thumbs').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    asNavFor: '.nxtcode-quickview__info .nxtcode-product-view__thumbnails-slider',
    focusOnSelect: true,
    infinite: true,
    arrows: true,
  });

  // Brand logo slider
  const swiper = new Swiper('.nxtcode-brandlogo__info-one .nxtcode-brandlogo__slider--', {
    loop: true,
    autoplay: true,
    slidesPerView: 5,
    spaceBetween: 20,
    breakpoints: {
      320: {
        slidesPerView: 1,
      },
      768: {
        slidesPerView: 3,
      },
      1200: {
        slidesPerView: 5,
      }
    }
  });

  // Brand logo slider 2
  const swiper2 = new Swiper('.nxtcode-brandlogo__info-two .nxtcode-brandlogo__slider--', {
    loop: true,
    autoplay: false,
    slidesPerView: 5,
    spaceBetween: 20,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    breakpoints: {
      320: {
        slidesPerView: 1,
      },
      768: {
        slidesPerView: 3,
      },
      1200: {
        slidesPerView: 5,
      }
    }
  });


  /*----------------------------
    Customer Review Carousel
  ------------------------------ */
  /*
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
*/
});

