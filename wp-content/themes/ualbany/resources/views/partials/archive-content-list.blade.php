@php

$post_type_obj = get_post_type_object($post_type);

@endphp

<div class="facetwp-template archive--content-list">
  <div class="container">
  @while (have_posts()) @php(the_post())
    <header>
      <h1 class="entry-title">{{ $post_type_obj->label }}</h1>
    </header>
    @if($post_type == 'program')
    <a href="{{get_the_permalink()}}">
      <h2>
        @if(get_field('program_td_format'))
          <span class="fa fa-check-square"></span>
        @else
          <span class="fa fa-square-o"></span>
        @endif
        {{ the_title() }}
      </h2>
    </a>
    @else
    <a href="{{get_the_permalink()}}"><h2>{{the_title()}}</h2></a>
    @endif
  @endwhile
  </div>
</div>