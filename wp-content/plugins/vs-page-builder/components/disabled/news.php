<?php
/**
 * @var string $temp_key
 */

return apply_filters( 'VS_PAGE_BUILDER_FILTER_NEWS', [
    'key' => $temp_key . 'news_block',
    'name' => 'news_block',
    'label' => 'News Block',
    'display' => 'block',
    'sub_fields' => [
        [
            'key' => $temp_key . 'news_title',
            'label' => 'News Title',
            'name' => 'news_title',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'default_value' => 'Upcoming News',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
        ],
        [
            'key' =>  $temp_key . 'news_category',
            'label' => 'News Category',
            'name' => 'news_category',
            'type' => 'taxonomy',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'taxonomy' => 'news_category',
            'field_type' => 'radio',
            'allow_null' => 0,
            'add_term' => 0,
            'save_terms' => 0,
            'load_terms' => 0,
            'return_format' => 'id',
            'multiple' => 0,
        ],
        [
            'key' =>  $temp_key . 'news_count',
            'label' => 'Number of News to Display',
            'name' => 'news_count',
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
        4 => \VS\PageBuilder\Core\load_element( 'button', [
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