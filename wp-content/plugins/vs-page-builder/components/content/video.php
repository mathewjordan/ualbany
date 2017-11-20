<?php
/**
 * @var string $temp_key
 */

return apply_filters( 'VS_PAGE_BUILDER_FILTER_VIDEO', [
    'key' => $temp_key . 'video_group',
    'name' => 'video',
    'label' => 'Video',
    'display' => 'block',
    'sub_fields' => [
        [
            'key' => $temp_key . '_video_embed',
            'label' => 'Video Embed',
            'name' => 'video_embed',
            'type' => 'oembed',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'width' => '',
            'height' => '',
        ],
    ],
    'min' => '',
    'max' => '',
]);