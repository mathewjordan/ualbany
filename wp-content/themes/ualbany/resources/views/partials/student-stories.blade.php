<?php

$args = array(
    'post_type' => 'student',
);

$stories = array();
$cnt = 0;

// the query
$the_query = new WP_Query($args); ?>

<?php if ( $the_query->have_posts() ) : ?>

<div id="accordion" class="accordions student-stories">


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

    $stories[$region][$cnt]['name'] = get_the_title();
    $stories[$region][$cnt]['program'] = $program;
    $stories[$region][$cnt]['country'] = $country;
    $stories[$region][$cnt]['body'] = get_the_content();
    $stories[$region][$cnt]['photos'] = get_field('story_photos');

    $cnt++;
?>
<?php endwhile; ?>

    <?php foreach ($stories as $region => $region_stories) : ?>
        <div class="card">
            <div class="card-header" id="@php echo sanitize_html_class($region); @endphp">
                <h2 class="mb-0">
                    <button class="collapsed" data-toggle="collapse" data-target="#@php echo sanitize_html_class($region) . '_c'; @endphp" aria-expanded="true" aria-controls="@php echo sanitize_html_class($region) . '_c'; @endphp">
                        @php echo $region; @endphp
                    </button>
                </h2>
            </div>

            <div id="@php echo sanitize_html_class($region) . '_c'; @endphp" class="collapse" aria-labelledby="@php echo sanitize_html_class($region); @endphp" data-parent="#accordion">
                <div class="card-body">
                    <?php foreach ($region_stories as $k => $story) :
                        if ($story['photos'][0]) {
                            $thumb = $story['photos'][0]['sizes']['slide_thumb'];
                        }
                        ?>
                        <div class="story" id="@php echo sanitize_html_class($story['name']); @endphp">
                            @if($thumb)
                                <img class="student-story-thumb" src="{{$thumb}}" alt="{{$story['photos'][0]['alt']}}" />
                            @endif
                            <h3>{{ $story['name'] }}</h3>
                            <h4>{{ $story['program'] }}</h4>
                            <h5>{{ $story['country'] }}</h5>
                            <div>{{ $story['body'] }}</div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endforeach ?>

</div>

<?php wp_reset_postdata(); ?>
<?php endif; ?>