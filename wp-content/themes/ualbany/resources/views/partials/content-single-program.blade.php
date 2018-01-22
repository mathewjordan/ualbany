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

              <!--
              <ol class="carousel-indicators">
                @foreach ($gallery as $photo)
                  <li data-target="#program-carousel" data-slide-to="{{ $cnt }}" @if ($cnt == 0) class="active" @endif>
                    <img class="" src="{{ $photo['sizes']['thumbnail'] }}" alt="{{ $photo['alt'] }}">
                  </li>
                  @php $cnt++ @endphp
                @endforeach
              </ol>
            -->

              @php
              $cnt = 0;
              @endphp


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
              <!--
              <a class="carousel-control-prev" href="#program-carousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#program-carousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            -->
            
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
          <div class="col-sm-4">
            
          </div>
          <div class="col-sm-4">
            
          </div>
          <div class="col-sm-4">
            
          </div>
        </div>
      </div>
    </section>
    <div class="entry-content">
        <div class="container">
          <a href="https://ualbany.studioabroad.com/index.cfm?FuseAction=ProgramAdmin.BrochureEdit&Program_ID={{get_field('program_id')}}" target="_blank"><span class="fa fa-edit"></span> Edit in Terra Dotta</a>
        </div>

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
                      <div role="tabpanel" class="tab-pane @if($first == 1) active in @endif"
                           id="{{strtolower($title)}}">@php(the_field($selector))</div>
                      @endif
                  @endforeach
          </div>

        </div>


    </div>
    <footer>
        {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
    </footer>
    @php(comments_template('/partials/comments.blade.php'))
</article>
