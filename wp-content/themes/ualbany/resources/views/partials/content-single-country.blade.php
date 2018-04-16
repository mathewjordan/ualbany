<div class="container">
  <article @php(post_class())>
    <header>
      <h1 class="sr-only">{{ get_the_title() }} Programs</h1>
    </header>
    <div class="entry-content">
      <section>
        <header>
          <h2>Featured {{ get_the_title() }} Programs</h2>
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

        @if ($query->have_posts())
          @while($query->have_posts()) @php($query->the_post())
            @include('partials.content-program')
          @endwhile
          @php(wp_reset_postdata())
        @endif
      </section>
      <section>
        <header>
          <h2>All {{ get_the_title() }} Programs</h2>
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
      </section>
      
    </div>
    <footer>
      {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
    </footer>
  </article>
</div>