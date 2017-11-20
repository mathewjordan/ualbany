<?php

namespace VC\PageBuilder\Core;

/**
 * @param $style
 * @param string $extra_class
 * @return string
 */
function row_class($style, $extra_class = '')
{
    $default = 'row-default';

    switch( $style )
    {
        case 'light':
            return "$default row-light" . ( ! empty( $extra_class ) ? " " . $extra_class : '' );
            break;
        case 'light_2':
            return "$default row-light_2" . ( ! empty( $extra_class ) ? " " . $extra_class : '' );
            break;
        case 'dark':
            return "$default row-dark" . ( ! empty( $extra_class ) ? " " . $extra_class : '' );
            break;
        case 'inverse':
            return "$default row-inverse" . ( ! empty( $extra_class ) ? " " . $extra_class : '' );
            break;
        case 'yellow':
            return "$default row-yellow" . ( ! empty( $extra_class ) ? " " . $extra_class : '' );
            break;
        case 'blue':
            return "$default row-blue" . ( ! empty( $extra_class ) ? " " . $extra_class : '' );
            break;
    }

    return "$default $extra_class";
}

/**
 * @param $alignment
 * @return null|string
 */
function row_alignment($alignment)
{
    switch( $alignment )
    {
        case 'left':
            return "text-left";
            break;
        case 'center':
            return "text-center";
            break;
        case 'right':
            return "text-right";
            break;
    }

    return null;
}

function row_forced_classes_based_on_content($row_content)
{
    if( ! empty( $row_content ) ) {

        $class_map = apply_filters( 'VC_PAGE_BUILDER_FILTER_ROW_CLASS_MAPS', [
            'testimonial_panels' => 'row-testimonial-panels'
        ] );

        $classes = array_map( function ($content) use ($class_map) {

            if( ! empty( $class_map[ $content['acf_fc_layout'] ] ) )
                return $class_map[ $content['acf_fc_layout'] ];

            return null;

        }, $row_content );
    }

    return isset( $classes ) ? implode(' ', $classes) : '';
}