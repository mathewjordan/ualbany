<?php

use VS\PageBuilder\Core;

$max_columns = 4;
$columns = [];

for($i = 1; $i <= $max_columns; $i++) {

    if( $column_names = Core\columns_names( $i ) ) {

        $temp_key = $column_names['key'];

        $columns[] = [
            'key' => $temp_key,
            'name' => $column_names['name'],
            'label' => $column_names['label'],
            'display' => 'block',
            'sub_fields' => [
                [
                    'key' => $temp_key . "_grid_size",
                    'label' => 'Grid Size',
                    'name' => 'grid_size',
                    'type' => 'select',
                    'instructions' => 'Display options for the grid sizes. For example equal spacing or left half is larger.',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'choices' => Core\column_grid_sizes( $i ),
                    'default_value' => Core\column_grid_default_size( $i ),
                    'allow_null' => 0,
                    'multiple' => 0,
                    'ui' => 0,
                    'ajax' => 0,
                    'return_format' => 'value',
                    'placeholder' => '',
                ],
                [
                    'key' => $temp_key . "_style",
                    'label' => 'Style',
                    'name' => 'style',
                    'type' => 'select',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'choices' => [
                        'light'     => 'White',
                        'light_2'   => 'Transparent',
                        'dark'      => 'Gray',
                        'dark_2'    => 'Dark Gray',
                        'yellow'    => 'Gold',
                        'blue'      => 'Purple',
                        'teal'      => 'Teal'
                    ],
                    'default_value' => [],
                    'allow_null' => 0,
                    'multiple' => 0,
                    'ui' => 0,
                    'ajax' => 0,
                    'return_format' => 'value',
                    'placeholder' => '',
                ],
                [
                    'key' => $temp_key . "_alignment",
                    'label' => 'Alignment',
                    'name' => 'alignment',
                    'type' => 'select',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'choices' => [
                        'left' => 'Left',
                        'center' => 'Center',
                        'right' => 'Right',
                    ],
                    'default_value' => ['left'],
                    'allow_null' => 0,
                    'multiple' => 0,
                    'ui' => 0,
                    'ajax' => 0,
                    'return_format' => 'value',
                    'placeholder' => '',
                ],
                [
                    'key' => $temp_key . '_background_image',
                    'label' => 'Background Image',
                    'name' => 'background_image',
                    'type' => 'image',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                    'library' => 'all',
                    'min_width' => '',
                    'min_height' => '',
                    'min_size' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'max_size' => '',
                    'mime_types' => '',
                ],
                [
                    'key' => $temp_key . '_header_wysiwyg',
                    'label' => 'Row Header',
                    'name' => 'header_wysiwyg',
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
                    'toolbar' => 'basic',
                    'media_upload' => 1,
                    'delay' => 0,
                ],
                [
                    'key' => $temp_key . '_content',
                    'label' => 'Content',
                    'name' => 'content',
                    'type' => 'flexible_content',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'layouts' => Core\load_layout( 'content', [ 'temp_key' => $temp_key ]),
                    'button_label' => 'Add Content',
                    'min' => 1,
                    'max' => $i,
                ],
                [
                    'key' => $temp_key . '_footer_wysiwyg',
                    'label' => 'Row Footer',
                    'name' => 'footer_wysiwyg',
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
                    'toolbar' => 'basic',
                    'media_upload' => 1,
                    'delay' => 0,
                ],
            ],
            'min' => '',
            'max' => '',
        ];

    }
}

return apply_filters( 'VS_PAGE_BUILDER_FILTER_COLUMNS', $columns );