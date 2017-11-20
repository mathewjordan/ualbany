<?php
/**
 * @var array $content
 */

$shortcode = ! empty( $content['shortcode'] ) ? $content['shortcode'] : null; ?>
<div class="component-shortcode-wrap component-wrap">
    @if( $shortcode )
        @include( 'partials.components.elements.shortcode', [
            'shortcode' => $shortcode
        ] )
    @endif
</div>