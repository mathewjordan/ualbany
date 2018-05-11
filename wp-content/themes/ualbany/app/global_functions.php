<?php

if (! function_exists('program_meta_value')) {
  function program_meta_value($val, $list_type='comma-list') {
    ?>
    <?php if ($val != '') : 
      $list_class = 'program-meta__' . $list_type; ?>
      <ul class="<?php echo $list_class; ?>">
        <?php if (is_array($val)) : ?> 
          <?php foreach ($val as $v) : ?>
          <li><?php echo $v; ?></li>
          <?php endforeach; ?>
        <?php else : ?>
          <li><?php echo $val; ?></li>
        <?php endif; ?>
      </ul>
    <?php endif; ?>
    <?php
  }
}

if (! function_exists('program_target_string')) {
  function program_target_string($str) {
    $target = strtolower($str);
    $target = preg_replace("/[^a-z0-9 ]/", '', $target); // Keep only alphanumeric and spaces
    $target = preg_replace('/\s+/', '-', $target); // Replace occurances of 1 or more spaces
    return $target;
  }
}

if (! function_exists('td_program_meta')) {
  function td_program_meta($post_obj = NULL) {
    global $post;

    $post_obj = $post_obj != NULL ? $post_obj : $post;

    // Array keys should conform to param_id in Terra Dotta XML
    $param_ids = [
      '10003' => 'housing', // Housing Options
      '10005' => 'lang_of_instruct', // Language of Instruction
      '10011' => 'internship', // Internship Opportunity
      '10022' => 'partner', // Partner University
      '10030' => 'exchange', // Exchange Program
      '10047' => 'advisor_email',
    ];

    $program_meta = [
      'partner' => '',
      'lang_of_instruct' => '',
      'exchange' => '',
      'internship' => '',
      'city' => '',
      'country' => '',
      'terms' => '',
    ];

    // Location Data
    if (get_field('program_location_param', $post_obj->ID)) :
      $locations = json_decode(get_field('program_location_param', $post_obj->ID));

      if ($locations->location) :
        $location = is_array($locations->location) ? $locations->location[0] : $locations->location;
        $program_meta['city'] = $location->program_city;
        $program_meta['country'] = $location->program_country;
        $program_meta['region'] = $location->program_region;
      endif;
    endif;

    // Term Data
    if (get_field('program_term', $post_obj->ID)) :
      $terms = json_decode(get_field('program_term', $post_obj->ID));

      if ($terms->term) :

        if (is_array($terms->term)) :
          $program_meta['terms'] = [];

          foreach ($terms->term as $t) :
            $program_meta['terms'][] = $t->program_term;
          endforeach;
        else :
          $program_meta['terms'] = $terms->term->program_term;
        endif;
      endif;
    endif;

    // Miscellaneous Params
    if (get_field('program_params', $post_obj->ID)) :
      $params = json_decode(get_field('program_params', $post->ID));

      if ($params->parameter) :

        if (is_array($params->parameter)) :

          foreach ($params->parameter as $p) :

            if (isset($param_ids[$p->param_id])) :
              $param_slug = $param_ids[$p->param_id];
              $param_value = $program_meta[$param_slug];

              // If a param value already exists...
              if ($param_value != '') :
                // If the value is an array...
                if (is_array($param_value)) :
                  // Add to the array
                  $program_meta[$param_slug][] = $p->param_value;
                else :
                  // Create a new array containing values
                  $program_meta[$param_slug] = [ $param_value, $p->param_value ];
                endif;
              else :
                $program_meta[$param_slug] = $p->param_value;
              endif;

            endif;
          endforeach;
        endif;
      endif;
    endif;

    return $program_meta;
  }
}

if (! function_exists('str_to_machine')) {
  function str_to_machine($str) {
    $machine_name = strip_tags($str);
    $machine_name = strtolower($machine_name);
    $machine_name = trim($machine_name); 
    $machine_name = preg_replace("/[^a-z0-9 ]/", '', $machine_name); // Keep only alphanumeric and spaces
    $machine_name = preg_replace('/\s+/', '-', $machine_name); // Replace occurances of 1 or more spaces
    return $machine_name;
  }
}

if (! function_exists('td_unique_terms')) {
  function td_unique_terms() {
    $args = [ 'post_type'      => 'program',
              'post_status'    => 'publish',
              'posts_per_page' => -1 ];

    $query = new WP_Query($args);
                    
    if ($query->have_posts()) :
      $unique = [];

      while ($query->have_posts()) : $query->the_post();
        $program_meta = td_program_meta();

        if (is_array($program_meta['terms'])) {
            foreach ($program_meta['terms'] as $term) :
                $term_machine_name = str_to_machine($term);

                if (! array_key_exists($term_machine_name, $unique)) :
                    $unique[$term_machine_name] = $term;
                endif;
            endforeach;
        }

      endwhile;
      wp_reset_postdata();
    endif;

    return $unique;
  }
}

if (! function_exists('get_app_term_dates')) {
  function get_app_term_dates($d) {
    $arr = [];
    $arr['app_deadline'] = $d->app_deadline;
    $arr['app_decision'] = $d->app_decision;
    $arr['app_term_year'] = $d->app_term_year;
    $arr['term_start'] = $d->term_start;
    $arr['term_end'] = $d->term_end;

    if ($d->override) {
      $arr['override'] = $d->override;
    }

    if ($d->override2) {
      $arr['override2'] = $d->override2;
    }

    return $arr;
  }
}

if (! function_exists('td_program_dates')) {
  function td_program_dates() {
    global $post;
    $default = 'Forthcoming';

    if (get_field('program_dates', $post->ID)) :
      $dates_data = json_decode(get_field('program_dates', $post->ID));
      $dates = [];

      if ($dates_data->date) :

        if (is_array($dates_data->date)) :
          
          foreach($dates_data->date as $d) :
            $app_term = strtolower($d->app_term);
            $dates[$app_term] = get_app_term_dates($d);
          endforeach;

        else:
          $app_term = strtolower($dates_data->date->app_term);
          $dates[$app_term] = get_app_term_dates($dates_data->date);
        endif;
      endif;

      reset($dates);
      $first_key = key($dates);
      $deadline  = $dates[$first_key]['override'] ? 
                   $dates[$first_key]['override'] :
                   $dates[$first_key]['app_deadline'];

      $deadline_date = $deadline ? date('n.d.Y', strtotime($deadline)) : $default;

      $start = $dates[$first_key]['term_start'];
      $start_date = $start ? date('n.d.Y', strtotime($start)) : $default;

      $end = $dates[$first_key]['term_end'];
      $end_date = $end ? date('n.d.Y', strtotime($end)) : $default;

      $date_array = [ 'deadline' => $deadline_date,
                      'start'    => $start_date,
                      'end'      => $end_date ];

    else:
      $date_array = [ 'deadline' => $default,
                      'start'    => $default,
                      'end'      => $default ];
    endif;
    
    return $date_array;
  }
}
