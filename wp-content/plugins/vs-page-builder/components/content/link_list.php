<?php
/**
 * @var string $temp_key
 */

return apply_filters( 'VS_PAGE_BUILDER_FILTER_LINK_LIST', [
    'key' => $temp_key . 'link_list_group',
    'name' => 'link_list',
    'label' => 'Link List',
    'display' => 'block',
    'sub_fields' => [
        [
            'key' => $temp_key . 'link_list_title',
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
            'key' => $temp_key . 'link_list_links',
            'label' => 'Links',
            'name' => 'links',
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
            'max' => 20,
            'layout' => 'block',
            'button_label' => 'Add List Item',
            'sub_fields' => [
                [
                    'key' => $temp_key . 'link_list_is_link',
                    'label' => 'Is link',
                    'name' => 'is_link',
                    'type' => 'true_false',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'message' => '',
                    'default_value' => 1,
                    'ui' => 1,
                    'ui_on_text' => '',
                    'ui_off_text' => '',
                ],
                [
                    'key' => $temp_key . 'link_list_link_type',
                    'label' => 'Link Type',
                    'name' => 'link_type',
                    'type' => 'select',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => [
                        [
                            [
                                'field' => $temp_key . 'link_list_is_link',
                                'operator' => '==',
                                'value' => '1',
                            ],
                        ],
                    ],
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'choices' => [
                        'internal' => 'Internal',
                        'external' => 'External',
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
                    'key' => $temp_key . 'link_list_value',
                    'label' => 'Text',
                    'name' => 'text',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => [
//                        [
//                            [
//                                'field' => $temp_key . 'link_list_is_link',
//                                'operator' => '!=',
//                                'value' => '1',
//                            ],
//                        ],
//                        [
//                            [
//                                'field' => $temp_key . 'link_list_link_type',
//                                'operator' => '==',
//                                'value' => 'external',
//                            ],
//                        ],
                    ],
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
                    'key' => $temp_key . 'link_list_internal_link',
                    'label' => 'Internal Link',
                    'name' => 'internal_link',
                    'type' => 'link',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => [
                        [
                            [
                                'field' => $temp_key . 'link_list_link_type',
                                'operator' => '==',
                                'value' => 'internal',
                            ],
                            [
                                'field' => $temp_key . 'link_list_is_link',
                                'operator' => '==',
                                'value' => '1',
                            ],
                        ],
                    ],
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'return_format' => 'array',
                ],
                [
                    'key' => $temp_key . 'link_list_external_link',
                    'label' => 'External Link',
                    'name' => 'external_link',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => [
                        [
                            [
                                'field' => $temp_key . 'link_list_link_type',
                                'operator' => '==',
                                'value' => 'external',
                            ],
                            [
                                'field' => $temp_key . 'link_list_is_link',
                                'operator' => '==',
                                'value' => '1',
                            ],
                        ],
                    ],
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
            ],
        ],
    ],
    'min' => '',
    'max' => '',
]);