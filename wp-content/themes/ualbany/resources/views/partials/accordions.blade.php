
@if( have_rows('accordions') )

    <div id="accordion" class="accordions">

    @php
        while ( have_rows('accordions') ) : the_row();
    @endphp


        <div class="card">
            <div class="card-header" id="@php echo sanitize_html_class(get_sub_field('accordion_item_title')); @endphp">
                <h2 class="mb-0">
                    <button class="collapsed" data-toggle="collapse" data-target="#@php echo sanitize_html_class(get_sub_field('accordion_item_title')) . '_c'; @endphp" aria-expanded="true" aria-controls="@php echo sanitize_html_class(get_sub_field('accordion_item_title')) . '_c'; @endphp">
                        @php the_sub_field('accordion_item_title'); @endphp
                    </button>
                </h2>
            </div>

            <div id="@php echo sanitize_html_class(get_sub_field('accordion_item_title')) . '_c'; @endphp" class="collapse" aria-labelledby="@php echo sanitize_html_class(get_sub_field('accordion_item_title')); @endphp" data-parent="#accordion">
                <div class="card-body">
                    @php the_sub_field('accordion_item_content'); @endphp
                </div>
            </div>
        </div>

    @php
        endwhile;
    @endphp

    </div>

@else

@endif