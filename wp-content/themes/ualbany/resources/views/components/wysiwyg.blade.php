<?php
/**
 * @var array $content
 *
 * $content[ 'title' ];
 * $content[ 'subtitle' ];
 * $content[ 'wysiwyg' ];
 * $content[ 'button' ];
 */
?>
<div class="component-wysiwyg-wrap component-wrap">
    <h3>{{$content[ 'title' ]}}</h3>
    @if($content[ 'subtitle' ])
        <h4>{{$content[ 'subtitle' ]}}</h4>
    @endif
    @if($content[ 'wysiwyg' ])
        {!! $content[ 'wysiwyg' ] !!}
    @endif
    @if($content[ 'button' ])
        @foreach($content[ 'button' ] as $button)
            @include(
                'partials.components.elements.button',
                 \VC\PageBuilder\Core\extract_button_info_from_content( $button )
            )
        @endforeach
    @endif
</div>