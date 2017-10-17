<div class="facetwp-template archive--content-list">
    @while (have_posts()) @php(the_post())
        <a href="{{get_the_permalink()}}">
            <h3>
                @if(get_field('program_td_format'))
                    <span class="fa fa-check-square"></span>
                @else
                    <span class="fa fa-square-o"></span>
                @endif
                {{the_title()}}
            </h3>
        </a>
        @endwhile
</div>