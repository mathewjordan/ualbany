<?php

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

    $wp_post_id = $p->ID;

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

    $wp_post_id = $post_id;
  }

  print $wp_post_id;

  wp_die(); // just to be safe
}

add_action('wp_ajax_sync_post_action', 'sync_post_handler');
add_action('wp_ajax_nopriv_sync_post_action', 'sync_post_handler')

?>