<?php

 /**
 * class Bootstrap_Walker_Nav_Menu()
 *
 * Extending Walker_Nav_Menu to modify class assigned to submenu ul element
 *
 * @author Rachel Baker
 * @author Mike Bijon (updates & PHP strict standards only)
 *
 **/
class Bootstrapwp_Walker_Nav_Menu extends Walker_Nav_Menu {
  /**
   * Opening tag for menu list before anything is added
   *
   *
   * @param array reference       &$output    Reference to class' $output
   * @param int                   $depth      Depth of menu (if nested)
   * @param array                 $args       Class args, unused here
   *
   * @return string $indent
   * @return array by-reference   &$output
   *
   */
  function start_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
  }

  /**
   * @see Walker::end_lvl()
   * @since 3.0.0
   *
   * @param string $output Passed by reference. Used to append additional content.
   * @param int $depth Depth of page. Used for padding.
   */
  function end_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "$indent</ul>\n";
  }

}



function ualbany_custom_dropdown( $item_output, $item ) {

  if ( $item->attr_title == 'ualbany_custom_dropdown') {

    // Locations by Region
    if (in_array('ualbany-custom-dropdown-locations', $item->classes)) :

      $args = [
        'post_type'      => 'program',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'post__not_in' => array(2046)
      ];

      $regions = [];
      $output  = '';
      $query   = new WP_Query($args);

      if ($query->have_posts()) :

        while ($query->have_posts()) : $query->the_post();

          $region_post   = get_field('program_region');
          $region_slug   = $region_post->post_name;
          $region_title  = $region_post->post_title;
          $country_post  = get_field('program_country');
          $country_slug  = $country_post->post_name;
          $country_title = $country_post->post_title;
          $discard_list  = [ NULL, 'various', 'worldwide'];

          // Add region to the array if it does not exist
          if (! isset($regions[$region_slug]) && ! in_array($region_slug, $discard_list)) {
            $regions[$region_slug]['title'] = $region_title;
            $regions[$region_slug]['countries'] = [];
          }
          
          // Add country to the array if it does not exist
          if (! isset($regions[$region_slug]['countries'][$country_slug]) && ! in_array($country_slug, $discard_list)) {
            $regions[$region_slug]['countries'][$country_slug] = [];
            $regions[$region_slug]['countries'][$country_slug]['title'] = $country_title;
          }

        endwhile;
        wp_reset_postdata();

        $output .= '<div class="row">';
        $output .=   '<div class="col-md-3">';
        $max_per_column = 10;
        $prev_country_count = 0;

        ksort($regions); // Sort regions alphabetically

        foreach ($regions as $k => $v) :
          ksort($v['countries']); // Sort countries alphabetically

          if ($prev_country_count > 0) :
            $total_country_count = count($regions[$k]['countries']) + $prev_country_count;
            if ($total_country_count > $max_per_column) {
              $output .= '</div><div class="col-md-3">'; // New column
              $prev_country_count = 0; // Reset the count
            }
          endif;
          
          $output .= '<h2>' . $v['title'] . '</h2>';
          $output .= '<ul>';
          
          foreach ($v['countries'] as $c_key => $c_val) :
            $output .= '<li><a href="/countries/' . $c_key . '">' . $c_val['title'] . '</a></li>';
          endforeach;
          
          $output .= '</ul>';

          $prev_country_count = $prev_country_count + count($regions[$k]['countries']);

        endforeach;

        $output .= '</div><!-- .col-md-3 -->';

        $output .= '</div><!-- .row -->';
        $output .= '<a class="more-button" href="#">More +</a>';

      endif;

    // Subjects
    elseif (in_array('ualbany-custom-dropdown-subjects', $item->classes)) :

      $args = [
        'post_type'      => 'program',
        'post_status'    => 'publish',
        'posts_per_page' => -1
      ];

      $output  = '';
      $query   = new WP_Query($args);

      if ($query->have_posts()) :

        $program_subjects = [];

        while ($query->have_posts()) : $query->the_post();

          $subject_str = get_field('program_subject');

          if ($subject_str) :

            $exploded = explode(',', $subject_str);

            if (is_array($exploded)) :

              foreach ($exploded as $subject_id) :

                if ($subject_id && ! in_array($subject_id, $program_subjects)) {
                  $program_subjects[] = $subject_id;
                }
              endforeach;
            endif;
          endif;
        endwhile;

        wp_reset_postdata();

        if (! empty($program_subjects)) :
          $args  = [
            'meta_query' => [
              [
                'key'     => 'subject_id',
                'value'   => $program_subjects,
                'compare' => 'IN'
              ],
            ],
            'post_type' => 'subject',
            'order'     => 'ASC',
            'orderby'   => 'title',
            'posts_per_page' => -1,
            'offset'         => 0
          ];

          $subjects = get_posts($args);

          if ($subjects) :
            $output .= '<div class="row">';
            $output .=   '<div class="col-md-3">';
            $output .=     '<ul>';


            $max_per_column = ceil(count($subjects) / 4);
            $subject_cnt = 0;

            foreach ($subjects as $s) :

              if ($subject_cnt > $max_per_column) {
                $output .= '</ul></div><div class="col-md-3"><ul>'; // New column
                $subject_cnt = 0; // Reset the count
              }

              $output .= '<li><a href="' . get_the_permalink($s->ID) . '">' . $s->post_title . '</a></li>';
              $subject_cnt++;
            endforeach;

            $output .=     '</ul>';
            $output .=   '</div><!-- .col-md-3 -->';
            $output .= '</div><!-- .row -->';
            $output .= '<a class="more-button" href="#">More +</a>';
          endif;
        endif;
      endif;

    // Semester/Term
    elseif (in_array('ualbany-custom-dropdown-terms', $item->classes)) :
      $terms = td_unique_terms();

      if (count($terms)) :
        $max_per_column = ceil(count($terms) / 3);
        $term_cnt       = 0;

        $output .= '<div class="row">';
        $output .=   '<div class="col-md-3">';
        $output .=     '<ul>';

        foreach ($terms as $k => $v) :
          if ($term_cnt > $max_per_column) {
            $output .= '</ul></div><div class="col-md-3"><ul>'; // New column
            $term_cnt = 0; // Reset the count
          }

          $output .= '<li><a href="/terms?term=' . $k . '">' . $v . '</a></li>';
          $term_cnt++;

        endforeach;

        $output .=     '</ul>';
        $output .=   '</div><!-- .col-md-3 -->';
        $output .= '</div><!-- .row -->';
      endif;
    endif;

    $item_output = $output != '' ? $output : $item_output;

  }
  return $item_output;
}

add_filter( 'walker_nav_menu_start_el', 'ualbany_custom_dropdown', 10, 2 );

?>