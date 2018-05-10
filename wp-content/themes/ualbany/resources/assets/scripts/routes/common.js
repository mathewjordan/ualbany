import MobileNav from '../components/MobileNav'

export default {
  init() {
    // JavaScript to be fired on all pages
    $('.program-slides').slick({
      dots: true,
      infinite: true,
      speed: 500,
      fade: false,
      slide: 'li',
      cssEase: 'linear',
      centerMode: true,
      slidesToShow: 1,
      variableWidth: true,
      autoplay: true,
      autoplaySpeed: 4000,
      customPaging: function (slider, i) {
        return '<button class="tab">' + $('.slick-thumbs li:nth-child(' + (i + 1) + ')').html() + '</button>';
      },
    });
    
    new MobileNav();
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
