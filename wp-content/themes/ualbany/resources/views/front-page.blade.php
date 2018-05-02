@php

    $title     = ! empty( $title ) ? $title : get_the_title();
    $hero      = ! empty ( $hero ) ? $hero : get_field('homepage_hero');
    $permalink = ! empty( $permalink ) ? $permalink : get_the_permalink();

    $homepage_cta      = ! empty ( $homepage_cta ) ? $homepage_cta : get_field('homepage_cta');
    $homepage_info     = ! empty ( $homepage_info ) ? $homepage_info : get_field('homepage_info');
    $homepage_discover = ! empty ( $homepage_discover ) ? $homepage_discover : get_field('homepage_discover');

    // hero image
    $homepage_hero_image = get_field('homepage_hero_photos');
    $size = 'banner_slim'; // hero image size]

    $random_key = array_rand($homepage_hero_image);
    $random_hero = $homepage_hero_image[$random_key];

    $hero_image_url = $random_hero['sizes']['banner'];

@endphp

@extends('single-page-builder')

@section('content')

    <div class="front-header front-page-header">
        @if($hero_image_url)
            <div class="single-photo-overlay"></div>
            <div class="front-photo" style="background-image: url('{{$hero_image_url}}');"></div>
        @endif
        <div class="container-fluid">
            <div class="front-header-content">
                <h2 class="front-title">{{$hero['homepage_hero__headline']}}</h2>
                @if($hero['homepage_hero__cta'])
                    <h3 class="front-subtitle">{{$hero['homepage_hero__cta']}}</h3>
                @endif
                <div class="front-header__form">
                    <form action="#">
                        @php
                            $args = [ 'post_type'   => 'country',
                                      'post_status' => 'publish',
                                      'order'       => 'ASC',
                                      'posts_per_page' => -1 ];

                            $query = new WP_Query($args);
                        @endphp
                        @if ($query->have_posts())
                          <select name="location" id="location">
                            <option>Location</option>
                            @while($query->have_posts()) @php($query->the_post())
                            <option value="{{ get_field('country_id') }}">@php(the_title())</option>
                            @endwhile
                            @php(wp_reset_postdata())
                          </select>
                        @endif
                        @php
                        $program_subjects = [];

                        $args = [ 'post_type'   => 'program',
                                  'post_status' => 'publish',
                                  'posts_per_page' => -1 ];

                        $query = new WP_Query($args);
                        
                        if ($query->have_posts()) :
                          
                          while($query->have_posts()) : $query->the_post();
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
                          
                        endif;
                        

                        @endphp

                        @if (! empty($program_subjects))
                          
                          @php
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

                          $query = new WP_Query($args);

                          @endphp
                        
                          @if ($query->have_posts())
                  
                          <select name="area" id="area">
                            <option>Area of Study</option>
                            @while($query->have_posts()) @php($query->the_post())
                            <option value="{{ get_field('subject_id') }}">@php(the_title())</option>
                            @endwhile
                            @php(wp_reset_postdata())
                          </select>

                          @endif
                        @endif

                        <select name="semester" id="semester">
                            <option value="">Semester</option>
                        </select>
                        <button class="btn btn-lg btn-primary">Go</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <section id="homepage-myths" class="page-section page-section--tall">
        @include('partials.includes.myths-slick')
    </section>

    <section id="homepage-cta" class="page-section page-section--buttons">
        <div class="text-center">
            @if($homepage_cta['homepage_cta__button'])
                @foreach($homepage_cta['homepage_cta__button'] as $button)
                    @php
                        $button_link = $button['homepage_cta__button__link'];
                    @endphp
                    <a href="{{$button_link['url']}}" target="{{$button_link['target']}}" class="btn">
                        @if($button['homepage_cta__button__icon'])
                            <span class="fa {{$button['homepage_cta__button__icon']}}"></span>
                        @endif
                        {{$button_link['title']}}
                    </a>
                @endforeach
            @endif
        </div>
    </section>

    <section id="homepage-social" class="page-section page-section--tall">
        <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="text-center">
                  <h2>#GreatDanesAbroad</h2>
                  @php
                    juicer_feed("name=lorem_ipsumis&per=3&truncate=30");
                  @endphp
                  <a href="/greatdanesabroad" class="btn">See more</a>
                </div>
              </div>
            </div>
        </div>
    </section>

    {{--<section id="homepage-danes-abroad" class="page-section">--}}

    {{--</section>--}}

    {{--<section id="homepage-myths" class="page-section">--}}

    {{--</section>--}}

    <section id="homepage-info" class="page-section page-section--buttons">
        <div class="text-center">
            <h2>Find Scholarships and <strong>Financial Aid</strong></h2>
            @if($homepage_info['homepage_info__button'])
                @foreach($homepage_info['homepage_info__button'] as $button)
                    @php
                        $button_link = $button['homepage_info__button__link'];
                    @endphp
                    <a href="{{$button_link['url']}}" target="{{$button_link['target']}}" class="btn">
                        @if($button['homepage_info__button__icon'])
                            <span class="fa {{$button['homepage_info__button__icon']}}"></span>
                        @endif
                        {{$button_link['title']}}
                    </a>
                @endforeach
            @endif
        </div>
    </section>

    <section id="homepage-discover" class="page-section discover-regions">
        <div class="container">
            <h2 class="section-title">{{$homepage_discover['homepage_discover__title']}}</h2>
            @php
             $args = [
                'post_type'      => 'program',
                'post_status'    => 'publish',
                'posts_per_page' => -1
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
                  
                  $output .= '<h3>' . $v['title'] . '</h3>';
                  $output .= '<ul>';
                  
                  foreach ($v['countries'] as $c_key => $c_val) :
                    $output .= '<li><a href="/countries/' . $c_key . '">' . $c_val['title'] . '</a></li>';
                  endforeach;
                  
                  $output .= '</ul>';
        
                  $prev_country_count = $prev_country_count + count($regions[$k]['countries']);
        
                endforeach;
        
                $output .= '</div><!-- .col-md-3 -->';
        
                $output .= '</div><!-- .row -->';
                
                echo $output;
              endif;

            @endphp
        </div>
    </section>

    @while(have_posts()) @php(the_post())
        <article @php(post_class())>
            @include('partials.page-builder')
        </article>
        @endwhile
@endsection