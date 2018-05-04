import MobileNav from '../components/MobileNav'

export default {
  init() {
    // JavaScript to be fired on all pages
    $('.program-slides').slick({  dots: true });
    
    new MobileNav();
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
