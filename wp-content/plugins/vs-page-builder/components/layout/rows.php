<?php

use VS\PageBuilder\Core;

return apply_filters( 'VS_PAGE_BUILDER_FILTER_ROWS', [
    'key' => 'group_596e4350841bb', //@todo in the next project rename key :)
    'title' => 'Page Builder',
    'fields' => [
        [
            'key' => 'field_596e43585b4fb',
            'label' => 'Columns',
            'name' => 'columns',
            'type' => 'flexible_content',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'layouts' => Core\load_layout( 'columns' ),
            'button_label' => 'Add Row',
            'min' => '',
            'max' => '',
        ],
    ],
    'location' => [
        [
            [
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'page',
            ],
            [
                "param" => "page_type",
                "operator" => "!=",
                "value" => "front_page"
            ],
        ],
    ],
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => [
        0 => 'the_content',
        1 => 'custom_fields',
        2 => 'discussion',
        3 => 'comments',
        4 => 'revisions',
        5 => 'author',
        6 => 'format',
        8 => 'featured_image',
        9 => 'categories',
        10 => 'tags',
    ],
    'active' => 1,
    'description' => '',
]);