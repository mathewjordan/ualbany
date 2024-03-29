{{--
  Template Name: Student Stories
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
                <h1 class="single-title mb-0">{{$title}}</h1>
            </div>
        </div>
    </div>

    @while(have_posts()) @php(the_post())
    <article @php(post_class())>
        <section class="introduction-section">
            <div class="container">
                <div class="row">
                    <?php
                    $args = array(
                        'post_type' => 'page',
                        'posts_per_page' => -1,
                        'post_parent' => $post->ID,
                        'order' => 'ASC',
                        'orderby' => 'menu_order'
                    );

                    $parent = new WP_Query($args);
                    if ( $parent->have_posts() ) :
                    $submenu = true;

                    ?>

                    <aside class="col-sm-4">
                        <div class="submenu--siblings">
                            <ul>
                                <li class="active-sibling"><a href="<?php the_permalink(); ?>"
                                                              title="<?php the_title(); ?>"><span
                                                class="fa fa-caret-right"></span> <?php the_title(); ?></a></li>
                                <?php while ( $parent->have_posts() ) : $parent->the_post(); ?>
                                <li><a href="<?php the_permalink(); ?>"
                                       title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                        @include('partials.sidebar')
                    </aside>

                    <?php endif; wp_reset_postdata(); ?>
                    <?php

                    $locations = get_nav_menu_locations();

                    if (get_field('menu')) {
                        if (get_field('menu') == 'primary') {
                            $menu = wp_get_nav_menu_object($locations['primary_navigation']);
                        } else if (get_field('menu') == 'utility') {
                            $menu = wp_get_nav_menu_object($locations['utility_navigation']);
                        }
                    } else {
                        $menu = wp_get_nav_menu_object($locations['primary_navigation']);
                    }

                    $menu_items = wp_get_nav_menu_items($menu->term_id);
                    $utility_menu = wp_get_nav_menu_items($menu->term_id);

                    $parent_id = false;
                    $parent = '';
                    $siblings = '';
                    $page_template = get_page_template_slug();
                    $menu_post_id = $post->ID;

                    if( !empty($menu_items) ) {

                    // Find the menu item parent for this page
                    foreach ($menu_items as $menu_item) {
                        if ($menu_item->object_id == $menu_post_id) {
                            $parent_id = $menu_item->menu_item_parent;
                            break;
                        }
                    }

                    if ($parent_id) {

                        echo '<aside class="col-sm-4">';

                        $submenu = true;

                        $siblings .= '<div class="submenu--siblings">';
                        $siblings .= '<ul>';

                        // render parent item
                        $parent_item_post_id = get_post_meta($parent_id, '_menu_item_object_id', 1);
                        $siblings .= '<li><a href="' . get_the_permalink($parent_item_post_id) . '">' . get_the_title($parent_item_post_id) . '</a></li>';

                        // render children
                        foreach ($menu_items as $menu_item) {
                            if ($menu_item->menu_item_parent == $parent_id) {
                                if ($menu_item->object_id == $menu_post_id) {
                                    $siblings .= '<li class="active-sibling"><a href="' . $menu_item->url . '"><span class="fa fa-caret-right"></span> ' . $menu_item->title . '</a></li>';
                                } else {
                                    $siblings .= '<li><a href="' . $menu_item->url . '">' . $menu_item->title . '</a></li>';
                                }
                            }
                        }
                        $siblings .= '</ul>';
                        $siblings .= '</div>';

                        echo $parent . $siblings;
                        ?>
                        @include('partials.sidebar')
                        <?php
                        echo '</aside>';
                    }
                    }
                    ?>
                    <div class="col-sm-8">
                        <div class="introduction-section--content">
                            <?php echo get_field('page_introduction_content');?>
                            @include('partials.student-stories')
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-page-main">
            <div class="container">
                @include('partials.content-page')
            </div>
        </section>

    </article>
    @endwhile
@endsection