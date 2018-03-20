@php
if (! function_exists('program_meta_value')) {
  function program_meta_value($val, $list_type='comma-list') {
    @endphp
    @if ($val != '')
      @php($list_class = 'program-meta__' . $list_type)
      <ul class="{{ $list_class }}">
        @if (is_array($val)) 
          @php
          foreach ($val as $v) :
          @endphp
          <li>{{ $v }}</li>
          @php
          endforeach;
          @endphp
        @else
          <li>{{ $val }}</li>
        @endif
      </ul>
    @endif
    @php
  }
}

$render = [
  'Academics'      => 'program_academics',      // updated
  'Faculty'        => 'program_faculty',        // new
  'Accommodations' => 'program_accommodations',
  'Cost'           => 'program_costs',
  'Eligibility'    => 'program_eligibility',
  'Excursions'     => 'program_excursions',     // updated
  'Scholarships'   => 'program_scholarships',   // new
  'Testimonials'   => 'program_testimonials',
  'Contact'        => 'program_contact',        // new
  'Location'       => 'program_location',
  'Duration'       => 'program_duration',
  'Overview'       => 'program_overview',
];

// Array keys should conform to param_id in Terra Dotta XML
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

// Program Type
$is_incoming = get_field('program_type') && get_field('program_type') == '2' ? true : false;

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

@endphp

<article @php(post_class())>
    <header class="program-header">
        <div class="container">
          <h1 class="entry-title">{{ get_the_title() }}</h1>
          <h2 class="program-header__city">{{ $program_meta['city'] }}</h2>
        </div>
    </header>
    <div class="entry-content">
      <div class="container">
        <a href="https://ualbany.studioabroad.com/index.cfm?FuseAction=ProgramAdmin.BrochureEdit&Program_ID={{get_field('program_id')}}" target="_blank"><span class="fa fa-edit"></span> Edit in Terra Dotta</a>
      </div>
    </div>
    <section class="program-intro">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            @php
            $gallery = get_field('program_photos');
            $cnt = 0;
            @endphp

            @if ($gallery)
            <div id="program-slides" class="program-slides">

              @foreach ($gallery as $photo)
                @php
                $carousel_item_class = 'carousel-item';
                $carousel_item_class .= $cnt == 0 ? ' active' : '';
                @endphp
                <div>
                  <img class="d-block w-100" src="{{ $photo['sizes']['large'] }}" alt="{{ $photo['alt'] }}">
                </div>
                @php $cnt++ @endphp
              @endforeach

            </div>
            @endif
           
          </div>
          <div class="col-md-6">
            <a href="#" target="_blank" class="btn">
              <span class="fa fa-send"></span>
              Apply Now!
            </a>
            <a href="#" target="" class="btn btn--right">
              <span class="fa fa-user"></span>
              Contact an Advisor
            </a>
            <div class="clearfix" aria-hidden="true"></div>
            @php the_field('program_introduction') @endphp
            <div class="sharing">
              <h2 class="sharing__title">Share Your Plan!</h2>
              @php echo do_shortcode('[addtoany]') @endphp
            </div>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container -->
    </section>

    @if(get_field('program_dates'))
    <section class="program-dates">
      <div class="container">
        <div class="row">
          @php

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

          @endphp

          <div class="col-sm-4 text-center">
            <h2>{{ __('Application Deadline') }}</h2>
            <div class="program-dates__date program-dates__date--app-deadline">{{ $deadline_date }}</div>
          </div>
          <div class="col-sm-4 text-center">
            <h2>{{ __('Program Start') }}</h2>
            <div class="program-dates__date">{{ $start_date }}</div>
          </div>
          <div class="col-sm-4 text-center">
            <h2>{{ __('Program End') }}</h2>
            <div class="program-dates__date">{{ $end_date }}</div>
          </div>
        </div>
      </div>
    </section>
    @endif

    @php
    $video = get_field('program_tdvideo') ? 
             trim(get_field('program_tdvideo'), chr(0xC2).chr(0xA0)) : // Trim whitepace and non-breaking spaces (nbsp;)
             false;
    @endphp

    @if ($video && $video != '')
    <section class="program-video text-center">
      <div class="container">
        <div class="video-wrapper">
          <iframe width="560" height="349" src="@php(the_field('program_tdvideo'))"></iframe>
        </div>
      </div>
    </section>
    @endif

    <section class="program-meta">
      <div class="container">
        <div class="row">
          <h2 class="col-sm-3 program-meta__label"><span class="fa fa-university"></span> {{ __('Partner University') }}</h2>
          <div class="col-sm-3 program-meta__value">
            {{ $program_meta['partner'] }}
          </div>
          <h2 class="col-sm-3 program-meta__label"><span class="fa fa-graduation-cap"></span> {{ __('Faculty Led') }}</h2>
          <div class="col-sm-3 program-meta__value">
            Lorem ipsum dolor
          </div>
          <h2 class="col-sm-3 program-meta__label"><span class="fa  fa-map-marker"></span> {{ __('City') }}</h2>
          <div class="col-sm-3 program-meta__value">
            {{ $program_meta['city'] }}
          </div>
          <h2 class="col-sm-3 program-meta__label"><span class="fa fa-exchange"></span> {{ __('Exchange Program') }}</h2>
          <div class="col-sm-3 program-meta__value">
            {{ $program_meta['exchange'] }}
          </div>
          <h2 class="col-sm-3 program-meta__label"><span class="fa fa-calendar"></span> {{ __('Program Term') }}</h2>
          <div class="col-sm-3 program-meta__value">
            @php(program_meta_value($program_meta['terms'], 'comma-list'))
          </div>
          <h2 class="col-sm-3 program-meta__label"><span class="fa fa-suitcase"></span> {{ __('Internship Opportunity') }}</h2>
          <div class="col-sm-3 program-meta__value">
            @php(program_meta_value($program_meta['internship'], 'break-list'))
          </div>
          <h2 class="col-sm-3 program-meta__label"><span class="fa fa-comments-o"></span> {{ __('Language of Instruction') }}</h2>
          <div class="col-sm-3 program-meta__value">
            {{ $program_meta['lang_of_instruct'] }}
          </div>
          <h2 class="col-sm-3 program-meta__label"><span class="fa fa-flask"></span> {{ __('Research Opportunity') }}</h2>
          <div class="col-sm-3 program-meta__value">
            Lorem ipsum dolor
          </div>
        </div>
      </div>
    </section>

    @if ($is_incoming)
    <section class="page-section">
      <div class="container">
        <h2 class="text-center">{{ __('Visiting Students') }}</h2>
        <p class="text-center"><a href="/visiting-students/" class="btn">{{ __('Learn More') }}</a></p>
      </div>
    </section>
    @endif

    <section class="page-section">

        <h2 class="text-center"><?php echo __('Programs'); ?></h2>

        <div class="container">
          <!-- Tabs -->
          <ul class="nav nav-tabs" role="tablist">
            @php($cnt = 0)
            @foreach($render as $title => $selector)
                @if (get_field($selector) && trim(get_field($selector)) != '<p>&nbsp;</p>')
                @php
                    if ($cnt == 0) {
                      $first = 1;
                    } else {
                      $first = 0;
                    }
                    $cnt++;
                @endphp
                <li class="nav-item">
                    <a class="nav-link @if($first == 1) active @endif" href="#{{strtolower($title)}}" role="tab"
                       data-toggle="tab">{{$title}}</a>
                </li>
                @endif
            @endforeach
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">
              @php($cnt = 0)
              @foreach($render as $title => $selector)
                @if (get_field($selector) && trim(get_field($selector)) != '<p>&nbsp;</p>')
                @php
                if ($cnt == 0) {
                  $first = 1;
                } else {
                  $first = 0;
                }
                $cnt++;
                @endphp
                <div role="tabpanel" class="tab-pane @if($first == 1) active in @endif" id="{{strtolower($title)}}">
                  @php(the_field($selector))
                </div>
                @endif
              @endforeach
          </div>

        </div>

    </section>

    <section>
      <div class="subfooter">
        <div class="container">
          <div class="row">
            <div class="col-lg-3 col-md-6">
              <a href="#" class="subfooter__link">
                <span class="fa fa-user" aria-hidden="true"></span>
                <h3>Meet with an Advisor</h3>
              </a>
            </div>
            <div class="col-lg-3 col-md-6">
              <a href="#" class="subfooter__link">
                <span class="fa fa-calendar" aria-hidden="true"></span>
                <h3>Find an Event to Learn More</h3>
              </a>
            </div>
            <div class="col-lg-3 col-md-6">
              <a href="#" class="subfooter__link">
                <span class="fa fa-dollar" aria-hidden="true"></span>
                <h3>Find Scholarships and Financial Aid</h3>
              </a>
            </div>
            <div class="col-lg-3 col-md-6">
              <a href="#" class="subfooter__link">
                <span class="fa fa-question" aria-hidden="true"></span>
                <h3>Search Frequently Asked Questions</h3>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <footer>
        {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
    </footer>
    @php(comments_template('/partials/comments.blade.php'))
</article>
