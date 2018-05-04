<div class="nav-mobile-underlay"></div>
<div class="nav-mobile-wrapper">
    <button class="close-mobile-nav nav-mobile-close" tabindex="2" aria-label="Close"><em class="sr-only">Close</em>
        @include('partials.svg.icon-close')
    </button>
    <div class="nav-mobile-wrapper-scroll">
        <button class="nav-submenu-back" tabindex="3" aria-label="Back"><em class="sr-only">Back</em>
            @include('partials.svg.icon-arrow-left')
        </button>
        <div class="svg-wrap--seal clearfix">
            <a href="{{ get_home_url() }}" class="mobile-menu-link mobile-menu-link--level-one" tabindex="1">
                @include('partials.svg.ualbany-horizontal')
            </a>
        </div>
        <nav class="nav-school nav-mobile-school">

            @php
                function mobile_menu_class( $atts, $item, $args, $depth ) {

                    $atts[ 'class' ] = [ 'mobile-menu-link' ];

                    switch ( $depth )
                    {
                        case 0:
                            $atts[ 'class' ][] = 'mobile-menu-link--level-one';
                            break;
                        case 1:
                            $atts[ 'class' ][] = 'mobile-menu-link--level-two';
                            break;
                        case 2:
                            $atts[ 'class' ][] = 'mobile-menu-link--level-three';
                            break;
                    }



                    $atts[ 'class' ] = implode( ' ', $atts[ 'class' ] );

                    return $atts;
                }

                add_filter( 'nav_menu_link_attributes', 'mobile_menu_class', 10, 4 );
            @endphp

            @if (has_nav_menu('school_navigation'))
                {!! wp_nav_menu([
                    'theme_location'  => 'school_navigation',
                    'menu_class'      => 'nav',
                  ]) !!}
            @endif
        </nav>
        <nav class="nav-mobile-primary">
            @if (has_nav_menu('primary_navigation'))

                {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav', 'walker' => new Bootstrapwp_Walker_Nav_Menu()]) !!}

                @php( remove_filter( 'nav_menu_link_attributes', 'mobile_menu_class' ) )
            @endif

            @if (has_nav_menu('utility_navigation'))
                {!! wp_nav_menu(['theme_location' => 'utility_navigation', 'menu_class' => 'nav']) !!}
            @endif
        </nav>
    </div>
</div>
<header class="banner">
    <section class="banner_utility">
        <div class="container-fluid">
            <div class="row">
                <nav class="nav-utility">
                    @if (has_nav_menu('utility_navigation'))
                        {!! wp_nav_menu(['theme_location' => 'utility_navigation', 'menu_class' => 'nav']) !!}
                    @endif
                    <div class="nav-master-trigger">
                        <button aria-label="Menu"><em class="sr-only">Menu</em><span></span></button>
                    </div>
                </nav>
            </div>
        </div>
    </section>
    <section class="banner_primary">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-9 col-sm-3">
                    <a class="brand" href="{{ home_url('/') }}">
                        @include('partials.svg.ualbany-horizontal')
                    </a>
                </div>
                <div class="col-xs-3 col-sm-9">
                    <nav class="nav-primary">
                        @if (has_nav_menu('primary_navigation'))
                            {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav', 'walker' => new Bootstrapwp_Walker_Nav_Menu()]) !!}
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <a role="button" href="#" class="megamenu-toggle" id="megamenu-toggle"></a>
</header>
