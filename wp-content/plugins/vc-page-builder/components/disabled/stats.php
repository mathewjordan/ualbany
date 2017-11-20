<?php
/**
 * @var string $temp_key
 *
 * Pull in wysiwyg fields, keep it dry.
 */

$wysiwyg = \VC\PageBuilder\Core\load_content( 'wysiwyg', [
    'temp_key' => $temp_key . '_stat_'
] );

return apply_filters( 'VC_PAGE_BUILDER_FILTER_STATS', [
    'key' => $temp_key . '_stats_group',
    'name' => 'stats',
    'label' => 'Stats',
    'display' => 'block',
    'sub_fields' => array_merge( $wysiwyg['sub_fields'], [
        [
            'key' => $temp_key . '_stats',
            'label' => 'Stats',
            'name' => 'stats',
            'type' => 'repeater',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'collapsed' => '',
            'min' => 1,
            'max' => 4,
            'layout' => 'block',
            'button_label' => 'Add Stat',
            'sub_fields' => [
                [
                    'key' => $temp_key . '_stats_value',
                    'label' => 'value',
                    'name' => 'value',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ],
                [
                    'key' => $temp_key . '_stats_subtitle',
                    'label' => 'subtitle',
                    'name' => 'subtitle',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ],
                [
                    'key' => $temp_key . '_stats_wysiwyg',
                    'label' => 'wysiwyg',
                    'name' => 'wysiwyg',
                    'type' => 'wysiwyg',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'default_value' => '',
                    'tabs' => 'all',
                    'toolbar' => 'full',
                    'media_upload' => 1,
                    'delay' => 0,
                ],
            ],
        ],
    ] ),
    'min' => '',
    'max' => '',
] );