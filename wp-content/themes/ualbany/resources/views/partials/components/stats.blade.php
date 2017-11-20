<?php
/**
 * @var array $content
 */

$stats_columns = \VS\PageBuilder\Core\stats_column_sizes( count( $content[ 'stats' ] ) );
?>
<div class="component-stats-wrap component-wrap">
@if($content[ 'title' ])
    <h3>{{$content[ 'title' ]}}</h3>
@endif
@if($content[ 'subtitle' ])
    <h4>{{$content[ 'subtitle' ]}}</h4>
@endif
@if($content[ 'wysiwyg' ])
    <div class="wysiwyg-content wysiwyg-content-main">
        {!! $content[ 'wysiwyg' ] !!}
    </div>
@endif
@if($content[ 'stats' ])
    <div class="container-fluid">
        <div class="row">
            @foreach($content[ 'stats' ] as $stat)
                <div class="{{$stats_columns[ $loop->iteration - 1 ]}}">
                    <figure>
                        <span>{{$stat[ 'value' ]}}</span>
                        <figcaption>
                            {{$stat[ 'subtitle' ]}}
                        </figcaption>
                    </figure>
                    <div class="wysiwyg-content">
                        {!! $stat[ 'wysiwyg' ] !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
</div>