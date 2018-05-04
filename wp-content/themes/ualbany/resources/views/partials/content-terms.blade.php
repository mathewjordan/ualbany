@php
if (isset($_GET['term'])) {
  $term_id = preg_replace("/[^a-z0-9-]/", '', $_GET['term']); // Keep only alphanumeric and dashes
}
else {
  $term_id = 'academic-year';
}
$terms = td_unique_terms();
@endphp

@if($terms[$term_id])

  @php($term_title = $terms[$term_id])

  <article @php(post_class())>
    <div class="single-header--results single-page-header">
      <div class="container-fluid">
          <h1 class="single-title">{{ $term_title }}</h1>
      </div>
    </div>
    <div class="container-fluid">
        <section class="featured-programs ishidden">
          <header>
            <div class="text-center">
              <h2>Featured {{ $term_title }} Programs</h2>
            </div>
          </header>
          @php

          // First query all the programs, so we can parse the terms field
          $args = [
                    'post_type' => 'program',
                    'order'     => 'ASC',
                    'orderby'   => 'title',
                    'posts_per_page' => -1,
                    'offset'    => 0
                  ];

          $programs = get_posts($args);
          $filtered_pids = []; // This holds the post ids for the filtered programs

          @endphp

          @if($programs)
            @php
            foreach ($programs as $prog) :
              $program_meta = td_program_meta($prog);
              $post_term_ids = [];

              foreach ($program_meta['terms'] as $t) :
                $post_term_ids[] = str_to_machine($t);
              endforeach;

              if (in_array($term_id, $post_term_ids)) :
                $filtered_pids[] = $prog->ID;
              endif;
            endforeach;

            $args = [
                      'post_type' => 'program',
                      'order'     => 'ASC',
                      'orderby'   => 'title',
                      'posts_per_page' => -1,
                      'post__in' => $filtered_pids,
                      'meta_query' => [ [ 'key' => 'program_featured',
                                          'value' => '1',
                                          'compare' => '==' ] ]
                      
                    ];

            $query = new WP_Query($args);

            @endphp
                            
            @if ($query->have_posts())
              @while($query->have_posts()) @php($query->the_post())
                @include('partials.content-program')
              @endwhile
              @php(wp_reset_postdata())
            @endif
          @endif


        </section>
    
        <section class="all-programs">
          <header>
            <div class="text-center">
              <h2>All {{ $term_title }} Programs</h2>
            </div>
          </header>
          @php

          $args = [
                    'post_type' => 'program',
                    'order'     => 'ASC',
                    'orderby'   => 'title',
                    'posts_per_page' => -1,
                    'post__in' => $filtered_pids
                  ];

          $query = new WP_Query($args);

          @endphp

          @include('partials.table-programs')
          
        </section>
    </div>
  </article>

@endif