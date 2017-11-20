<?php

namespace VS\PageBuilder\Core;

/**
 * @param $file
 * @param array $data
 * @return mixed
 */
function load( $file, $data = [] )
{
    extract ( $data );

    return include ( "$file.php" );
}

/**
 * @param $name
 * @param array $data
 * @return mixed
 */
function load_element( $name, $data = [] )
{
    return load( VS_PAGE_BUILDER_PLUGIN_PATH . "components/element/$name", $data );
}

/**
 * @param $name
 * @param array $data
 * @return mixed
 */
function load_content( $name, $data = [] )
{
    return load( VS_PAGE_BUILDER_PLUGIN_PATH . "components/content/$name", $data );
}

/**
 * @param $name
 * @param array $data
 * @return mixed
 */
function load_layout( $name, $data = [] )
{
    return load( VS_PAGE_BUILDER_PLUGIN_PATH . "components/layout/$name", $data );
}