<?php
/**
 * @var string $temp_key
 */

use \VS\PageBuilder\Core;

return apply_filters( 'VS_PAGE_BUILDER_FILTER_SHORTCODE', [
    'key' => $temp_key . '_shortcode_group',
    'name' => 'shortcode',
    'label' => 'Shortcode',
    'display' => 'block',
    'sub_fields' => [
        [
            'key' => $temp_key . '_shortcode_title',
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
            'key' => $temp_key . '_shortcode_subtitle',
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
            'key' => $temp_key . '_shortcode_value',
            'label' => 'Shortcode',
            'name' => 'shortcode',
            'type' => 'text',
            'instructions' => 'Paste single shortcode only, for example [gravityform id=1]',
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