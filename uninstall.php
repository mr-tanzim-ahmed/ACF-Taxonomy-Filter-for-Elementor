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

function acf_tfe_delete_plugin_data() {
    delete_option( 'acf_tfe_version' );
    delete_option( 'acf_tfe_activated_at' );
    delete_option( 'acf_tfe_deactivated_at' );
    delete_transient( 'acf_tfe_activation_notice' );
}

if ( is_multisite() ) {
    $acf_tfe_blog_ids = get_sites( [ 'fields' => 'ids' ] );
    foreach ( $acf_tfe_blog_ids as $acf_tfe_blog_id ) {
        switch_to_blog( $acf_tfe_blog_id );
        acf_tfe_delete_plugin_data();
        restore_current_blog();
    }
} else {
    acf_tfe_delete_plugin_data();
}
