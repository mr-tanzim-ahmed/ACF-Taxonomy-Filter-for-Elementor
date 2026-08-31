<?php
/**
 * Uninstall handler for ACF Taxonomy Filter for Elementor.
 *
 * Cleans up plugin data when the plugin is uninstalled via the WordPress dashboard.
 *
 * @package ACF_TFE
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// This plugin stores no custom options or database tables.
// If future versions add options, clean them up here.
// Example: delete_option( 'acf_tfe_settings' );
