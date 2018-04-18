<article @php(post_class())>
  <div class="row">
    <div class="col-sm-2">
    @php
    $is_incoming = get_field('program_type') && get_field('program_type') == '2' ? true : false;

    $introduction = $is_incoming ? get_field('incoming_program_introduction', 'option') : get_field('program_introduction');

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
    if (get_field('program_location_param')) :
      $locations = json_decode(get_field('program_location_param'));
      if ($locations->location) :
        $location = is_array($locations->location) ? $locations->location[0] : $locations->location;
        $program_meta['city'] = $location->program_city;
        $program_meta['country'] = $location->program_country;
      endif;
    endif;

    // Term Data
    if (get_field('program_term')) :
      $terms = json_decode(get_field('program_term'));
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
    if (get_field('program_params')) :
      $params = json_decode(get_field('program_params'));
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

    $dates_data = json_decode(get_field('program_dates'));
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

    $gallery = $is_incoming ? get_field('incoming_program_photos', 'option') : get_field('program_photos');

    @endphp

    @if ($gallery)
      @php($thumb = $gallery[0])
      <div class="program__thumbnail" style="background-image: url( {{ $thumb['sizes']['medium'] }});"></div>
    @endif
    </div>
    <div class="col-sm-7">
      <a href="{{ get_the_permalink() }}">
        <h3>{{ get_the_title() }}</h3>
      </a>
      Lorem ipsum dolor sit amet.
    </div>
    <div class="col-sm-3">
      <div class="program-meta">
        <h4 class="program-meta__label"><span class="fa fa-calendar"></span> {{ __('Program Terms') }}</h4>
        <div class="program-meta__value">
          @php(program_meta_value($program_meta['terms'], 'comma-list'))
        </div>
        <h4 class="program-meta__label"><span class="fa fa-comments-o"></span> {{ __('Language of Instruction') }}</h4>
        <div class="program-meta__value">
          @php(program_meta_value($program_meta['lang_of_instruct'], 'comma-list'))
        </div>
        <h4 class="program-meta__label"><span class="fa fa-home"></span> {{ __('Housing') }}</h4>
        <div class="program-meta__value">
          @php(program_meta_value($program_meta['housing'], 'comma-list'))
        </div>
        <h4 class="program-meta__label"><span class="fa fa-clock-o"></span> {{ __('App Deadline') }}</h4>
        <div class="program-meta__value">
          {{ $deadline_date }}
        </div>
        <a href="#" target="_blank" class="btn">
          <span class="fa fa-send"></span>
          Apply Now!
        </a>
      </div>
    </div>
  </div>
</article>