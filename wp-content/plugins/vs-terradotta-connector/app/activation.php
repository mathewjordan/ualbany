<?php

/*
* activation
*/

register_activation_hook(__FILE__, 'vs_activation');

function vs_activation() {
  terradotta_init();
}

// init insert of sync time
function terradotta_init() {

  global $wpdb;
  $stamp = time();
  $wpdb->insert(
    'wp_options',
    [
      'option_name'  => 'vs_terradotta_sync',
      'option_value' => $stamp,
    ],
    [
      '%s',
      '%s',
    ]
  );

  terradotta_sync();

}

?>