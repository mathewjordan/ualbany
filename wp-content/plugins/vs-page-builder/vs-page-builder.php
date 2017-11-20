<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since             0.0.1
 * @package           VS\PageBuilder
 *
 * @wordpress-plugin
 * Plugin Name:       Verified Content Page Builder
 * Plugin URI:        http://verifiedstudios.com
 * Description:       Plugin provides the responsive page building functionality based on Bootstrap 4.
 * Version:           1.0.2
 * Author:            Verified Studios
 * Author URI:        http://www.verifiedstudios.com/
 * Text Domain:       vs
 * Domain Path:       /lang
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

require ('vendor/autoload.php');

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.0.1
 */
function run_vc_page_builder()
{
    if( ! defined( 'VS_PAGE_BUILDER_PLUGIN_URL' ) ) define( 'VS_PAGE_BUILDER_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
    if( ! defined( 'VS_PAGE_BUILDER_PLUGIN_PATH' ) ) define( 'VS_PAGE_BUILDER_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

    $plugin = new VS\PageBuilder\Bootstrap();
    $plugin->run();
}

run_vc_page_builder();
