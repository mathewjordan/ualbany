<?php

$post_type = 'program';

?>

@extends('layouts.app')

@section('content')

	@include('partials.archive-content-list', [
	  'post_type' => $post_type,
	])

@endsection
