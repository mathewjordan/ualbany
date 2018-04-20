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
  function td_program_meta() {
    global $post;

    // Array keys should conform to param_id in Terra Dotta XML
    $param_ids = [
      '10003' => 'housing', // Housing Options
      '10005' => 'lang_of_instruct', // Language of Instruction
      '10011' => 'internship', // Internship Opportunity
      '10022' => 'partner', // Partner University
      '10030' => 'exchange', // Exchange Program
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
    if (get_field('program_location_param', $post->ID)) :
      $locations = json_decode(get_field('program_location_param', $post->ID));

      if ($locations->location) :
        $location = is_array($locations->location) ? $locations->location[0] : $locations->location;
        $program_meta['city'] = $location->program_city;
        $program_meta['country'] = $location->program_country;
        $program_meta['region'] = $location->program_region;
      endif;
    endif;

    // Term Data
    if (get_field('program_term', $post->ID)) :
      $terms = json_decode(get_field('program_term', $post->ID));

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
    if (get_field('program_params', $post->ID)) :
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

if (! function_exists('td_program_dates')) {
  function td_program_dates() {
    global $post;

    if (get_field('program_dates', $post->ID)) :
      $dates_data = json_decode(get_field('program_dates', $post->ID));
      $dates = [];

      if ($dates_data->date) :

        if (is_array($dates_data->date)) :

          foreach($dates_data->date as $d) :
            $app_term = strtolower($d->app_term);
            $dates[$app_term] = [];
            $dates[$app_term]['app_deadline'] = $d->app_deadline;
            $dates[$app_term]['app_decision'] = $d->app_decision;
            $dates[$app_term]['app_term_year'] = $d->app_term_year;
            $dates[$app_term]['term_start'] = $d->term_start;
            $dates[$app_term]['term_end'] = $d->term_end;

            if ($d->override) {
              $dates[$app_term]['override'] = $d->override;
            }

            if ($d->override2) {
              $dates[$app_term]['override2'] = $d->override2;
            }

          endforeach;
        else:
        endif;
      endif;

      $deadline = $dates['winter']['override'] ? 
                  $dates['winter']['override'] :
                  $dates['winter']['app_deadline'];

      $deadline_date = date('n.d.Y', strtotime($deadline));

      $start = $dates['winter']['term_start'];
      $start_date = date('n.d.Y', strtotime($start));

      $end = $dates['winter']['term_end'];
      $end_date = date('n.d.Y', strtotime($end));

      $date_array = [ 'deadline' => $deadline_date,
                      'start'    => $start_date,
                      'end'      => $end_date ];

      return $date_array;

    endif;

    return false;
  }
}
