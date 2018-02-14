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
    'program_tdvideo'        => 'tdvideo',
  ];

  if ($program_id == '10372') {
    print_r ($wp_post_id);
  }

  $dom = new DOMDocument();
  $dom->loadHTML($brochure_data);
  //$xpath = new DOMXpath($dom);

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