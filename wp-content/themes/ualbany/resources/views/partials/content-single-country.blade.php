@php($country = get_the_title())

<article @php(post_class())>
  <div class="single-header--results single-page-header">
    <div class="container-fluid">
        <h1 class="single-title">{{ $country }}</h1>
    </div>
  </div>
  <div class="container-fluid">
      <section class="featured-programs ishidden">
        <header>
          <div class="text-center">
            <h2>Featured {{ $country }} Programs</h2>
          </div>
        </header>
        @php

        $args = [
                  'post_type' => 'program',
                  'order'     => 'ASC',
                  'orderby'   => 'title',
                  'posts_per_page' => -1,
                  'meta_query' => [
                    relation => 'AND',
                    [
                      'key'     => 'program_country',
                      'value'   => get_the_ID(),
                      'compare' => '=='
                    ],
                    [ 'key' => 'program_featured',
                      'value' => '1',
                      'compare' => '=='
                    ]
                  ]
                ];

        $query = new WP_Query($args);
        $postnum = 0;
        @endphp

        @if ($query->have_posts())
          @while($query->have_posts()) @php($query->the_post())
            @include('partials.content-program')
          @endwhile
          @php(wp_reset_postdata())
        @else
          <style>.ishidden { display: none; }</style>
        @endif
      </section>
  
      <section class="all-programs">
        <header>
          <div class="text-center">
            <h2>All {{ $country }} Programs</h2>
          </div>
        </header>
        @php

        $args = [
                  'post_type' => 'program',
                  'order'     => 'ASC',
                  'orderby'   => 'title',
                  'posts_per_page' => -1,
                  'meta_query' => [
                    [
                      'key'     => 'program_country',
                      'value'   => get_the_ID(),
                      'compare' => '=='
                    ]
                  ]
                ];

        $query = new WP_Query($args);

        @endphp

        @include('partials.table-programs')
        
      </section>
  </div>
</article>