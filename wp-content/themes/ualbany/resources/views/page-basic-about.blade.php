{{--
  Template Name: About
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
                @if($general_byline)
                    <h2 class="single-subtitle">{{$general_byline}}</h2>
                @endif
            </div>
        </div>
    </div>

    @while(have_posts()) @php(the_post())
    <article @php(post_class())>
        @if (get_field('about_body'))
            <section class="section-body">
                <div class="container">
                    @php(the_field('about_body'))
                </div>
            </section>
        @endif

        @if (get_field('about_feature'))
            <section class="section-feature">
                <div class="container">
                    @php(the_field('about_feature'))
                </div>
            </section>
        @endif

        @php $contact_group = get_field('about_contact'); @endphp
        @if ($contact_group)
            <section id="contact" class="section-contact">
                <div class="container">
                    <div class="section-contact-wrap">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12"> @php echo $contact_group['about_contact_office']; @endphp </div>
                            <div class="col-sm-6 col-xs-12"> @php echo $contact_group['about_contact_emergency']; @endphp </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if (have_rows('about_staff'))
            <section class="section-staff">
                <div class="container">
                    <div class="staff-wrap">
                        <h2 class="text-center">Meet the Staff</h2>
                        @php while (have_rows('about_staff')) : the_row(); @endphp
                        <div class="row">
                            <div class="staff-article">
                                @if (get_sub_field('about_staff_photo'))
                                    @php
                                        $image = get_sub_field('about_staff_photo');
                                        $size = 'thumbnail';
                                    @endphp
                                    <div class="col-md-3">
                                        <div class="image">
                                            <?php echo wp_get_attachment_image($image, $size); ?>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-9">
                                    <p class="title">
                                        @php if (get_sub_field('about_staff_title')): the_sub_field('about_staff_title'); endif; @endphp
                                        @php if (get_sub_field('about_staff_title_subtitle')): the_sub_field('about_staff_title_title'); endif; @endphp
                                        @php if (get_sub_field('about_staff_title_subtitle')): the_sub_field('about_staff_title_subtitle'); endif; @endphp
                                    </p>
                                    <p class="description">@php the_sub_field('about_staff_description'); @endphp</p>
                                </div>
                            </div>
                        </div>
                        @php endwhile; @endphp
                    </div>
                </div>
            </section>
        @endif

        <section id="gift" class="section-gift">
            <div class="container">
                <div class="section-gift-wrap">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12"> @php the_field('about_gift_one'); @endphp </div>
                        <div class="col-sm-6 col-xs-12"> @php the_field('about_gift_two'); @endphp </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-cta-primary">
            <div class="container">
                @include('partials.cta-primary')
            </div>
        </section>
    </article>
    @endwhile
@endsection