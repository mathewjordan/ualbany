<?php
/**
 * @var array $content
 *
 * $content[ 'events_title' ];
 */

use UNCGBryan\Essentials\Models\News;

$args = [
    'posts_per_page'    => + $content[ 'news_count' ],
    'post_type'         => News\News::CPT_NAMESPACE
];

if( ! empty( $content[ 'news_category' ] ) ) {
    $args = array_merge( $args, [
        'tax_query' => [
            [
                'taxonomy' => News\NewsTaxonomy::TAXONOMY_CATEGORY,
                'field' => 'id',
                'terms' => [ + $content[ 'news_category' ] ],
            ],
        ],
    ]);
}

$the_query = new WP_Query( $args ); ?>
<div class="component-news-block-wrap component-wrap">
    <h3>{{$content[ 'news_title' ]}}</h3>
    <?php

    // The Loop
    if ( $the_query->have_posts() ) {
        echo '<ul class="news-block-results">';
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            $post_id    = get_the_ID();
            $title      = get_the_title();
            $excerpt    = get_the_excerpt();
            $link       = get_the_permalink();
            $fields     = get_fields( $post_id );

            //var_dump($fields);
            ?>
            <li class="news-block-single">
                <a href="{{$link}}"><span class="icon-angle-right"></span> {{$title}}</a>
            </li>
            <?php
        }
        echo '</ul>';
        /* Restore original Post Data */
        wp_reset_postdata();
    }

    if( empty( $content[ 'event_category' ] ) ){
        $link = get_post_type_archive_link( News\News::CPT_NAMESPACE );
    }else{
        $link = get_term_link( $content[ 'news_category' ] );
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
