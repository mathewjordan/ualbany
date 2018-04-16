<div class="single-header single-page-header">
  <div class="container-fluid">
    <div class="single-header-content">
      <h1 class="single-title">{{ get_the_title() }}</h1>
    </div>
  </div>
</div>
<div class="container">
  <article @php(post_class())>
    <header>
      <h1 class="sr-only">{{ get_the_title() }} Programs</h1>
    </header>
    <div class="entry-content">
      <section>
        <header>
          <div class="text-center">
            <h2>Featured {{ get_the_title() }} Programs</h2>
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

        @if ($query->have_posts())
          @while($query->have_posts()) @php($query->the_post())
            @include('partials.content-program')
          @endwhile
          @php(wp_reset_postdata())
        @endif
      </section>
      <section>
        <header>
          <div class="text-center">
            <h2>All {{ get_the_title() }} Programs</h2>
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
  </article>
</div>