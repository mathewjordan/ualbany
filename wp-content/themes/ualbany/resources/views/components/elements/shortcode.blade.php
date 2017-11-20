<?php
/**
 * @var string $shortcode
 */
?>
@if( $shortcode )
    <div data-shortcode="{{ esc_attr( $shortcode ) }}">
        @php( $html = do_shortcode( $shortcode ) )
        {!! $html !!}
    </div>
@endif
