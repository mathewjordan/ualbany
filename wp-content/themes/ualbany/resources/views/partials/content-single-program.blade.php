@php

// Program Type
$is_incoming = get_field('program_type') && get_field('program_type') == '2' ? true : false;

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

$gallery      = $is_incoming ? get_field('incoming_program_photos', 'option') : get_field('program_photos');
$introduction = $is_incoming ? get_field('incoming_program_introduction', 'option') : get_field('program_introduction');
$video        = $is_incoming ? get_field('incoming_program_video', 'option') : get_field('program_video');
$video        = $video ?
                trim($video, chr(0xC2).chr(0xA0)) : // Trim whitepace and non-breaking spaces (nbsp;)
                false;
$video_blurb  = $is_incoming ? get_field('incoming_program_video_blurb', 'option') : get_field('program_video_blurb');

$program_meta = td_program_meta();

$program_dates = td_program_dates();

//var_dump($program_dates);

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
            @php($cnt = 0)
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
            
            <div class="slick-thumbs">
              <ul>
          @foreach ($gallery as $photo)

            <li>
              <img src="{{ $photo['sizes']['medium'] }}" alt="{{ $photo['alt'] }}">
            </li>      

          @endforeach
              </ul>
            </div>
            
            @endif
           
          </div>
          <div class="col-md-6">
            <a href="https://ualbany.studioabroad.com/index.cfm?FuseAction=Programs.ViewProgram&Program_ID={{get_field('program_id')}}" target="_blank" class="btn-purple">
              <span class="fa fa-send"></span>
              Apply Now!
            </a>
            <a href="<?php echo get_permalink(2188);?>?title=<?php echo urlencode(get_the_title()); ?>&email=advisoremail@ualbany.edu&link=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="btn btn--right">
              <span class="fa fa-user"></span>
              Contact an Advisor
            </a>
            <div class="clearfix" aria-hidden="true"></div>
            @if ($introduction)
              {!! $introduction !!}
            @endif
            <div class="sharing">
              <h2 class="sharing__title">Share Your Plan!</h2>
              @php echo do_shortcode('[addtoany]') @endphp
            </div>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container -->
    </section>

    @if($program_dates)
    <section class="program-dates">
      <div class="container">
        <div class="row">
          <div class="col-sm-4 text-center">
            <h2>{{ __('Application Deadline') }}</h2>
            <div class="program-dates__date program-dates__date--app-deadline">{{ $program_dates['deadline'] }}</div>
          </div>
          <div class="col-sm-4 text-center">
            <h2>{{ __('Program Start') }}</h2>
            <div class="program-dates__date">{{ $program_dates['start'] }}</div>
          </div>
          <div class="col-sm-4 text-center">
            <h2>{{ __('Program End') }}</h2>
            <div class="program-dates__date">{{ $program_dates['end'] }}</div>
          </div>
        </div>
      </div>
    </section>
    @endif

    @if ($video && $video != '')
    <section class="program-video text-center">
        <div class="video-wrapper">
          <iframe width="560" height="349" src="{{ $video }}"></iframe>
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

    <section class="program-section">
      <h2 class="text-center"><?php echo __('Program Details'); ?></h2>
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
                  $target = $is_incoming ? 'incoming-' . program_target_string($title) : program_target_string($title);
              @endphp
              <li class="nav-item">
                  <a class="nav-link @if($first == 1) active @endif" href="#{{$target}}" role="tab"
                     data-toggle="tab">{{$title}}</a>
              </li>
              @endif
          @endforeach
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
        @php($cnt = 0)
        @foreach($render as $title => $selector)
          @php
          // Prefix ACF field selectors for incoming programs
          $modified_selector = $is_incoming ? 'incoming_' . $selector : $selector;

          // If incoming, use 'option' for the post ID
          $tab_content = $is_incoming ? get_field($modified_selector, 'option') : get_field($modified_selector);

          @endphp

          @if ($tab_content && trim($tab_content) != '<p>&nbsp;</p>')
            @php
            if ($cnt == 0) {
              $first = 1;
            } else {
              $first = 0;
            }
            $cnt++;
            $target = $is_incoming ? 'incoming-' . program_target_string($title) : program_target_string($title);
            @endphp
            <div role="tabpanel" class="tab-pane @if($first == 1) active in @endif" id="{{$target}}">
              {!! $tab_content !!}
            </div>
          @endif
        @endforeach
        </div>
      </div>
    </section>

    @if ($is_incoming)

    @php
    $render_incoming = [
      'Campus Life'                => 'incoming_program_subfooter_campus',        
      'Housing'                    => 'incoming_program_subfooter_housing',
      'Entertainment'              => 'incoming_program_subfooter_entertainment',
      'Restaurants &amp; Shopping' => 'incoming_program_subfooter_restaurants'
    ];
    @endphp
    <section class="program-about">
      <div class="incoming-subfooter">
        <div class="container">
          <div class="row">
            <div class="col-sm-6">
              <h2>{{ __('About UAlbany') }}</h2>
              @if (get_field('incoming_program_subfooter_intro', 'option'))
                @php(the_field('incoming_program_subfooter_intro', 'option'))
              @endif
            </div>
            <div class="col-sm-6">
              
              <div id="program-incoming-map" class="incoming-subfooter__map"></div>
                <figure>
                    <img src="/wp-content/themes/ualbany/resources/assets/images/ualbany-map.png" class="img-fluid" />
                </figure>

            </div>
          </div>
          <!-- Tabs -->
          <ul class="nav nav-tabs" role="tablist">
            @php($cnt = 0)
            @foreach($render_incoming as $title => $selector)
                @if (get_field($selector, 'option') && trim(get_field($selector, 'option')) != '<p>&nbsp;</p>')
                @php
                    if ($cnt == 0) {
                      $first = 1;
                    } else {
                      $first = 0;
                    }
                    $cnt++;
                    $target = 'incoming-subfooter-' . program_target_string($title);
                @endphp
                <li class="nav-item">
                    <a class="nav-link @if($first == 1) active @endif" href="#{{$target}}" role="tab"
                       data-toggle="tab">{{$title}}</a>
                </li>
                @endif
            @endforeach
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">
            @php
            $incoming_bg_image = get_field('incoming_program_subfooter_image', 'option');
            $cnt = 0;
            @endphp
            @foreach($render_incoming as $title => $selector)
              @if (get_field($selector, 'option') && trim(get_field($selector, 'option')) != '<p>&nbsp;</p>')
              @php
              if ($cnt == 0) {
                $first = 1;
              } else {
                $first = 0;
              }
              $cnt++;
              $target = 'incoming-subfooter-' . program_target_string($title);
              @endphp
              <div role="tabpanel" class="tab-pane @if($first == 1) active in @endif" id="{{$target}}">
                <div class="incoming-subfooter__image" style="background-image: url({{ $incoming_bg_image['sizes']['large'] }});">
                  <div class="incoming-subfooter__content">
                    <h3>{{ $title }}</h3>
                    @php(the_field($selector, 'option'))
                  </div>
                </div>
              </div>
              @endif
            @endforeach
          </div>
        </div>
      </div>
    </section>
    @endif

    <section class="subfooter">
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
    </section>
</article>
