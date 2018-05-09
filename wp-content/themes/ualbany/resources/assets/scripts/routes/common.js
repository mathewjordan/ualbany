import MobileNav from '../components/MobileNav'

export default {
  init() {
    // JavaScript to be fired on all pages
    $('.program-slides').slick({
      dots: true,
      slide: 'li',

      customPaging: function(slider, i) {
        return '<button class="tab">' + $('.slick-thumbs li:nth-child(' + (i + 1) + ')').html() + '</button>';
      },
    });
    
    new MobileNav();
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
