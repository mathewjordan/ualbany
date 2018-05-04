@php

$subject_id = get_field('subject_id');
$subject    = get_the_title();

@endphp

<article @php(post_class())>
  <div class="single-header single-page-header">
    <div class="container-fluid">
      <div class="single-header-content">
        <h1 class="single-title">{{ $subject }}</h1>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <section class="featured-programs ishidden">
      <header>
        <div class="text-center">
          <h2>Featured {{ $subject }} Programs</h2>
        </div>
      </header>
      @php

      if ($subject_id) :

        // First query all the programs, so we can parse the subject field
        $args = [
                  'post_type' => 'program',
                  'order'     => 'ASC',
                  'orderby'   => 'title',
                  'posts_per_page' => -1,
                  'offset'    => 0
                ];

        $programs = get_posts($args);
        $filtered_pids = []; // This holds the post ids for the filtered programs

        if ($programs) :
  
          foreach ($programs as $prog) :
            $subjects_str = get_field('program_subject', $prog->ID);

            if ($subjects_str) :
              $subjects = explode(',', $subjects_str);

              // If the program has the subject, add it to the array
              if (in_array($subject_id, $subjects)) {
                $filtered_pids[] = $prog->ID;
              }
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

        @php
        endif;
      endif;
      @endphp
    </section>
    <section class="all-programs">
      <header>
        <div class="text-center">
          <h2>All {{ $subject }} Programs</h2>
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