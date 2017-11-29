@php

    $title     = ! empty( $title ) ? $title : get_the_title();
    $hero      = ! empty ( $hero ) ? $hero : get_field('homepage_hero');
    $permalink = ! empty( $permalink ) ? $permalink : get_the_permalink();

    $homepage_cta      = ! empty ( $homepage_cta ) ? $homepage_cta : get_field('homepage_cta');
    $homepage_info     = ! empty ( $homepage_info ) ? $homepage_info : get_field('homepage_info');
    $homepage_discover = ! empty ( $homepage_discover ) ? $homepage_discover : get_field('homepage_discover');

    // hero image
    $general_hero_image = get_field('general_hero_image');
    $size = 'banner_slim'; // hero image size

    // if acf value exists for specific page, else get customizer default
    if ($general_hero_image) {
        $hero_image_url = $general_hero_image[ 'sizes' ][ $size ];
    } else {
        $default_image_url = get_theme_mod('default_settings__hero_image'); // get default hero image theme_mod from customizer
        $default_image_id  = attachment_url_to_postid($default_image_url); // recursively get ID by default url to get scalable image
        $hero_image_src    = wp_get_attachment_image_src($default_image_id, $size);
        $hero_image_url    = $hero_image_src[0]; // screwy indexing by wordpress on this function: 0 = URL, 1 = width, 2 = height
    }

@endphp

@extends('single-page-builder')

@section('content')
    <div class="front-header front-page-header">
      @if($hero_image_url) <div class="front-photo" style="background-image: url('{{$hero_image_url}}');"></div> @endif
      <div class="container">
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
                        'order'       => 'ASC' ];

              $query = new WP_Query($args);
              @endphp
              @if ($query->have_posts())
              <select name="location" id="location">
                <option disabled>Location</option>
                @while($query->have_posts()) @php($query->the_post())
                <option value="">@php(the_title())</option>
                @endwhile
                @php(wp_reset_postdata())
              </select>
              @endif
              @php
              $args = [ 'post_type'   => 'subject',
                        'post_status' => 'publish',
                        'order'       => 'ASC' ];

              $query = new WP_Query($args);
              @endphp
              <select name="area" id="area">
                <option disabled>Area of Study</option>
              </select>
              <select name="semester" id="semester">
                <option disabled>Semester</option>
              </select>
            </form>
          </div>
        </div>
      </div>
    </div>

    <section id="homepage-cta" class="page-section page-section--buttons">
      <div class="text-center">
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
      </div>
    </section>

    <section id="homepage-info" class="page-section page-section--buttons">
      <div class="text-center">
      <h2>Find Scholarships and Financial Aid</h2>
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
      </div>
    </section>

    <section id="homepage-discover" class="page-section discover-regions">
      <h2 class="section-title">{{$homepage_discover['homepage_discover__title']}}</h2>
      <div class="container">
        <div class="row">
        @php
        $args = [ 'post_type'   => 'region',
                  'post_status' => 'publish',
                  'order'       => 'ASC' ];

        $query = new WP_Query($args);
        @endphp
        @if ($query->have_posts())
          @while($query->have_posts()) @php($query->the_post())
          <div class="col-sm-4">
            <h3>@php(the_title())</h3>
          </div>
          @endwhile
          @php(wp_reset_postdata())
        @endif
        </div>
      </div>
    </section>
    
    @while(have_posts()) @php(the_post())
    <article @php(post_class())>
        @include('partials.page-builder')
    </article>
    @endwhile
@endsection