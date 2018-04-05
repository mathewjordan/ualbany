<?php

$post_type = 'fs';

?>

@extends('layouts.app')

@section('content')

  @include('partials.archive-content-list', [
    'post_type' => $post_type,
  ])

@endsection
