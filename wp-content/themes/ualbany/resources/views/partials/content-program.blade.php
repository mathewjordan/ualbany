<article @php(post_class())>
  <div class="row">
  <div class="col-sm-2">
  @php
  $is_incoming = get_field('program_type') && get_field('program_type') == '2' ? true : false;

  $introduction = $is_incoming ? get_field('incoming_program_introduction', 'option') : get_field('program_introduction');

  $param_ids = [
    '10022' => 'partner', // Partner University
    '10005' => 'lang_of_instruct', // Language of Instruction
    '10030' => 'exchange', // Exchange Program
    '10011' => 'internship', // Internship Opportunity
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
  <div class="">
    <h4 class="program-meta__label"><span class="fa fa-calendar"></span> {{ __('Program Terms') }}</h4>
    <div class="program-meta__value">
      @php(program_meta_value($program_meta['terms'], 'comma-list'))
    </div>
    <h4 class="program-meta__label"><span class="fa fa-comments-o"></span> {{ __('Language of Instruction') }}</h4>
    <div class="program-meta__value">
      <?php echo $program_meta['lang_of_instruct']; ?>
    </div>
  </div>
  </div>
</article>