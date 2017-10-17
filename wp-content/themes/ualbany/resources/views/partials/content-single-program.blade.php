<?php

$render = [
  'Overview'       => 'program_overview',
  'Location'       => 'program_location',
  'Costs'          => 'program_costs',
  'Excursions'     => 'program_excursions',
  'Duration'       => 'program_duration',
  'Testimonials'   => 'program_testimonials',
  'Accommodations' => 'program_accommodations',
  'Selection'      => 'program_selection',
  'Description'    => 'program_description',
];

?>

<article @php(post_class())>
    <header>
        <h1 class="entry-title">{{ get_the_title() }}</h1>
    </header>
    <div class="entry-content">

        <a href="https://ualbany.studioabroad.com/index.cfm?FuseAction=ProgramAdmin.BrochureEdit&Program_ID={{get_field('program_id')}}" target="_blank">Edit in Terra Dotta</a>

        <!-- Tabs -->
        <ul class="nav nav-tabs" role="tablist">
            @php($cnt = 0)
                @foreach($render as $title => $selector)
                    @if (get_field($selector))
                    @php
                        if ($cnt == 0) {
                          $first = 1;
                        } else {
                          $first = 0;
                        }
                        $cnt++;
                    @endphp
                    <li class="nav-item">
                        <a class="nav-link @if($first == 1) active @endif" href="#{{strtolower($title)}}" role="tab"
                           data-toggle="tab">{{$title}}</a>
                    </li>
                    @endif
                @endforeach
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            @php($cnt = 0)
                @foreach($render as $title => $selector)
                    @if (get_field($selector))
                    @php
                        if ($cnt == 0) {
                          $first = 1;
                        } else {
                          $first = 0;
                        }
                        $cnt++;
                    @endphp
                    <div role="tabpanel" class="tab-pane @if($first == 1) active in @endif"
                         id="{{strtolower($title)}}">@php(the_field($selector))</div>
                    @endif
                @endforeach
        </div>


    </div>
    <footer>
        {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
    </footer>
    @php(comments_template('/partials/comments.blade.php'))
</article>
