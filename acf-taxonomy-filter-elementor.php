<?php
/**
 * Plugin Name: ACF Taxonomy Filter for Elementor
 * Description: A powerful Elementor widget for filtering Loop Grid posts by taxonomy terms with smooth animations. Works with Elementor Pro Loop Grid.
 * Version: 1.0.8
 * Author: Tanzim
 * Author URI: https://github.com/mr-tanzim-ahmed
 * Plugin URI: https://github.com/mr-tanzim-ahmed/ACF-Taxonomy-Filter-for-Elementor
 * Text Domain: acf-taxonomy-filter-elementor
 * Domain Path: /languages
 * Requires PHP: 7.4
 * Requires at least: 6.0
 * Network: false
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Prevent double loading
if ( defined( 'ACF_TFE_VERSION' ) ) {
    return;
}

define( 'ACF_TFE_VERSION', '1.0.8' );
define( 'ACF_TFE_PATH', plugin_dir_path( __FILE__ ) );
define( 'ACF_TFE_URL', plugin_dir_url( __FILE__ ) );
define( 'ACF_TFE_BASENAME', plugin_basename( __FILE__ ) );

require_once ACF_TFE_PATH . 'includes/class-plugin.php';

if ( ! function_exists( 'acf_tfe_activate' ) ) {
    function acf_tfe_activate() {
        update_option( 'acf_tfe_version', ACF_TFE_VERSION, false );
        update_option( 'acf_tfe_activated_at', time(), false );
        delete_option( 'acf_tfe_deactivated_at' );

        delete_transient( 'acf_tfe_activation_notice' );
        if ( ! class_exists( '\Elementor\Plugin' ) ) {
            set_transient(
                'acf_tfe_activation_notice',
                'elementor_missing',
                30 * DAY_IN_SECONDS
            );
        }
    }
}

if ( ! function_exists( 'acf_tfe_deactivate' ) ) {
    function acf_tfe_deactivate() {
        update_option( 'acf_tfe_deactivated_at', time(), false );
        delete_transient( 'acf_tfe_activation_notice' );
    }
}

register_activation_hook( __FILE__, 'acf_tfe_activate' );
register_deactivation_hook( __FILE__, 'acf_tfe_deactivate' );

if ( ! function_exists( 'acf_tfe_init' ) ) {
    function acf_tfe_init() {
        try {
            if ( get_option( 'acf_tfe_version' ) !== ACF_TFE_VERSION ) {
                update_option( 'acf_tfe_version', ACF_TFE_VERSION, false );
            }
            \ACF_TFE\ACF_TFE_Plugin::get_instance();
        } catch ( \Throwable $e ) {
            if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
                error_log( 'ACF Taxonomy Filter Error: ' . $e->getMessage() );
            }
        }
    }
    add_action( 'plugins_loaded', 'acf_tfe_init' );
}

add_action( 'init', function () {
    load_plugin_textdomain(
        'acf-taxonomy-filter-elementor',
        false,
        dirname( ACF_TFE_BASENAME ) . '/languages'
    );
} );
