<?php
/**
 * @var string $temp_key
 */

use \VS\PageBuilder\Core;

return apply_filters( 'VS_PAGE_BUILDER_FILTER_WYSIWYG', [
    'key' => $temp_key . '_wysiwyg_group',
    'name' => 'wysiwyg',
    'label' => 'Wysiwyg',
    'display' => 'block',
    'sub_fields' => [
        [
            'key' => $temp_key . '_wysiwyg_title',
            'label' => 'Title',
            'name' => 'title',
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
            'key' => $temp_key . '_wysiwyg_subtitle',
            'label' => 'Subtitle',
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
            'key' => $temp_key . '_wysiwyg_wysiwyg',
            'label' => 'Wysiwyg',
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
        4 => Core\load_element( 'button', [ 'temp_key' => $temp_key . '_wysiwyg' ] )
    ],
    'min' => '',
    'max' => '',
]);