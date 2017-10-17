<?php

function sync_program_brochure_handler() {

  $program_id = $_POST['program_id'];
  $wp_post_id = $_POST['wp_post_id'];

  $brochure_endpoint = TERRADOTTA_URL . '?callName=getProgramBrochure&Program_ID=' . $program_id . '&ResponseEncoding=XML';

  print $brochure_endpoint;

  $brochure_curl = terrdotta_curl($brochure_endpoint);
  $brochure_xml  = simplexml_load_string($brochure_curl);
  $brochure_json = json_encode($brochure_xml);
  $brochure      = json_decode($brochure_json);

  $brochure_data = $brochure->details->program_brochure;

  $mapping = [
    'program_description'    => 'tdp0',
    'program_accommodations' => 'tdp2',
    'program_costs'          => 'tdp3',
    'program_selection'      => 'tdp4',
    'program_excursions'     => 'tdp5',
    'program_testimonials'   => 'tdp7',
    'program_location'       => 'tdp9',
    'program_duration'       => 'tdp10',
    'program_overview'       => 'tdp11',
  ];


  preg_match("'<td id=\"tdbrochure\">(.*?)</td>'si", $brochure_data, $td_match);
  if ($td_match[1]) {
    foreach ($mapping as $acf => $html_id) {
      preg_match("'<td id=\"$html_id\">(.*?)</td>'si", $brochure_data, $data_match);
      if ($data_match[1]) {
        update_field($acf, $data_match[1], $wp_post_id);
      }
    }
    update_field('program_td_format', 1, $wp_post_id);
  } else {
    update_field('program_description', $brochure_data, $wp_post_id);
  }

  wp_die();

}

add_action('wp_ajax_sync_program_brochure_action', 'sync_program_brochure_handler');
add_action('wp_ajax_nopriv_sync_program_brochure_action', 'sync_program_brochure_handler')

?>