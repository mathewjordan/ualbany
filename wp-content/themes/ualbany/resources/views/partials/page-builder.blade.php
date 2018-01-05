<?php

use VS\PageBuilder\Core;

global $post;

$fields = get_fields( $post->ID );

if( ! empty( $fields ) && ! empty( $fields[ 'columns' ] ) ){
    foreach( $fields[ 'columns' ] as $row ) {

        $classes        = Core\column_class( $row[ 'acf_fc_layout' ], $row[ 'grid_size' ] );
        $row_class      = Core\row_class( $row[ 'style' ] );
        $row_extra_class= Core\row_forced_classes_based_on_content($row['content']);
        $row_image      = wp_get_attachment_image( $row[ 'background_image' ][ 'ID' ], 'large', false, [ 'class' => 'row-background-image' ] );
        $row_alignment  = Core\row_alignment( $row[ 'alignment' ] );

        ?>
        <div class='{{$row_class}} {{$row_alignment}} {{$row_image ? 'row-image' : 'row-no-image'}} {{$row_extra_class}}'>
            @if($row_image)
                <figure class="row-background">{!! $row_image !!}</figure>
            @endif
            <div class='container'>

                @if ($row[ 'header_wysiwyg' ])
                    <div class="row">
                        <div class="col-12">@php echo $row[ 'header_wysiwyg' ]; @endphp</div>
                    </div>
                @endif

                <div class='row'>

                    @if( ! empty( $row['content'] ) )

                        @foreach( $row['content'] as $key => $content )

                            @php($partial = 'partials.components.' . $content[ 'acf_fc_layout' ])

                            <div class="{{$classes[ $key ]}}" data-partial="{{$partial}}">
                                @includeIf( $partial, [ 'content'   => $content ] )
                            </div>

                        @endforeach

                    @endif
                </div>

                @if ($row[ 'footer_wysiwyg' ])
                    <div class="row">
                        <div class="col-12">@php echo $row[ 'footer_wysiwyg' ]; @endphp</div>
                    </div>
                @endif

            </div>
        </div>
<?php }
}
