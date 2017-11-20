@php


    $title              = ! empty( $title ) ? $title : get_the_title();
    $general_byline     = ! empty( $general_byline ) ? $general_byline : get_field('general_byline');
    $permalink          = ! empty( $permalink ) ? $permalink : get_the_permalink();

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
    <div class="single-header single-page-header">
        @if($hero_image_url) <div class="single-photo" style="background-image: url('{{$hero_image_url}}');"></div> @endif
        <div class="container">
            <div class="single-header-content">
                <h1 class="single-title">{{$title}}</h1>
                @if($general_byline)
                    <h2 class="single-subtitle">{{$general_byline}}</h2>
                @endif
            </div>
        </div>
    </div>
    @while(have_posts()) @php(the_post())
        <article @php(post_class())>
            @include('partials.page-builder')
        </article>
    @endwhile
@endsection