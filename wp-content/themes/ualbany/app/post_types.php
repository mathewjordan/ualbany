<?php

namespace App;

// register custom post types by array

$post_types = [
  'Program' => [
    'machine_name' => 'program',
    'singlular'    => 'Program',
    'plural'       => 'Programs',
    'slug'       => 'programs',
    'icon'       => 'dashicons-feedback'
  ],
  'Country' => [
    'machine_name' => 'country',
    'singlular'    => 'Country',
    'plural'       => 'Countries',
    'slug'       => 'countries',
    'icon'       => 'dashicons-location-alt'
  ],
  'Region' => [
    'machine_name' => 'region',
    'singlular'    => 'Region',
    'plural'       => 'Regions',
    'slug'       => 'regions',
    'icon'       => 'dashicons-admin-site'
  ],
  'Subject' => [
    'machine_name' => 'subject',
    'singlular'    => 'Subject',
    'plural'       => 'Subjects',
    'slug'       => 'subjects',
    'icon'       => 'dashicons-book-alt'
  ],
  'Faculty & Staff' => [
    'machine_name' => 'fs',
    'singlular'    => 'Faculty & Staff',
    'plural'       => 'Faculty & Staff',
    'slug'       => 'faculty-staff',
    'icon'       => 'dashicons-id-alt'
  ],
];

register_posts($post_types);

function register_posts($post_types) {

  foreach ($post_types as $key => $type) {

    $labels = [
      'name'               => __($type['plural'], 'post type general name', 'ualbany'),
      'singular_name'      => __($type['singular'], 'post type singular name', 'ualbany'),
      'add_new'            => __('Add New', 'Add New', 'ualbany'),
      'add_new_item'       => __('Add New ' . $type['singular'], 'ualbany'),
      'edit_item'          => __('Edit ' . $type['singular'], 'ualbany'),
      'new_item'           => __('New ' . $type['singular'], 'ualbany'),
      'view_item'          => __('View ' . $type['singular'], 'ualbany'),
      'search_items'       => __('Search ' . $type['plural'], 'ualbany'),
      'not_found'          => __('No ' . $type['plural'] . ' found', 'ualbany'),
      'not_found_in_trash' => __('No ' . $type['plural'] . ' found in Trash', 'ualbany'),
      'parent_item_colon'  => '',
    ];

    $post_type_args = [
      'labels'             => $labels,
      'singular_label'     => __($type['singular'], 'ualbany'),
      'public'             => TRUE,
      'show_ui'            => TRUE,
      'publicly_queryable' => TRUE,
      'query_var'          => TRUE,
      'capability_type'    => 'post',
      'has_archive'        => TRUE,
      'hierarchical'       => TRUE,
      'rewrite'            => [
        'slug'       => $type['slug'],
        'with_front' => TRUE,
      ],
      'supports'           => [
        'title',
        'thumbnail',
        'excerpt',
        'editor',
        'revisions',
      ],
      'menu_position'      => 20,
      'menu_icon'          => $type['icon'],
      'taxonomies'         => [],
    ];

    register_post_type($type['machine_name'], $post_type_args);

  }

}

add_action( 'pre_get_posts', function ($query){
  if(is_archive()):
    $query->set( 'order', 'ASC' );
    $query->set( 'orderby', 'title' );
    $query->set( 'posts_per_page', '-1' );
  endif;
});

add_action('admin_head', function() {



  ?>
  <script>
    jQuery(document).ready(function ($) {
      $('.post-type-program #title').attr('disabled','disabled');
      $('.post-type-region #title').attr('disabled','disabled');
      $('.post-type-country #title').attr('disabled','disabled');
      $('.post-type-program .inline-edit-row fieldset').hide();
      $('.post-type-region .inline-edit-row fieldset').hide();
      $('.post-type-country .inline-edit-row fieldset').hide();
    });
  </script>
  <style>
    .acf-field-program-td-format,
    .acf-field-program-description,
    .acf-field-program-accommodations,
    .acf-field-program-costs,
    .acf-field-program-selection,
    .acf-field-program-excursions,
    .acf-field-program-testimonials,
    .acf-field-program-location,
    .acf-field-program-duration,
    .acf-field-program-overview
    {
      display: none !important;
    }
    #acf-program_location {
      background-color: rgba(255,255,255, 0.65);
    }
    #acf-program_location .hndle {
       background-color: rgba(255,255,255, 1);
    }
    .acf-field-program-region .acf-input,
    .acf-field-program-country .acf-input {
      z-index: -1;
     }
  </style>
  <?php

});