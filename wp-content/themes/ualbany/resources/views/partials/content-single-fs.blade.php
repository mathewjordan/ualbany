<div class="container">
  <article @php(post_class())>
    <header>
      <h1 class="entry-title">{{ get_the_title() }}</h1>
    </header>
    <div class="entry-content">
      @php(the_content())
    </div>
    <!--
    <footer>
    </footer>
    -->
  </article>
</div>