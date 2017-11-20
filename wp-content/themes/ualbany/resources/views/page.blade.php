@extends('single-page-builder')

@section('content')
    @while(have_posts()) @php(the_post())
        <article @php(post_class())>
            @include('partials.page-builder')
        </article>
    @endwhile
@endsection