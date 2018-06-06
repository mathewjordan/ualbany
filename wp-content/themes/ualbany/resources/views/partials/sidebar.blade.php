@php
    $sidebar = get_field('sidebar_item', 'option');
@endphp

@if ($sidebar)

    <div class="sidebar-items">

    @foreach ($sidebar as $k => $item)

        @php($stype = $item['sidebar_item_type'])

        @if ($item['button_text'] == 'Apply Now')
            @php($btnClass = 'btn-primary')
        @else
            @php($btnClass = 'btn-default')
        @endif

        @if ($stype == 'button_ex')
            <a href="{{ $item['sidebar_button_ex'] }}" target="_blank" class="btn btn-lg btn-block {{$btnClass}}">{{ $item['button_text'] }}</a>
        @endif

        @if ($stype == 'button_in')
            <a href="{{ $item['sidebar_button_in'] }}" class="btn btn-lg btn-block">{{ $item['button_text'] }}</a>
        @endif

        @if(!is_page_template('views/page-student-stories.blade.php'))
            @if ($stype == 'student')
                @include('partials.components.student_story')
            @endif
        @endif

        @if ($stype == 'content')
            <div>
                {content}
            </div>
        @endif

    @endforeach

    </div>

@endif