<?php
/**
 * ===============
 * BUTTON ELEMENT
 * ===============
 *
 * Used by a lot of other content types. Please review all logic checks before making changes.
 * Buttons have the ability to link ouy to external websites or link in to WordPress links.
 * Buttons can also be altered to only allow certain types of links.
 * Button have certain fields excluded by parent content types.
 *
 * @var string $temp_key REQUIRED!
 * @var array $exclude_fields
 * @var array $exclude_types
 * @var integer $max_buttons
 * @var integer $min_buttons
 */
if( empty( $temp_key ) )
    throw new Exception('Temp Key is a required variable when calling the button element. Please check your ACF content field.');

/**
 * Excluded fields to block certain content types from having access to all button options
 */
$exclude_fields = ! empty( $exclude_fields ) ? $exclude_fields : [];

/**
 * Two types of buttons.
 * e - External links to non WordPress urls
 * i - Internal links to WordPress urls
 */
$button_types = [
    'e' => 'external',
    'i' => 'internal'
];

/**
 * Build two sub field groups.
 * One for internal links,
 * the other for external links.
 */
$sub_field_groups = [];

foreach( $button_types as $id_key => $type )
{
    $sub_field_groups[ $type ] = [
        [
            'key' => $temp_key . "_$id_key" . '_button_text',
            'label' => 'Text',
            'name' => 'text',
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
            'key' => $temp_key . "_$id_key" . '_button_style',
            'label' => 'Button Style',
            'name' => 'button_style',
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
                'default' => 'Default',
                'primary' => 'Primary',
                'secondary' => 'Secondary',
                'inverse' => 'Inverse',
            ],
            'default_value' => [
                0 => 'secondary',
            ],
            'allow_null' => 0,
            'multiple' => 0,
            'ui' => 0,
            'ajax' => 0,
            'return_format' => 'value',
            'placeholder' => '',
        ],
        [
            'key' => $temp_key . "_$id_key" . '_button_size',
            'label' => 'Button Size',
            'name' => 'button_size',
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
                'xs' => 'Extra Small',
                'sm' => 'Small',
                'md' => 'Medium',
                'lg' => 'Large',
                'xl' => 'Extra Large',
            ],
            'default_value' => [
                0 => 'sm',
            ],
            'allow_null' => 0,
            'multiple' => 0,
            'ui' => 0,
            'ajax' => 0,
            'return_format' => 'value',
            'placeholder' => '',
        ],
        [
            'key' => $temp_key . "_$id_key" . '_button_classes',
            'label' => 'Custom Classes',
            'name' => 'custom_classes',
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
    ];

    /**
     * Remove the link option for certain type of parent content types.
     * For example taxonomy links are auto generated based on the term.
     *
     * The `type` of link is either a valid external url or a selected internal WordPress page link.
     */
    if( ! in_array( 'link', $exclude_fields ) ) {
        array_unshift( $sub_field_groups[ $type ], [
            'key' => $temp_key . "_$id_key" . '_button_link',
            'label' => 'Link',
            'name' => 'link',
            'type' => $type == 'internal' ? 'page_link' : 'url',
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
        ] );
    }
}

/**
 * Remove either internal or external links for certain types of parent content
 */
$exclude_types = ! empty( $exclude_types ) ? $exclude_types : [];
$layouts = [];

/**
 * External links allowed
 */
if( empty( $exclude_types ) || ! in_array( 'external', $exclude_types ) ) {
    $layouts[ $temp_key . '596f6693' ] = [
        'key' => $temp_key . '_e_button_group',
        'name' => 'external_link',
        'label' => 'External Link',
        'display' => 'block',
        'sub_fields' => $sub_field_groups[ 'external' ],
        'min' => '',
        'max' => '',
    ];
}

/**
 * Internal links allow
 */
if( empty( $exclude_types ) || ! in_array( 'internal', $exclude_types ) ) {
    $layouts[ $temp_key . '5fd26793' ] = [
        'key' => $temp_key . '_i_button_group',
        'name' => 'internal_link',
        'label' => 'Internal Link',
        'display' => 'block',
        'sub_fields' => $sub_field_groups[ 'internal' ],
        'min' => '',
        'max' => '',
    ];
}


/**
 * Button Element is used with multiple content types.
 */
return apply_filters( 'VS_PAGE_BUILDER_FILTER_BUTTON_' . $temp_key, [
    'key' => $temp_key . '_wysiwyg_button_group',
    'label' => 'Button',
    'name' => 'button',
    'type' => 'flexible_content',
    'instructions' => '',
    'required' => 0,
    'conditional_logic' => 0,
    'wrapper' => [
        'width' => '',
        'class' => '',
        'id' => '',
    ],
    'layouts' => $layouts,
    'button_label' => 'Add Button',
    'min' => ! empty( $min_buttons ) ? (int) $min_buttons : 0,
    'max' => ! empty( $max_buttons ) ? (int) $max_buttons : 2,
] );