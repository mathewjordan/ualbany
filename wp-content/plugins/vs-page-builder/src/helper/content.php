<?php

namespace VC\PageBuilder\Core;

function content_allowed_in_column($filename, $column)
{
    $path_info = pathinfo( $filename );

    switch( $column )
    {
        case VC_PAGE_BUILDER_COLUMN_ONE:
            return true;
            break;
        //Certain content can only be rendered in one full column
        case VC_PAGE_BUILDER_COLUMN_TWO:
        case VC_PAGE_BUILDER_COLUMN_THREE:
        case VC_PAGE_BUILDER_COLUMN_FOUR:

            $required_full_column = apply_filters( 'VC_PAGE_BUILDER_FILTER_CONTENT_ALLOWED_IN_COLUMNS', [
                'testimonial_panels',
            ] );

            return ! in_array( $path_info['filename'], $required_full_column );

            break;
    }

    return true;
}

function extract_text_from_acf($post_id)
{
    //$post_id
}