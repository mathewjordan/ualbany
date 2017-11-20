/*global jQuery*/
import TestimonialPanels from './components/TestimonialPanels'

jQuery(function(){

    let $testimonialPanels = jQuery('.component-testimonial-panels-wrap');

    if( $testimonialPanels.length ) {
        new TestimonialPanels();
    }
});