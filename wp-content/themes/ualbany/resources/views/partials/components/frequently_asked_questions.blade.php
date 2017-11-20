<?php
/**
 * @var array $content
 */
$items  = [];
$key    = rand(1,100);

switch( $content[ 'question_source' ] )
{
    case 'free-form':
        $items = $content[ 'free_form' ];
        break;
    case 'relationship':

        $meta_query = [];

        foreach( $content[ 'relationship' ] as $post_id )
            $meta_query[] = [
                'key' => 'department_relationship',
                'value' => sprintf(':"%s";', $post_id),
                'compare' => 'LIKE',
            ];

        $query = new \WP_Query([
            'post_type'     => \UNCGBryan\Essentials\Models\FAQ::CPT_NAMESPACE,
            'meta_query'    => array_merge([
                'relationship' => 'OR',
            ], $meta_query),
        ]);

        if( ! empty( $query->posts ) )
            foreach( $query->posts as $post ) {

                $fields = get_fields( $post->ID );

                $items[] = [
                    'question'  => $fields[ 'question' ],
                    'answer'    => $fields[ 'answer' ]
                ];
            }
        break;

}

?>
<div class="component-faq-wrap component-wrap">
    @if( ! empty( $items ) )
    <div class="faq-items">
        <div id="accordion{{ $key }}" role="tablist">
            @foreach( $items as $item )
            <div class="card">
                <div class="card-header" role="tab" id="heading{{ $loop->iteration }}">
                    <h5 class="mb-0">
                        <a data-toggle="collapse"
                           href="#collapse{{ $loop->iteration }}{{ $key }}"
                           aria-expanded="true"
                           aria-controls="collapse{{ $loop->iteration }}{{ $key }}">
                            {{ $item[ 'question' ] }}
                        </a>
                    </h5>
                </div>

                <div id="collapse{{ $loop->iteration }}{{ $key }}"
                     class="collapse {{ $loop->first ? 'show' : ''  }}"
                     role="tabpanel"
                     aria-labelledby="heading{{ $loop->iteration }}"
                     data-parent="#accordion{{ $key }}">
                    <div class="card-body">
                        {!! $item[ 'answer' ] !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
