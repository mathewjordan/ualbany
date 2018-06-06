@php
    $sidebar = get_field('sidebar_item', 'option');
@endphp

@if ($sidebar)

    <div class="sidebar-items">

    @foreach ($sidebar as $k => $item)

        @php($stype = $item['sidebar_item_type'])

        @if ($stype == 'button_ex')
            <a href="{{ $item['sidebar_button_ex'] }}" target="_blank" class="btn btn-lg btn-block">{{ $item['button_text'] }}</a>
        @endif

        @if ($stype == 'button_in')
            <a href="{{ $item['sidebar_button_in'] }}" class="btn btn-lg btn-block">{{ $item['button_text'] }}</a>
        @endif

        @if ($stype == 'student')
            @include('partials.components.student_story')
        @endif

        @if ($stype == 'content')
            <div>
                {content}
            </div>
        @endif

    @endforeach

    </div>

@endif