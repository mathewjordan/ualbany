import MobileNav from '../components/MobileNav'

export default {
  init() {
    // JavaScript to be fired on all pages

      $('.program-slides').slick({
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows: false,
          fade: true,
          autoplay: true,
          autoplaySpeed: 5000,
          asNavFor: '.slick-thumbs',
      });

      $('.slick-thumbs').slick({
          slidesToShow: 3, // 3,
          slidesToScroll: 1,
          asNavFor: '.program-slides',
          dots: true,
          centerMode: true,
          focusOnSelect: true,
      });
    
    new MobileNav();
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
