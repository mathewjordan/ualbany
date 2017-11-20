<?php
/**
 * @var string $temp_key
 */

//Dirty pull from the theme, but it works.
$file_path      = get_template_directory() . '/assets/acf-json/staff_and_faculty_main.json';
$display_fields = [];
$default_fields = [ 'post_title' ];
$ignored_fields = [
    'sf_username',
    'sf_employee_id',
    'sf_profile_prefix',
    'sf_profile_first_name',
    'sf_profile_middle_name',
    'sf_profile_last_name',
    'sf_profile_preferred_name',
    'field_59b19525de7a3',
];

if( file_exists( $file_path ) ) {

    $faculty_field_data = file_get_contents( $file_path );

    try {
        $faculty_field_data = json_decode( $faculty_field_data );

        if( ! empty( $faculty_field_data->fields ) && is_array( $faculty_field_data->fields ) ) {

            foreach( $faculty_field_data->fields as $field ) {

                if( ! empty( $field->label ) && ! in_array( $field->key, $ignored_fields ) ) {

                    $display_fields[ $field->key ] = $field->label;
                }
            }

            $default_fields = [
                'sf_photo_image',
            ];
        }

    }catch( Exception $err ) {
        error_log( "Problem decoding file to json $file_path" );
    }
}

return apply_filters( 'VC_PAGE_BUILDER_FILTER_FACULTY_AND_STAFF', [
    'key' => $temp_key . 'faculty_and_staff_group',
    'name' => 'faculty_and_staff',
    'label' => 'Faculty and Staff',
    'display' => 'row',
    'sub_fields' => [
        [
            'key' => $temp_key . 'fs_title',
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
            'key' => $temp_key . 'fs_subtitle',
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
            'key' => $temp_key . 'fs_relationship',
            'label' => 'Faculty and Staff',
            'name' => 'faculty_and_staff',
            'type' => 'relationship',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'post_type' => [
                0 => 'faculty_and_staff',
            ],
            'taxonomy' => [],
            'filters' => [
                0 => 'search',
                1 => 'post_type',
                2 => 'taxonomy',
            ],
            'elements' => [
                0 => 'featured_image',
            ],
            'min' => 1,
            'max' => '',
            'return_format' => 'object',
        ],
        [
            'key' => $temp_key . 'fs_display_fields',
            'label' => 'Display Fields',
            'name' => 'display_fields',
            'type' => 'checkbox',
            'instructions' => '',
            'required' => 0,
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'choices' => $display_fields,
            'default_value' => $default_fields,
            'allow_null' => 0,
            'multiple' => 0,
            'ui' => 0,
            'ajax' => 0,
            'return_format' => 'value',
            'placeholder' => '',
        ],
    ],
    'min' => '',
    'max' => '',
] );