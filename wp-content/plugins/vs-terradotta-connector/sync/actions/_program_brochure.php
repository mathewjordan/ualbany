<?php
/**  
 * Helper, returns the innerHTML of an element
 *
 * @param object DOMElement
 *
 * @return string one element's HTML content
 */

function innerHTML( $contentdiv ) {
  $r = '';
  $elements = $contentdiv->childNodes;
  foreach( $elements as $element ) { 
    if ( $element->nodeType == XML_TEXT_NODE ) {
      $text = $element->nodeValue;
      // IIRC the next line was for working around a
      // WordPress bug
      //$text = str_replace( '<', '&lt;', $text );
      $r .= $text;
    }  
    // FIXME we should return comments as well
    elseif ( $element->nodeType == XML_COMMENT_NODE ) {
      $r .= '';
    }  
    else {
      $r .= '<';
      $r .= $element->nodeName;
      if ( $element->hasAttributes() ) { 
        $attributes = $element->attributes;
        foreach ( $attributes as $attribute )
          $r .= " {$attribute->nodeName}='{$attribute->nodeValue}'" ;
      }  
      $r .= '>';
      $r .= innerHTML( $element );
      $r .= "</{$element->nodeName}>";
    }  
  }  
  return $r;
}

// Return an array of td params that
// match a specific param_id
function get_params_by_id($params, $param_id) {
  $values = [];

  foreach ($params->parameter as $p) {
    if (isset($p->param_id) && $p->param_id == $param_id) {
      $values[] = $p->param_value;
    }
  }

  return $values;
}

function add_or_update_post($type, $key, $val, $name) {
  // query for post to see if exists
  $args  = [
    'meta_query' => [
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
    $post_id = $p->ID;

    // run update
    $update_post = [
      'ID'         => $post_id,
      'post_title' => $name,
    ];

    // Update the post into the database
    wp_update_post($update_post);
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

  }

  // set unique val for new subject post
  update_field($key, $val, $post_id);
}

function parse_subjects($params) {
  $subject_params = get_params_by_id($params, 10004);
  $subject_str    = '';
  $ignore         = ['any-subject-area-taught-in-host-us-language'];

  foreach ($subject_params as $subject) {
    $subject = strip_tags($subject);
    $subject_machine_name = strtolower($subject);
    $subject_machine_name = trim($subject_machine_name); 
    $subject_machine_name = preg_replace("/[^a-z0-9 ]/", '', $subject_machine_name); // Keep only alphanumeric and spaces
    $subject_machine_name = preg_replace('/\s+/', '-', $subject_machine_name); // Replace occurances of 1 or more spaces

    // If the subject is not in the ignore array,
    // then add it to the string
    if (! in_array($subject_machine_name, $ignore)) {
      $subject_str .= $subject_machine_name . ',';
    }

    // Add or update the Subject post
    add_or_update_post('subject', 'subject_id', $subject_machine_name, $subject);

  }

  return $subject_str;
}

function sync_program_brochure_handler() {

  $program_id = $_POST['program_id'];
  $wp_post_id = $_POST['wp_post_id'];

  $brochure_endpoint = TERRADOTTA_URL . '?callName=getProgramBrochure&Program_ID=' . $program_id . '&ResponseEncoding=XML';

  $brochure_curl  = terrdotta_curl($brochure_endpoint);
  $brochure_xml   = simplexml_load_string($brochure_curl);
  $brochure_json  = json_encode($brochure_xml);
  $brochure       = json_decode($brochure_json);
  $brochure_data  = $brochure->details->program_brochure;
  $dates          = $brochure->details->dates;
  $is_featured    = $brochure->details->IsFeatured;
  $dates_json     = json_encode($dates);
  $type           = $brochure->details->program_type_id;
  $location_param = $brochure->details->locations;
  $location_param_json = json_encode($location_param);
  $terms               = $brochure->details->terms;
  $terms_json          = json_encode($terms);
  $params              = $brochure->details->parameters;
  $params_json         = json_encode($params);

  $params_subjects = parse_subjects($params);

  //$partner
  //$faculty_led
  //$exchange = $brochure->details->bExchangeAvailabl;
  //$interships
  //$research

  // Program Dates
  update_field('program_dates', $dates_json, $wp_post_id);

  // Program Type
  update_field('program_type', $type, $wp_post_id);

  // Featured
  update_field('program_featured', $is_featured, $wp_post_id);

  // Program Locations
  update_field('program_location_param', $location_param_json, $wp_post_id);

  // Program Terms
  update_field('program_term', $terms_json, $wp_post_id);

  // Program Subjects
  update_field('program_subject', $params_subjects, $wp_post_id);

  // Miscellaneous Params
  update_field('program_params', $params_json, $wp_post_id);

  $mapping = [
    'program_academics'      => 'program_academics',
    'program_faculty'        => 'program_faculty',
    'program_accommodations' => 'program_accommodations',
    'program_costs'          => 'program_costs',
    'program_eligibility'    => 'program_eligibility',
    'program_excursions'     => 'program_excursions',
    'program_scholarships'   => 'program_scholarships',
    'program_testimonials'   => 'program_testimonials',
    'program_contact'        => 'program_contact',
    'program_location'       => 'program_location',
    'program_duration'       => 'program_duration',
    'program_overview'       => 'program_overview',
    //'program_tdvideo'      => 'tdvideo',
  ];

  $dom = new DOMDocument();
  $dom->loadHTML($brochure_data);

  preg_match("'<td id=\"tdintro\">(.*?)</td>'si", $brochure_data, $td_intro);
  if ($td_intro[1]) {
    update_field('program_introduction', $td_intro[1], $wp_post_id);
  }

  preg_match("'<td id=\"tdbrochure\">(.*?)</td>'si", $brochure_data, $td_match);

  if ($td_match[1]) {
    foreach ($mapping as $acf => $html_id) {
      $element = $dom->getElementById( $html_id );
      $innerHTML = innerHTML( $element );
      update_field($acf, $innerHTML, $wp_post_id);
    }
    update_field('program_td_format', 1, $wp_post_id);
  } else {
    update_field('program_overview', $brochure_data, $wp_post_id);
  }

  wp_die();

}

add_action('wp_ajax_sync_program_brochure_action', 'sync_program_brochure_handler');
add_action('wp_ajax_nopriv_sync_program_brochure_action', 'sync_program_brochure_handler')

?>