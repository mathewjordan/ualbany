@extends('layouts.app')

@section('content')
    @while(have_posts()) @php(the_post())
    <article @php(post_class())>
        <div class="entry-content">
            @yield('page-content')
            @include('partials.page-builder')
        </div>
    </article>
    @endwhile
@endsection