<?php
/**
 * Plugin Name: ACF Taxonomy Filter for Elementor
 * Description: A powerful Elementor widget for filtering Loop Grid posts by taxonomy terms with smooth animations. Works with Elementor Pro Loop Grid.
 * Version: 1.0.4
 * Author: Tanzim
 * Author URI: https://developer.developer.developer
 * Text Domain: acf-taxonomy-filter-elementor
 * Domain Path: /languages
 * Requires PHP: 7.4
 * Requires at least: 6.0
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

define( 'ACF_TFE_VERSION', '1.0.4' );
define( 'ACF_TFE_PATH', plugin_dir_path( __FILE__ ) );
define( 'ACF_TFE_URL', plugin_dir_url( __FILE__ ) );
define( 'ACF_TFE_BASENAME', plugin_basename( __FILE__ ) );

require_once ACF_TFE_PATH . 'includes/class-plugin.php';

if ( ! function_exists( 'acf_tfe_init' ) ) {
    function acf_tfe_init() {
        try {
            \ACF_TFE\ACF_TFE_Plugin::get_instance();
        } catch ( \Throwable $e ) {
            if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
                error_log( 'ACF Taxonomy Filter Error: ' . $e->getMessage() );
            }
        }
    }
    add_action( 'plugins_loaded', 'acf_tfe_init' );
}
