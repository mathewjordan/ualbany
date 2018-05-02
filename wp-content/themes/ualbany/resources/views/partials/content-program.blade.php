<article @php(post_class())>
  <div class="container">
    <div class="row">
      <div class="col-sm-2">
      @php
      $is_incoming = get_field('program_type') && get_field('program_type') == '2' ? true : false;
      $introduction = $is_incoming ? get_field('incoming_program_introduction', 'option') : get_field('program_introduction');
      $gallery = $is_incoming ? get_field('incoming_program_photos', 'option') : get_field('program_photos');
  
      $program_meta = td_program_meta();
      $program_dates = td_program_dates();
  
      @endphp
  
      @if ($gallery)
        @php($thumb = $gallery[0])
        <a href="{{ get_the_permalink() }}">
          <div class="program__thumbnail" style="background-image: url( {{ $thumb['sizes']['medium'] }});"></div>
        </a>
      @endif
      </div>
      <div class="col-sm-7">
        <a href="{{ get_the_permalink() }}">
          <h3>{{ get_the_title() }}</h3>
        </a>
        <a href="{{ get_the_permalink() }}" class="program__description">
          {!! $introduction !!}
        </a>
      </div>
      <div class="col-sm-3">
        <div class="program-meta">
          <h4 class="program-meta__label"><span class="fa fa-calendar"></span> {{ __('Program Terms') }}</h4>
          <div class="program-meta__value">
            @php(program_meta_value($program_meta['terms'], 'comma-list'))
          </div>
          <h4 class="program-meta__label"><span class="fa fa-comments-o"></span> {{ __('Language of Instruction') }}</h4>
          <div class="program-meta__value">
            @php(program_meta_value($program_meta['lang_of_instruct'], 'comma-list'))
          </div>
          <h4 class="program-meta__label"><span class="fa fa-home"></span> {{ __('Housing') }}</h4>
          <div class="program-meta__value">
            @php(program_meta_value($program_meta['housing'], 'comma-list'))
          </div>
          <h4 class="program-meta__label"><span class="fa fa-clock-o"></span> {{ __('App Deadline') }}</h4>
          <div class="program-meta__value">
            <a href="{{ get_the_permalink() }}">{{ $program_dates['deadline'] }}</a>
          </div>
          <a href="#" target="_blank" class="btn">
            <span class="fa fa-send"></span>
            Apply Now!
          </a>
        </div>
      </div>
    </div>
  </div>
</article>