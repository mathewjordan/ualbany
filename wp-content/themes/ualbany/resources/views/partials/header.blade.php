<header class="banner">
    <section class="banner_utility">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <nav class="nav-utility">
                        @if (has_nav_menu('utility_navigation'))
                            {!! wp_nav_menu(['theme_location' => 'utility_navigation', 'menu_class' => 'nav']) !!}
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="banner_primary">
        <div class="container">
            <div class="row">
                <div class="col-xs-9 col-sm-3">
                    <a class="brand" href="{{ home_url('/') }}">{{ get_bloginfo('name', 'display') }}</a>
                </div>
                <div class="col-xs-3 col-sm-9">
                    <nav class="nav-primary">
                        @if (has_nav_menu('primary_navigation'))
                            {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']) !!}
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </section>
</header>
