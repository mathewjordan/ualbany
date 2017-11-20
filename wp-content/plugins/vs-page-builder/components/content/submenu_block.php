<?php
/**
 * @var string $temp_key
 */

$nav_menus      = \VS\PageBuilder\Modules\ACF\SubmenuNav::get_nav_menus();
$select_options = [
    '' => 'Select Menu'
];

foreach( $nav_menus as $nav_menu_id => $nav_menu_name ){
    $select_options[ $nav_menu_id ] = $nav_menu_name;
}

return apply_filters( 'VS_PAGE_BUILDER_FILTER_SUBMENU_BLOCK', [
    'key' => $temp_key . 'submenu_block_group',
    'name' => 'submenu_block',
    'label' => 'Submenu Block',
    'display' => 'block',
    'sub_fields' => [
        [
            'key' => $temp_key . 'submenu_title',
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
            'key' => $temp_key . 'submenu_menu',
            'label' => 'Menu',
            'name' => 'menu',
            'type' => 'select',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'choices' => $select_options,
            'default_value' => [],
            'allow_null' => 0,
            'multiple' => 0,
            'ui' => 0,
            'ajax' => 0,
            'return_format' => 'value',
            'placeholder' => '',
        ],
        [
            'key' => $temp_key . 'submenu_menu_item',
            'label' => 'Menu Item',
            'name' => 'menu_item',
            'type' => 'select',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'choices' => [],
            'default_value' => [],
            'allow_null' => 0,
            'multiple' => 0,
            'ui' => 0,
            'ajax' => 0,
            'return_format' => 'value',
            'placeholder' => '',
        ]
    ],
    'min' => '',
    'max' => '',
] );