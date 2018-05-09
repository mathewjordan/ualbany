import MobileNav from '../components/MobileNav'

export default {
  init() {
    // JavaScript to be fired on all pages
    $('.program-slides').slick({
      dots: true,
      slide: 'li',

      customPaging: function(slider, i) {
        var slickThumb = '<button class="tab">' + $('.slick-thumbs li:nth-child(' + (i) + ')').html() + '</button>';
        i++;
        return slickThumb;
      },
    });
    
    new MobileNav();
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
