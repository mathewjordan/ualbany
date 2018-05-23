{{--
  Template Name: Basic (Full Width, No Banner)
--}}

@extends('layouts.app')

@section('content')
    @while(have_posts()) @php(the_post())
    @include('partials.page-header')
    <div class="full-width">
    @include('partials.content-page')
    </div>
    @endwhile
@endsection