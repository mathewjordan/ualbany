<?php
/**
 * @var array $content
 *
 * $content[ 'events_title' ];
 */

use UNCGBryan\Essentials\Models\Events;

$today = current_time('Ymd');
$args = [
    'posts_per_page'    => + $content[ 'event_count' ],
    'post_type'         => Events\Events::CPT_NAMESPACE,
    'post_status'    => 'publish',
    'meta_key'			=> 'start_date',
    'orderby'			=> 'meta_value',
    'order'				=> 'ASC',
    'meta_query'	=> array(
      'relation'		=> 'AND',
      array(
        'key'	  	=> 'start_date',
        'value'	  	=> $today,
        'compare' => '>=',
      ),
    ),
];

if( ! empty( $content[ 'event_category' ] ) ) {
    $args = array_merge( $args, [
        'tax_query' => [
            [
                'taxonomy' => Events\EventsTaxonomy::TAXONOMY_CATEGORY,
                'field' => 'id',
                'terms' => [ + $content[ 'event_category' ] ],
            ],
        ],
    ]);
}

$the_query = new WP_Query( $args ); ?>
<div class="component-event-block-wrap component-wrap">
    <h3>{{$content[ 'events_title' ]}}</h3>
    <?php

    // The Loop
    if ( $the_query->have_posts() ) {
        echo '<ul>';
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            $post_id    = get_the_ID();
            $title      = get_the_title();
            $excerpt    = get_the_excerpt();
            $link       = get_the_permalink();
            $fields     = get_fields( $post_id );
            $start_date = $fields[ 'start_date' ];
            $start_day= ! empty( $start_date ) ? date( 'd', strtotime( $start_date ) ) : null;
            $start_month= ! empty( $start_date ) ? date( 'M', strtotime( $start_date ) ) : null;
            ?>
            <li class="event-block-single">
                <div class="event-instance">
                    <div class="event-date">
                      <span class="event-date__start">
                        <strong>{{$start_month}}</strong>
                        <em>{{$start_day}}</em>
                      </span>
                    </div>
                    <a href="{{$link}}">
                        {{$title}}
                    </a>
                </div>
            </li>
            <?php
        }
        echo '</ul>';
        /* Restore original Post Data */
        wp_reset_postdata();
    }

    if( empty( $content[ 'event_category' ] ) ){
        $link = get_post_type_archive_link( Events\Events::CPT_NAMESPACE );
    }else{
        $link = get_term_link( $content[ 'event_category' ] );
    }
    ?>
    @if( isset( $content[ 'button' ] ) && ! empty( $content[ 'button' ] ) )
        @foreach($content[ 'button' ] as $button)
            @php( $button['link'] = $link )
            @include(
                'partials.components.elements.button',
                 \VC\PageBuilder\Core\extract_button_info_from_content( $button )
            )
        @endforeach
    @endif
</div>
