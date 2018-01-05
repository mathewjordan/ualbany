@php

    $args = array(
        'post_type'         => 'myth',
        'posts_per_page'    => 5,
        'orderby'           => 'rand',
        'order'             => 'ASC'
    );

    $the_query = new WP_Query( $args );

    // The Loop
    if ( $the_query->have_posts() ) {
        echo '<div class="myths-slick">';
        while ( $the_query->have_posts() ) {

            $the_query->the_post();

            @endphp

               <div>
                   <h4>{{get_field('myth_myth')}}</h4>
                   @php echo get_field('myth_myth_busted') @endphp
               </div>

            @php

        }
        echo '</div>';

        wp_reset_postdata();

    } else {
        // no posts found
    }

@endphp