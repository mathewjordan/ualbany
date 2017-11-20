<?php
/**
 * @var string $temp_key
 */

$relationship_values = [];
$relationships = get_posts([
    'post_type'         => 'faq',
    'posts_per_page'    => -1
]);

/** @var \WP_Post $relationship */
foreach( $relationships as $relationship )
    $relationship_values[ $relationship->ID ] = $relationship->post_title;

return apply_filters( 'VC_PAGE_BUILDER_FILTER_FAQ', [
    'key' => $temp_key . 'faq_group',
    'name' => 'frequently_asked_questions',
    'label' => 'Frequently Asked Questions',
    'display' => 'row',
    'sub_fields' => [
        [
            'key' => $temp_key . 'faq_question_source',
            'label' => 'Question Source',
            'name' => 'question_source',
            'type' => 'radio',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'choices' => [
                'relationship' => 'Relationship',
                'free-form' => 'Free Form',
            ],
            'allow_null' => 0,
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => '',
            'layout' => 'vertical',
            'return_format' => 'value',
        ],
        [
            'key' => $temp_key . 'faq_relationship',
            'label' => 'Relationship',
            'name' => 'relationship',
            'type' => 'checkbox',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => [
                [
                    [
                        'field' => $temp_key . 'faq_question_source',
                        'operator' => '==',
                        'value' => 'relationship',
                    ],
                ],
            ],
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'choices' => $relationship_values,
            'allow_custom' => 0,
            'save_custom' => 0,
            'default_value' => [],
            'layout' => 'vertical',
            'toggle' => 0,
            'return_format' => 'value',
        ],
        [
            'key' => $temp_key . 'faq_free_form',
            'label' => 'Free Form',
            'name' => 'free_form',
            'type' => 'repeater',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => [
                [
                    [
                        'field' => $temp_key . 'faq_question_source',
                        'operator' => '==',
                        'value' => 'free-form',
                    ],
                ],
            ],
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'collapsed' => '',
            'min' => 0,
            'max' => 0,
            'layout' => 'table',
            'button_label' => 'Add FAQ',
            'sub_fields' => [
                [
                    'key' => $temp_key . 'faq_ff_question',
                    'label' => 'Question',
                    'name' => 'question',
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
                    'key' => $temp_key . 'faq_ff_answer',
                    'label' => 'Answer',
                    'name' => 'answer',
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
            ],
        ],
    ],
    'min' => '',
    'max' => '',
] );