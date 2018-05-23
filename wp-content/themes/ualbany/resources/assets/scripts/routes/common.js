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

      var catcher = $('#anchor-catch');
      var sticky = $('#anchor-menu');

      function isScrolledTo(elem) {
          var docViewTop = $(window).scrollTop(); //num of pixels hidden above current screen
          var elemTop = $(elem).offset().top; //num of pixels above the elem
          return ((elemTop <= docViewTop));
      }

      $(window).scroll(function() {
          if(isScrolledTo(sticky)) {
              sticky.css('position','fixed');
              sticky.css('top','15px');
          }
          var stopHeight = catcher.offset().top + catcher.height();
          if ( stopHeight > sticky.offset().top) {
              sticky.css('position','relative');
              sticky.css('top','0');
          }
      });
    
    new MobileNav();
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
