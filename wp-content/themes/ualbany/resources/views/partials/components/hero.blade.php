@php

$video_id = null;

if( ! empty( $content[ 'youtube_video_url' ] ) ) {
    $youtube_data   = parse_url( $content[ 'youtube_video_url' ] );
    $video_id      = explode( '/', $youtube_data[ 'path'] );
    $video_id      = array_pop( $video_id );
}
@endphp
<div class="component-hero-wrap">
    @if($content['background_image'])
        @php($image = wp_get_attachment_image( $content[ 'background_image' ][ 'ID' ], 'full' ))
        <figure class="placeholder-image">
            {!! $image !!}
        </figure>
    @endif
    @if($video_id)
    <div class="video-background">
        <div class="video-ratio--wrapper">
            <div class="content" data-maintain-ratio="16/9">
                <div id="heroVideoTarget" data-video-id="{{$video_id}}"></div>
            </div>
        </div>
    </div>
    @endif
    <div class="video-foreground">
        @if( isset( $content[ 'tagline_line_1' ] ) )
            <h1 class="tagline">
                {{$content[ 'tagline_line_1' ]}}
                @if( isset( $content[ 'tagline_line_2' ] ) )
                    <strong>{{$content[ 'tagline_line_2' ]}}</strong>
                @endif
            </h1>
        @endif
        <nav class="external-user-menu">
            {{-- @todo Pull in Get Stared text from one main source --}}
            <h3>
                <span></span><span>Get Started</span><span></span>
            </h3>
            {!! wp_nav_menu( $menu_args ) !!}
        </nav>
    </div>
</div>