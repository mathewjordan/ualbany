<?php
/*
Plugin Name: Terra Dotta Connector by Verified Studios
Plugin URI: http://verifiedstudios.com
Description: Connects to a Terra Dotta instance and syncs content hourly.
Version: 0.3.0
Author: Verified Studios
Author URI: http://verifiedstudios.com
*/

define("TERRADOTTA_URL", "http://ualbany.studioabroad.com/piapi/index.cfm", true);

// sync data
function terradotta_sync() {

  /*
   * programs
   */

  sync_post('program','Unique Program Updated Name', 'program_id', '676');

  $get_programs = TERRADOTTA_URL . '?callName=getPrograms&ResponseEncoding=JSON';
  ?>
  <script type="text/javascript">
    function _cb_getPrograms(data) {
      // mapping
      mapPrograms = jQuery.noConflict();
      mapPrograms(function($) {
        $.each(data.PROGRAM, function() {
          console.log(this);

          $.ajax({
            method: "POST",
            url: ajaxurl,
            data: {
              'action': actionFunction,
              'import': v,
              'code': syncID
            }
            success: function (output) {
              console.log('bueno');
            }
          });

          $.each(this, function(k, v) {
          });
        });
      });
    }

  </script>
  <script src="<?php echo $get_programs; ?>" type="text/javascript"></script>
  <?php

}

function sync_post($type, $name, $key, $val) {

  $args  = [
    'meta_query'     => [
      [
        'key'   => $key,
        'value' => $val,
      ],
    ],
    'post_type'      => $type,
    'posts_per_page' => 1,
  ];
  $posts = get_posts($args);

  if ($posts) {

    $p = $posts[0];

    // run update

    $update_post = [
      'ID'           => $p->ID,
      'post_title'   => $name
    ];

    // Update the post into the database
    wp_update_post($update_post);

  }
  else {

    // create new

    $new_post = [
      'post_type'   => $type,
      'post_title'  => $name,
      'post_status' => 'publish',
    ];

    $post_id = wp_insert_post($new_post);
    update_field($key, $val, $post_id);
  }

}


/*
 * job scheduling
 */


register_activation_hook(__FILE__, 'vs_activation');

function vs_activation() {
  terradotta_init();
  if (! wp_next_scheduled ( 'vs_hourly_event' )) {
    wp_schedule_event(time(), 'hourly', 'vs_hourly_event');
  }
}

register_deactivation_hook(__FILE__, 'vs_deactivation');

function vs_deactivation() {
  wp_clear_scheduled_hook('vs_hourly_event');
}

add_action('vs_hourly_event', 'terradotta_hourly');

// init insert of sync time
function terradotta_init () {

  global $wpdb;
  $stamp = time();
  $wpdb->insert(
    'wp_options',
    array(
      'option_name' => 'vs_terradotta_sync',
      'option_value' => $stamp
    ),
    array(
      '%s',
      '%s'
    )
  );

  terradotta_sync();

}

// update sync time
function terradotta_hourly () {

  global $wpdb;
  $stamp = time();
  $wpdb->update(
    'wp_options',
    array(
      'option_name' => 'vs_terradotta_sync',
      'option_value' => $stamp
    ),
    array(
      '%s',
      '%s'
    )
  );

  // run sync and update
  terradotta_sync();

}
/*
 * Admin page
 */

add_action('admin_menu', 'vs_terradotta_connector_plugin_setup_menu');

function vs_terradotta_connector_plugin_setup_menu(){
  add_menu_page( 'Terra Dotta Connector', 'Terra Dotta', 'manage_options', 'terradotta', 'terradotta_admin' );
}

function terradotta_admin() {
  echo "<h1>Terra Dotta</h1>";
  echo "<div class='welcome-panel'><div id='terrdotta_data'></div></div>";

  /*
   http://ualbany.studioabroad.com/piapi/index.cfm?callName=getPrograms&ResponseEncoding=JSON
   */

  echo TERRADOTTA_URL;

  terradotta_sync();

}





