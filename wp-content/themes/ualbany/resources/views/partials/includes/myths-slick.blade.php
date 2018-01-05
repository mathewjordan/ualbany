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
                   <div class="article myth">
                       <h4 class="myth--title">
                           <span class="fa fa-quote-left"></span>
                           {{get_field('myth')}}
                           <span class="fa fa-quote-right"></span>
                       </h4>
                       <blockquote class="myth--busted">@php echo get_field('myth_busted') @endphp</blockquote>
                       <em class="myth--reference">@php echo get_field('myth_reference') @endphp</em>
                   </div>
               </div>

            @php

        }
        echo '</div>';

        wp_reset_postdata();

    } else {
        // no posts found
    }

@endphp