<?php

namespace App;

/**
* ACF JSON for Sage Folder hierarchy
*/
add_filter('acf/settings/save_json', function ( $path ) {

return get_stylesheet_directory() . '/assets/acf-json';
});

add_filter('acf/settings/load_json', function ( $paths ) {

unset($paths[0]);

$paths[] = get_stylesheet_directory() . '/assets/acf-json';

return $paths;
});