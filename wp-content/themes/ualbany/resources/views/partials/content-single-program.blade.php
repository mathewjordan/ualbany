@php

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

@endphp

<article @php(post_class())>
    <header class="program-header">
        <div class="container">
          <h1 class="entry-title">{{ get_the_title() }}</h1>
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
            <a href="#" target="" class="btn">
              <span class="fa fa-user"></span>
              Contact an Advisor
            </a>
            @php the_field('program_introduction') @endphp
          </div>
        </div><!-- /.row -->
      </div><!-- /.container -->
    </section>

    <section class="program-dates">
      <div class="container">
        <div class="row">
          <div class="col-sm-4 text-center">
            <h2>{{ __('Application Deadline') }}</h2>
            <div class="program-dates__date program-dates__date--app-deadline">1.08.2018</div>
          </div>
          <div class="col-sm-4 text-center">
            <h2>{{ __('Program Start') }}</h2>
            <div class="program-dates__date">1.08.2018</div>
          </div>
          <div class="col-sm-4 text-center">
            <h2>{{ __('Program End') }}</h2>
            <div class="program-dates__date">1.08.2018</div>
          </div>
        </div>
      </div>
    </section>

    @if(get_field('program_tdvideo'))
    <section class="program-video text-center">
      @php(the_field('program_tdvideo'))
    </section>
    @endif

    <section class="program-meta">
      <div class="container">
        <div class="row">
          <h2 class="col-sm-3 program-meta__label"><span class="fa fa-university"></span> {{ __('Partner University') }}</h2>
          <div class="col-sm-3 program-meta__value">
            Lorem ipsum dolor
          </div>
          <h2 class="col-sm-3 program-meta__label"><span class="fa fa-graduation-cap"></span> {{ __('Faculty Led') }}</h2>
          <div class="col-sm-3 program-meta__value">
            Lorem ipsum dolor
          </div>
          <h2 class="col-sm-3 program-meta__label"><span class="fa  fa-map-marker"></span> {{ __('City') }}</h2>
          <div class="col-sm-3 program-meta__value">
            Lorem ipsum dolor
          </div>
          <h2 class="col-sm-3 program-meta__label"><span class="fa fa-exchange"></span> {{ __('Exchange Program') }}</h2>
          <div class="col-sm-3 program-meta__value">
            Lorem ipsum dolor
          </div>
          <h2 class="col-sm-3 program-meta__label"><span class="fa fa-calendar"></span> {{ __('Program Term') }}</h2>
          <div class="col-sm-3 program-meta__value">
            Lorem ipsum dolor
          </div>
          <h2 class="col-sm-3 program-meta__label"><span class="fa fa-suitcase"></span> {{ __('Internship Opportunity') }}</h2>
          <div class="col-sm-3 program-meta__value">
            Lorem ipsum dolor
          </div>
          <h2 class="col-sm-3 program-meta__label"><span class="fa fa-comments-o"></span> {{ __('Language of Instruction') }}</h2>
          <div class="col-sm-3 program-meta__value">
            Lorem ipsum dolor
          </div>
          <h2 class="col-sm-3 program-meta__label"><span class="fa fa-flask"></span> {{ __('Research Opportunity') }}</h2>
          <div class="col-sm-3 program-meta__value">
            Lorem ipsum dolor
          </div>
        </div>
      </div>
    </section>

    <section>

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
            <div class="col-sm-3">
              <h3>Meet with an Advisor</h3>
            </div>
            <div class="col-sm-3">
              <h3>Find an Event to Learn More</h3>
            </div>
            <div class="col-sm-3">
              <h3>Find Scholarships and Financial Aid</h3>
            </div>
            <div class="col-sm-3">
              <h3>Search Frequently Asked Questions</h3>
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
