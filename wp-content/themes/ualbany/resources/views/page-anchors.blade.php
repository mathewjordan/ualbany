{{--
  Template Name: Basic (w/ Anchor Menu)
--}}

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

@extends('layouts.app')

@section('content')
    <div class="single-header single-page-header">
        @if($hero_image_url)
            <div class="single-photo-overlay"></div>
            <div class="single-photo" style="background-image: url('{{$hero_image_url}}');"></div>
        @endif
        <div class="container-fluid">
            <div class="single-header-content">
                <h1 class="single-title">{{$title}}</h1>
            </div>
        </div>
    </div>

    @while(have_posts()) @php(the_post())
    <article @php(post_class())>
        <div id="anchor-catch"></div>
        <section class="introduction-section">
            <div class="container">
                <div class="row">
                    <aside class="col-sm-4">
                        <div id="anchor-menu">
                            <div class="submenu--siblings">
                                <ul>
                                    @if( have_rows('anchor') )
                                        @while ( have_rows('anchor') )
                                        @php
                                            the_row();
                                        @endphp
                                            <li><a href="#@php echo sanitize_html_class(get_sub_field('anchor_menu_title')); @endphp">@php the_sub_field('anchor_menu_title'); @endphp</a></li>
                                        @endwhile
                                    @endif
                                </ul>
                            </div>
                            @include('partials.sidebar')
                        </div>
                    </aside>

                    <div class="col-sm-8">
                        <div class="introduction-section--content">
                            @php(the_field('page_introduction_content'))
                            @if( have_rows('anchor') )
                                <div class="anchor-sections">
                                    @while ( have_rows('anchor') )
                                        @php(the_row())
                                    <section id="@php echo sanitize_html_class(get_sub_field('anchor_menu_title')); @endphp" class="anchor-section">
                                        <h2><a>@php(the_sub_field('anchor_section_title'))</a></h2>
                                        <div>@php(the_sub_field('anchor_section_content'))</div>
                                    </section>
                                    @endwhile
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </article>
    @endwhile
@endsection

<script>
</script>