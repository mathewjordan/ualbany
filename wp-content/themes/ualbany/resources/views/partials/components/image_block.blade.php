<?php
/**
 * @var array $content
 */

/**
 * @param $count
 * @return array|null
 */

$block_classes = App\block_size_class( count( $content[ 'blocks' ] ) );

?>
<div class="component-image-blocks-wrap component-wrap">
    <div class="image-blocks container-fluid">
        <div class="row">
            <div class="col-sm-12">
                @if($content['title'])
                    <h3>{{$content[ 'title' ]}}</h3>
                @endif
            </div>
        </div>
        <div class="row">
            @foreach($content[ 'blocks' ] as $i => $block)
                @php($block_class = $block_classes[ $loop->iteration - 1 ])
                <div class="{{$block_class}}">
                @if($block['link'])
                    <a href="{{$block['link']}}">
                @endif
                    <div class="image-block">
                        @if($block[ 'image' ])
                            <figure>
                                @php($image = wp_get_attachment_image( $block[ 'image' ][ 'ID'], 'medium' ))
                                {!! $image !!}
                            </figure>
                        @endif
                        @if($block[ 'title' ])
                            @php
                                //Make the first word bold
                                $words = explode( " ", $block[ 'title' ] );
                                $first = $words[0];
                                unset( $words[0] );

                                $title = implode( " ", $words );
                            @endphp
                            <h4>
                                <strong>{{$first}}</strong> {{$title}}
                            </h4>
                        @endif
                        @if($block[ 'wysiwyg' ])
                            {!! $block[ 'wysiwyg' ] !!}
                        @endif
                    </div>
                @if($block['link'])
                    </a>
                @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
