<?php
/**
 * Fired when the plugin is uninstalled.
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Delete plugin-specific transients
global $wpdb;

$transients = $wpdb->get_results( "
	SELECT option_name 
	FROM $wpdb->options 
	WHERE option_name LIKE '\_transient\_acf_tfe\_%' 
	OR option_name LIKE '\_transient\_timeout\_acf_tfe\_%'
" );

if ( ! empty( $transients ) ) {
	foreach ( $transients as $transient ) {
		delete_option( $transient->option_name );
	}
}
