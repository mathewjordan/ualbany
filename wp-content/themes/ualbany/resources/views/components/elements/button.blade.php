<?php
/**
 * @var array $button
 */
$link           = ! empty( $link ) ? $link : null;
$text           = ! empty( $text ) ? $text : null;
$button_style   = ! empty( $button_style ) ? $button_style : null;
$button_size    = ! empty( $button_size ) ? $button_size : null;
$custom_classes = ! empty( $custom_classes ) ? $custom_classes : null;
$button_class   = VC\PageBuilder\Core\button_class( $button_style, $button_size, [ $custom_classes ] );
?>
@if($link)
<a href="{{$link}}" class="{{$button_class}}">
    {!! $text !!}
</a>
@endif
