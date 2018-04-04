<div class="container">
  <article @php(post_class())>
    <header>
      <h1 class="entry-title">Programs in {{ get_the_title() }}</h1>
    </header>
    <div class="entry-content">
      @php

      the_content();

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

    </div>
    <footer>
      {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
    </footer>
  </article>
</div>