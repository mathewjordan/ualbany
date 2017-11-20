<?php
/**
 * @var string $temp_key
 */

use VC\PageBuilder\Core;

$content_path = VC_PAGE_BUILDER_PLUGIN_PATH . '/components/content';
$content = [];

foreach (glob("$content_path/*.php") as $filename)
{
    if( Core\content_allowed_in_column( $filename, $temp_key ) ) {
        $content[] = include $filename;
    }
}

return apply_filters( 'VC_PAGE_BUILDER_FILTER_CONTENT', $content );