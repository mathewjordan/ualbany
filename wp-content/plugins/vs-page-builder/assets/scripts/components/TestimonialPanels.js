/*global jQuery*/
import Slider from '../core/Slider'

export default class TestimonialPanels
{
    constructor()
    {
        window.sliders = window.sliders ? window.sliders : [];

        let $sliders = jQuery('.component-testimonial-panels-wrap');

        if( $sliders.length ) {

            $sliders.each( function () {

                window.sliders.push(
                    new Slider({
                        parent: jQuery(this),
                        slideSelector: '.slider-item',
                        thumbnailSelector: '.slider-thumbnail'
                    })
                );
            } )
        }
    }
}