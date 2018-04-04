@php( $subject_id = get_field('subject_id') )

<div class="container">
  <article @php(post_class())>
    <header>
      <h1 class="entry-title">Programs with {{ get_the_title() }}</h1>
    </header>
    <div class="entry-content">
      @php

      the_content();

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
                    'post__in' => $filtered_pids
                  ];

          $query = new WP_Query($args);

          @endphp
                          
          @if ($query->have_posts())
            <article @php(post_class())>
            @while($query->have_posts()) @php($query->the_post())
              <a href="{{ get_the_permalink() }}">
                <h2>{{ get_the_title() }}</h2>
              </a>
            @endwhile
            </article>
            @php(wp_reset_postdata())
          @endif

        @php
        endif;
      endif;
      @endphp

    </div>
    <footer>
      {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
    </footer>

  </article>
</div>