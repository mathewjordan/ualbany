@php
    $sidebar = get_field('sidebar_item', 'option');
@endphp

@if ($sidebar)

    @php
        switch (count($sidebar)) {
            case 1:
                $colClasses = 'col-sm-12 col-md-6 col-md-offset-3';
                break;
            case 2:
                $colClasses = 'col-sm-12 col-md-4 col-md-offset-2';
                break;
            case 3:
                $colClasses = 'col-sm-12 col-md-4';
                break;
            case 4:
                $colClasses = 'col-sm-12 col-md-3';
                break;
            default:
                $colClasses = 'col-sm-12 col-md-6 col-md-offset-3';
        }
    @endphp

    <div class="cta-items">
        <div class="row">
            @foreach ($sidebar as $k => $item)
                <div class="{{$colClasses}}">

                    @php($stype = $item['sidebar_item_type'])

                    @if ($item['button_text'] == 'Apply Now')
                        @php($btnClass = 'btn-primary')
                    @else
                        @php($btnClass = 'btn-default')
                    @endif

                    @if ($stype == 'button_ex')
                        <a href="{{ $item['sidebar_button_ex'] }}" target="_blank"
                           class="btn btn-lg btn-block {{$btnClass}}">{{ $item['button_text'] }}</a>
                    @endif

                    @if ($stype == 'button_in')
                        <a href="{{ $item['sidebar_button_in'] }}"
                           class="btn btn-lg btn-block">{{ $item['button_text'] }}</a>
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

                </div>
            @endforeach

        </div>

    </div>

@endif