@if (isset($query))
  @if ($query->have_posts())
  <div class="table-responsive">
    <table id="table-programs" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th scope="col">Program Name</th>
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
          <td>Region</td>
          <td>Program Term</td>
          <td>Language of Instruction</td>
          <td>Faculty Led</td>
          <td>Internship</td>
          <td>Research</td>
        </tr>
      @endwhile
      @php(wp_reset_postdata())
      </tbody>
    </table>
  </div>
  @endif
@endif