<?php


namespace VS\PageBuilder;

use VS\PageBuilder\Core;

class Bootstrap
{
    const LAYOUT_TYPE_CONTENT  = 'content';

    const LAYOUT_TYPE_LAYOUT   = 'layout';

    const LAYOUT_TYPE_ELEMENT  = 'element';

    /**
     * Run after plugins are loaded to confirm ACF is installed and activated
     */
    public function run()
    {
        add_action( 'plugins_loaded', [ __CLASS__, 'load_acf_fields' ] );
        add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_scripts' ] );

        //Load admin specific scripts and actions
        Admin::run();

        //Custom Classes for certain content types
        Modules\ACF\SubmenuNav::run();
    }

    /**
     * Check for ACF then load the dynamic rows or display admin error.
     */
    public static function load_acf_fields()
    {
        if( ! class_exists('acf') || ! function_exists('acf_add_local_field_group') ) {

            /**
             * Display Admin Error
             */
            add_action( 'admin_notices', function () {
                $class = 'notice notice-error';
                $message = __( 'Advanced Custom Fields is Required to run the VS Page Builder! Please Activate ACF or disable VS Page Builder.', 'vc-page-builder' );

                printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
            } );

        }else{

            /**
             * Load after setup theme to allow for theme filtering of layout options
             */
            add_action( 'after_setup_theme', function () {

                if( $data = Core\load_layout( 'rows' ) ) {

                    acf_add_local_field_group( $data );
                }
            } );
        }
    }

    public static function enqueue_scripts()
    {
        wp_enqueue_script(
            'vc-page-builder-bundle',
            VS_PAGE_BUILDER_PLUGIN_URL . '/dist/vs-page-builder-bundle.js',
            [ 'jquery' ],
            '0.0.1',
            true
        );

        wp_enqueue_script(
            'vc-page-builder-content',
            VS_PAGE_BUILDER_PLUGIN_URL . '/dist/vs-page-builder-content.js',
            [ 'vc-page-builder-bundle' ],
            '0.0.1',
            true
        );
    }

}