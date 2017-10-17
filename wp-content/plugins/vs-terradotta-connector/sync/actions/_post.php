<?php

function sync_post_handler() {

  $type = $_POST['post_type'];
  $name = $_POST['name'];
  $key  = $_POST['unique_key'];
  $val  = $_POST['unique_val'];

  // sanitize titles for query
  if ($type != 'program') {
    $val = sanitize_title_for_query($val);
  } else {
    // nada
  }

  // query for post to see if exists
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

  // if exists, update
  if ($posts) {

    $p = $posts[0];

    // run update
    $update_post = [
      'ID'         => $p->ID,
      'post_title' => $name,
    ];

    // Update the post into the database
    wp_update_post($update_post);

    $wp_post_id = $p->ID;

  }

  // if NOT exists, create
  else {

    // create new
    $new_post = [
      'post_type'   => $type,
      'post_title'  => $name,
      'post_status' => 'publish',
    ];

    $post_id = wp_insert_post($new_post);

    // set unique val for new program post
    update_field($key, $val, $post_id);

    $wp_post_id = $post_id;
  }


  if ($_POST['data_chunk']) {

    $region  = $_POST['data_chunk']['PROGRAM_REGION'];
    $country  = $_POST['data_chunk']['PROGRAM_COUNTRY'];

    $region_list  = $_POST['data_chunk']['REGION_LIST'];
    $country_list  = $_POST['data_chunk']['COUNTRY_LIST'];

    // set region relationship
    foreach ($region_list as $k => $f) {
      if (in_array($region, $f)) {
        update_post_meta($wp_post_id, 'program_region', $region_list[$k][0]);
      }
    }

    // set country relationship
    foreach ($country_list as $k => $f) {
      if (in_array($country, $f)) {
        update_post_meta($wp_post_id, 'program_country', $country_list[$k][0]);
      }
    }

  }

  print $wp_post_id;

  wp_die(); // just to be safe
}

add_action('wp_ajax_sync_post_action', 'sync_post_handler');
add_action('wp_ajax_nopriv_sync_post_action', 'sync_post_handler')

?>