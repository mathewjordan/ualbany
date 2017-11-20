<?php
/**
 * @var array $content
 *
 */
?>
<div class="component-link-list-wrap component-wrap">
    <h3>{{$content[ 'title' ]}}</h3>
    <ul class="ul-link">
        @foreach($content[ 'links' ] as $link)
            <li>
                @if( $link[ 'is_link' ] )
                    @if( ! empty( $link[ 'internal_link' ] ) )
                        <a href="{{ $link[ 'internal_link' ][ 'url' ] }}">
                            @if( ! empty( $link[ 'internal_link' ][ 'title' ] ) )
                                {{ $link[ 'internal_link' ][ 'title' ] }}
                            @else
                                @php
                                    $title      = $link[ 'internal_link' ][ 'url' ];
                                    $url_parts  = parse_url( $link[ 'internal_link' ][ 'url' ] );

                                    if( ! empty( $url_parts[ 'path' ] ) ) {

                                        if( $page = get_page_by_path( trim( $url_parts[ 'path' ], '/' ) ) )
                                            $title = $page->post_title;
                                    }
                                @endphp
                                {{ $title }}
                            @endif
                        </a>
                    @elseif( ! empty( $link[ 'external_link' ] ) && ! empty( $link[ 'text' ] ) )
                        <a href="{{ $link[ 'external_link' ] }}" target="_blank">
                            {{ ! empty( $link[ 'text' ] ) ? $link[ 'text' ] : $link[ 'external_link' ] }}
                        </a>
                    @endif
                @else
                    <span>
                        {{ $link[ 'text' ] }}
                    </span>
                @endif
            </li>
        @endforeach
    </ul>
</div>
