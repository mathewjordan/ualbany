<?php
/**
 * @var string $temp_key
 */

return apply_filters( 'VC_PAGE_BUILDER_FILTER_EVENT', [
    'key' => $temp_key . 'event_block',
    'name' => 'event_block',
    'label' => 'Event Block',
    'display' => 'block',
    'sub_fields' => [
        [
            'key' => $temp_key . 'event_title',
            'label' => 'Events Title',
            'name' => 'events_title',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'default_value' => 'Upcoming Events',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
        ],
        [
            'key' =>  $temp_key . 'event_category',
            'label' => 'Event Category',
            'name' => 'event_category',
            'type' => 'taxonomy',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'taxonomy' => 'event_category',
            'field_type' => 'radio',
            'allow_null' => 0,
            'add_term' => 0,
            'save_terms' => 0,
            'load_terms' => 0,
            'return_format' => 'id',
            'multiple' => 0,
        ],
        [
            'key' =>  $temp_key . 'event_count',
            'label' => 'Number of Events to Display',
            'name' => 'event_count',
            'type' => 'number',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'default_value' => '2',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
            'max' => 10,
            'min' => 1
        ],
        4 => \VC\PageBuilder\Core\load_element( 'button', [
            'temp_key' => $temp_key,
            'exclude_fields' => [
                'link'
            ],
            'exclude_types' => [
                'external'
            ]
        ] )
    ],
    'min' => '',
    'max' => '',
]);