<?php

namespace App;

add_image_size( 'sf_thumb', '200', '250', true);
add_image_size( 'sf_main', '480', '600', true);

function block_size_class($count)
{
  switch( $count )
  {
    case 1:
      return [ 'col-sm-6 col-md-4 offset-md-4' ];
      break;
    case 2:
      return [ 'col-sm-6 col-md-4 offset-md-2', 'col-sm-6 col-md-4' ];
      break;
    case 3:
      return [ 'col-sm-4', 'col-sm-4', 'col-sm-4' ];
      break;
    case 4:
      return [ 'col-sm-3', 'col-sm-3', 'col-sm-3', 'col-sm-3' ];
      break;
  }

  return [];
}

/**
 * @param array $f field data
 * @param array $df display field options
 * @return null|string
 */
function faculty_display_name($f, $df)
{
  $name = '';

  $name_fields = [
    //'field_59b19525de7a3',
    'sf_profile_last_name',
    'sf_profile_middle_name',
    'sf_profile_first_name',
  ];

  foreach( $name_fields as $name_field ) {

    if( in_array( $name_field, $df ) && ! empty( $f[ $name_field ] ) ) {

      switch( $name_field ) {
        case 'sf_profile_last_name':
          $name .= $f[ $name_field ] . ', ';
          break;
        case 'sf_profile_middle_name':
          $name .= substr( $f[ $name_field ], 0, 1 ) . '';
          break;
        case 'sf_profile_first_name':
          $name .= $f[ $name_field ] . ' ';
          break;
      }
    }
  }

  return ! empty( $name ) ? $name : null;
}