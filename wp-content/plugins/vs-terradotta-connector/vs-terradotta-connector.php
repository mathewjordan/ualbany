<?php
/*
Plugin Name: Terra Dotta Connector by Verified Studios
Plugin URI: http://verifiedstudios.com
Description: Connects to a Terra Dotta instance and syncs content hourly.
Version: 0.3.0
Author: Verified Studios
Author URI: http://verifiedstudios.com
*/

define("TERRADOTTA_URL", "http://ualbany.studioabroad.com/piapi/index.cfm", TRUE);

// sync data
function terradotta_sync() {

  /*
   * programs
   */

  $get_programs = TERRADOTTA_URL . '?callName=getPrograms&ResponseEncoding=JSON';
  ?>
    <script type="text/javascript">

      function getUniqueVals(data, uniqueKey) {

        var lookup = {};
        var items = data;
        var result = [];

        for (var item, i = 0; item = items[i++];) {

          var name = item[uniqueKey];

          if (!(name in lookup)) {
            lookup[name] = 1;
            result.push(name);
          }
        }
        return result;
      }

      function _cb_getPrograms(td) {

        var regions = getUniqueVals(td.PROGRAM, 'PROGRAM_REGION');
        console.log(regions);

        var countries = getUniqueVals(td.PROGRAM, 'PROGRAM_COUNTRY');
        console.log(countries);

//        var cities = getUniqueVals(td.PROGRAM,'PROGRAM_CITY');
//        console.log(cities);

        mapTerraDotta = jQuery.noConflict();
        mapTerraDotta(function ($) {

          $.each(td.PROGRAM, function () {
            var program_data = this;

            $.ajax({
              url: ajaxurl,
              method: "POST",
              data: {
                'action': 'sync_post_action',
                'post_type': 'program',
                'unique_key': 'program_id',
                'unique_val': program_data.PROGRAM_ID,
                'name': program_data.PROGRAM_NAME,
                'data_chunk': program_data
              },
              beforeSend: function () {
              }
            }).done(function (data) {
              console.log(data);
            });
            // end ajax

          });
          // end each

          $.each(regions, function (index, value) {

            console.log(value);
            var region_name = value;

            $.ajax({
              url: ajaxurl,
              method: "POST",
              data: {
                'action': 'sync_post_action',
                'post_type': 'region',
                'unique_key': 'region_id',
                'unique_val': region_name,
                'name': region_name
              },
              beforeSend: function () {
              }
            }).done(function (data) {
              console.log(data);
            });
            // end ajax

          });
          // end each

          $.each(countries, function (index, value) {

            console.log(value);
            var country_name = value;

            $.ajax({
              url: ajaxurl,
              method: "POST",
              data: {
                'action': 'sync_post_action',
                'post_type': 'country',
                'unique_key': 'country_id',
                'unique_val': country_name,
                'name': country_name
              },
              beforeSend: function () {
              }
            }).done(function (data) {
              console.log(data);
            });
            // end ajax

          });
          // end each

        });
        // end program mapping

      }

    </script>
    <script src="<?php echo $get_programs; ?>" type="text/javascript"></script>
  <?php

}

add_action('wp_ajax_sync_post_action', 'sync_post_handler');

function sync_post_handler() {

  $type = $_POST['post_type'];
  $name = $_POST['name'];
  $key  = $_POST['unique_key'];
  $val  = $_POST['unique_val'];

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
      'ID'         => $p->ID,
      'post_title' => $name,
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

  wp_die(); // just to be safe
}


/*
 * job scheduling
 */


register_activation_hook(__FILE__, 'vs_activation');

function vs_activation() {
  terradotta_init();
  if (!wp_next_scheduled('vs_hourly_event')) {
    wp_schedule_event(time(), 'hourly', 'vs_hourly_event');
  }
}

register_deactivation_hook(__FILE__, 'vs_deactivation');

function vs_deactivation() {
  wp_clear_scheduled_hook('vs_hourly_event');
}

add_action('vs_hourly_event', 'terradotta_hourly');

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

// update sync time
function terradotta_hourly() {

  global $wpdb;
  $stamp = time();
  $wpdb->update(
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

  // run sync and update
  terradotta_sync();

}

/*
 * Admin page
 */

add_action('admin_menu', 'vs_terradotta_connector_plugin_setup_menu');

function vs_terradotta_connector_plugin_setup_menu() {
  add_menu_page('Terra Dotta Connector', 'Terra Dotta', 'manage_options', 'terradotta', 'terradotta_admin');
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





