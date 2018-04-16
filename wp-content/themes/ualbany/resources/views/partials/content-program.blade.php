<article @php(post_class())>
  <div class="row">
  <div class="col-sm-2">
    Lorem ipsum
  </div>
  <div class="col-sm-7">
    <a href="{{ get_the_permalink() }}">
      <h2>{{ get_the_title() }}</h2>
    </a>
    Lorem ipsum
  </div>
  <div class="col-sm-3">
    Lorem ipsum
  </div>
  </div>
</article>