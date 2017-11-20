<?php
/**
 * @var string $temp_key
 */

$select_options = [
    '' => 'Select Menu'
];

if( class_exists( 'GFAPI' ) ) {

    $forms = GFAPI::get_forms();;

    foreach( $forms as $form ){
        $select_options[ $form[ 'id' ] ] = $form[ 'title' ];
    }
}

return apply_filters( 'VS_PAGE_BUILDER_FILTER_GRAVITY_FORMS', [
    'key' => $temp_key . 'gravity_forms_group',
    'name' => 'gravity_forms',
    'label' => 'Gravity Form',
    'display' => 'block',
    'sub_fields' => [
        [
            'key' => $temp_key . 'gravity_forms_form',
            'label' => 'Form',
            'name' => 'form',
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
        'key' => $temp_key . 'gravity_forms_options',
        'label' => 'Options',
        'name' => 'options',
        'type' => 'repeater',
        'instructions' => 'Key Value pairs passed into the Gravity Forms shortcode. <br />For example to hide the form title, key is set to title and the value is set to false. <br />See options: https://www.gravityhelp.com/documentation/article/shortcodes/',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => [
            'width' => '',
            'class' => '',
            'id' => '',
        ],
        'collapsed' => '',
        'min' => 1,
        'max' => 100,
        'layout' => 'block',
        'button_label' => 'Add Shortcode Options',
        'sub_fields' => [
            [
                'key' => $temp_key . 'gf_options_key',
                'label' => 'Key',
                'name' => 'key',
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
                'key' => $temp_key . 'gf_options_value',
                'label' => 'Value',
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
        ],
    ],
    ],
    'min' => '',
    'max' => '',
] );