<?php


namespace VC\PageBuilder;


class Admin
{
    public static function run()
    {
        add_action( 'admin_enqueue_scripts', [ __CLASS__, 'enqueue_scripts' ] );
    }

    public static function enqueue_scripts()
    {
        wp_enqueue_script(
            'vc-page-builder-bundle',
            VC_PAGE_BUILDER_PLUGIN_URL . '/dist/vc-page-builder-bundle.js',
            [ 'jquery' ],
            '0.0.1',
            true
        );

        wp_enqueue_script(
            'vc-page-builder/modules/acf/submenu-blocks',
            VC_PAGE_BUILDER_PLUGIN_URL . '/src/Modules/ACF/dist/module-build-submenu-blocks.js',
            [ 'vc-page-builder-bundle' ],
            '0.0.1',
            true
        );
    }
}