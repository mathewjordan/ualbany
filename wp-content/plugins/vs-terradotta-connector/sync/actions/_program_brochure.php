<?php

function sync_program_brochure_handler() {

  $program_id = $_POST['program_id'];
  $wp_post_id = $_POST['wp_post_id'];

  $brochure_endpoint = TERRADOTTA_URL . '?callName=getProgramBrochure&Program_ID=' . $program_id . '&ResponseEncoding=XML';

  $brochure_curl = terrdotta_curl($brochure_endpoint);
  $brochure_xml  = simplexml_load_string($brochure_curl);
  $brochure_json = json_encode($brochure_xml);
  $brochure      = json_decode($brochure_json);

  $brochure_data = $brochure->details->program_brochure;

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
  ];

  if ($program_id == '10372') {
    print_r ($wp_post_id);
  }

  preg_match("'<td id=\"tdintro\">(.*?)</td>'si", $brochure_data, $td_intro);
  if ($td_intro[1]) {
    update_field('program_introduction', $td_intro[1], $wp_post_id);
  }

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
    update_field('program_overview', $brochure_data, $wp_post_id);
  }

  wp_die();

}

add_action('wp_ajax_sync_program_brochure_action', 'sync_program_brochure_handler');
add_action('wp_ajax_nopriv_sync_program_brochure_action', 'sync_program_brochure_handler')

?>