@if (isset($query))
  @if ($query->have_posts())
  <div class="table-responsive">
    <div class="container">
      <table id="table-programs" class="table table-bordered table-striped table-programs">
        <thead>
          <tr>
            <th scope="col" class="table-programs__programs-head">Program Name</th>
            <th scope="col">City</th>
            <th scope="col">Country</th>
            <th scope="col">Region</th>
            <th scope="col">Program Term</th>
            <th scope="col">Language of Instruction</th>
            <th scope="col">Faculty Led</th>
            <th scope="col">Internship</th>
            <th scope="col">Research</th>
          </tr>
        </thead>
        <tbody>
        @while($query->have_posts()) @php($query->the_post())
          @php
          $program_meta  = td_program_meta();
          @endphp
  
          <tr>
            <td>
              <a href="{{ get_the_permalink() }}">{{ get_the_title() }}</a>
            </td>
            <td>{{ $program_meta['city'] }}</td>
            <td>{{ $program_meta['country'] }}</td>
            <td>{{ $program_meta['region'] }}</td>
            <td>@php(program_meta_value($program_meta['terms'], 'comma-list'))</td>
            <td>@php(program_meta_value($program_meta['lang_of_instruct'], 'comma-list'))</td>
            <td>Lorem ipsum</td>
            <td>@php(program_meta_value($program_meta['internship'], 'break-list'))</td>
            <td>Lorem ipsum</td>
          </tr>
        @endwhile
        @php(wp_reset_postdata())
        </tbody>
      </table>
    </div>
  </div>

  <p class="text-center">
    <a href="#" target="_blank" class="btn btn-purple">
      <span class="fa fa-user"></span>
      Talk with an Advisor
    </a>
  </p>

  @endif
@endif