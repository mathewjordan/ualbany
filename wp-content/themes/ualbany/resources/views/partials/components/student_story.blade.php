<?php

$args = array(
    'post_type' => 'student',
    'orderby' => 'rand',
    'posts_per_page' => 1
);

// the query
$the_query = new WP_Query($args); ?>

<?php if ( $the_query->have_posts() ) : ?>


<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
    <?php
    $input = get_field('input_method');
    if ($input == 'manual') {
        $program = get_field('story_program_name');
        $country = get_field('story_program_country');
        $region = get_field('story_program_region');
    } else {
        $program_rel = get_field('story_program_name_auto');
        $country_rel = get_field('story_program_country_auto');
        $region_rel = get_field('story_program_region_auto');
        $program = $program_rel[0]->post_title;
        $country = $country_rel[0]->post_title;
        $region = $region_rel[0]->post_title;
    }

        $photos = get_field('story_photos');
        if ($photos[0]) {
            $thumb = $photos[0]['sizes']['slide_thumb'];
        }
    ?>
    <div class="featured-student-story @if($thumb) has-thumb @endif">
        <div class="featured-student-story-wrapper">
            @if($thumb)
                <div class="featured-student-story--thumb" style="background-image: url('{{$thumb}}');"></div>
            @endif
            <h2>Featured Student Story</h2>
            <a href="/student-stories#@php echo sanitize_html_class(get_the_title()); @endphp"><h3><?php the_title(); ?></h3></a>
            <h4>{{$program}}</h4>
            <h5>{{$country}}, {{$region}}</h5>
        </div>
    </div>
    <?php endwhile; ?>

    <?php wp_reset_postdata(); ?>
<?php endif; ?>