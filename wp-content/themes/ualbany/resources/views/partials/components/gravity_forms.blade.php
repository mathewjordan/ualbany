<?php
/**
 * @var array $content
 */
$form_id = isset( $content['form'] ) ? $content['form'] : null;

$options = '';
if( ! empty( $content[ 'options' ] ) ) {
    foreach ( $content[ 'options' ] as $option )
        $options .= ' ' . $option[ 'key' ] . '=' . $option[ 'value' ];
}
?>
@if( $form_id )
<div class="component-gravity-forms-wrap component-wrap" data-form-id="{{ $form_id }}">
    @include( 'partials.components.elements.shortcode', [
        'shortcode' => "[gravityform id=$form_id $options]"
    ] )
</div>
@endif