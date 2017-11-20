<?php
/**
 * @var array $content
 */
$id = "slider_wrap_" . substr(str_shuffle(MD5(microtime())), 0, 5);
?>
<div class="component-testimonial-panels-wrap component-wrap">
    <div class="row-slider-wrap" id="{{$id}}">
        <div class="row-slider-content">
            @foreach($content['panel'] as $panel)
                @php( $no_top = empty( $panel[ 'top_title' ] ) && empty( $panel[ 'top_subtitle' ] ) )
                <div class="slider-item {{ $loop->iteration == 1 ? 'current' : '' }}">
                    <div class="container-fluid">
                        <div class="row {{$no_top ? 'no-top' : ''}}">
                            @php( $profile_image = wp_get_attachment_image( $panel[ 'image' ]['ID'], 'large' ) )
                            <div class="{{ $profile_image ? 'col-md-8' : 'col-sm-12'  }}">
                                @if($panel[ 'top_title' ])
                                    <h3 class="top-title">{{$panel[ 'top_title' ]}}</h3>
                                @endif
                                @if($panel[ 'top_subtitle' ])
                                    <h4 class="top-subtitle">{{$panel[ 'top_subtitle' ]}}</h4>
                                @endif
                                <div class="component-wysiwyg-content">
                                    {!! $panel[ 'wysiwyg' ] !!}
                                </div>
                                @if($panel[ 'bottom_title' ])
                                    <p class="bottom-title">
                                        {{$panel[ 'bottom_title' ]}}
                                        @if($panel[ 'bottom_subtitle' ])
                                            <span class="bottom-subtitle">{{$panel[ 'bottom_subtitle' ]}}</span>
                                        @endif
                                    </p>
                                @endif
                                @if($panel[ 'button' ])
                                    @foreach($panel[ 'button' ] as $button)
                                        @include(
                                            'partials.components.elements.button',
                                             \VC\PageBuilder\Core\extract_button_info_from_content( $button )
                                        )
                                    @endforeach
                                @endif
                            </div>
                            @if($profile_image)
                                <div class="col-md-4">
                                    <figure>
                                        {!! $profile_image !!}
                                    </figure>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="row-slider-thumbnails">
        <div class="row-slider-content">
            @foreach($content['panel'] as $panel)
                @php( $profile_image = wp_get_attachment_image( $panel[ 'image' ]['ID'], 'thumbnail' ) )
                <figure class="slider-thumbnail {{ $loop->iteration == 1 ? 'current' : '' }}">
                    {!! $profile_image !!}
                </figure>
            @endforeach
        </div>
    </div>
</div>