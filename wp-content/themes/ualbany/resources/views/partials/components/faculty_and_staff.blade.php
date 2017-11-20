<?php
/**
 * @var array $content
 *
 * @todo populate other fields if needed.
sf_employee_id
sf_username
sf_profile_prefix
sf_profile_first_name
sf_profile_middle_name
sf_profile_last_name
field_59b19525de7a3 - preferred name
sf_profile_official_title
sf_profile_secondary_title
sf_contact_phone_office
sf_contact_email
sf_contact_office_number
sf_contact_linkedin
sf_contact_website
sf_photo_type
sf_photo_image
sf_curriculum_vitae
sf_professional_background
 */

$df = $content[ 'display_fields' ];

$optional_fields = [
    'sf_profile_official_title',
    'sf_profile_secondary_title',
    'sf_contact_office_number',
    'sf_contact_email',
    'sf_contact_phone_office',
    'sf_contact_website',
    'sf_contact_linkedin',
    'sf_curriculum_vitae',
    'sf_professional_background',
];

if( ! empty( $content[ 'display_fields' ] ) && ! empty( $content[ 'faculty_and_staff' ] ) ): ?>
<div class="component-faculty-and-staff-wrap component-wrap">
    @if( $content[ 'title' ] )
        <h3>{{ $content[ 'title' ] }}</h3>
    @endif
    @if( $content[ 'subtitle' ] )
        <h4>{{ $content[ 'subtitle' ] }}</h4>
    @endif
    @if( $content[ 'faculty_and_staff' ] )
        @foreach( $content[ 'faculty_and_staff' ] as $wp_post )
            @php

            $fields = get_fields( $wp_post->ID );
            $name = \UNCGBryan\Essentials\Models\FacultyAndStaff::display_name( $fields );

            @endphp

            <div class="component-faculty-and-staff__instance">

                <div class="component-faculty-and-staff__instance__photo">
                    @if(isset($fields[ 'sf_photo_image' ]))
                        <a href="{{ get_the_permalink() }}">
                            <figure>
                                {!! wp_get_attachment_image( $fields[ 'sf_photo_image' ][ 'ID' ], 'sf_thumb') !!}
                            </figure>
                        </a>
                    @else
                        <figure>
                            <span class="no-photo"></span>
                        </figure>
                    @endif
                    <a href="{{ get_the_permalink() }}" class="btn btn-tiny btn-gray sr-only">View</a>
                </div>

                <div class="component-faculty-and-staff__instance__desc">

                    @if( $name )
                        <a href="{{ get_permalink( $wp_post ) }}">
                            <h4>{{$name}}</h4>
                        </a>
                    @endif

                    @foreach( $optional_fields as $optional_field )
                        @if( in_array( $optional_field, $df ) && isset( $fields[ $optional_field ] ) )
                            @if ($optional_field == 'sf_profile_official_title')
                                <h5 class="{{ str_replace( '_', '-', str_replace( 'sf_', '', $optional_field ) ) }}">
                                    {{ $fields[ $optional_field ] }}
                                </h5>
                            @elseif ($optional_field == 'sf_contact_office_number')
                                <span title="Office Number: {{ $fields[ $optional_field ] }}" class="{{ str_replace( '_', '-', str_replace( 'sf_', '', $optional_field ) ) }} sub-field-icon">
                                    <i class="icon-commerical-building"></i>{{ $fields[ $optional_field ] }}
                                </span>
                            @elseif ($optional_field == 'sf_contact_email')
                                <a title="Email Address: {{ $fields[ $optional_field ] }}" href="mailto:{{ $fields[ $optional_field ] }}" class="{{ str_replace( '_', '-', str_replace( 'sf_', '', $optional_field ) ) }} sub-field-icon">
                                    <i class="icon-mail-alt"></i>{{ $fields[ $optional_field ] }}
                                </a>
                            @elseif ($optional_field == 'sf_contact_phone_office')
                                <a title="Office Phone Number: {{ $fields[ $optional_field ] }}" href="tel:{{ $fields[ $optional_field ] }}" class="{{ str_replace( '_', '-', str_replace( 'sf_', '', $optional_field ) ) }} sub-field-icon">
                                    <i class="icon-phone"></i>{{ $fields[ $optional_field ] }}
                                </a>
                            @elseif ($optional_field == 'sf_contact_linkedin')
                                <a title="LinkedIn: {{ $fields[ $optional_field ] }}" href="{{ $fields[ $optional_field ] }}" target="_blank" class="{{ str_replace( '_', '-', str_replace( 'sf_', '', $optional_field ) ) }} sub-field-icon">
                                    <i class="icon-linkedin-circled"></i>LinkedIn
                                </a>
                            @else
                                <span title="{{ $fields[ $optional_field ] }}" class="{{ str_replace( '_', '-', str_replace( 'sf_', '', $optional_field ) ) }}">
                                    {{ $fields[ $optional_field ] }}
                                </span>
                            @endif
                        @endif
                    @endforeach

                </div>
            </div>
        @endforeach
    @endif
</div>
<?php endif;