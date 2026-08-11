<?php
/**
 * Helper functions for ACF Taxonomy Filter.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if ACF is active.
 *
 * @return bool
 */
function acf_tfe_is_acf_active() {
	return class_exists( 'ACF' );
}

/**
 * Get registered public post types.
 *
 * @return array Array of post type names => labels.
 */
function acf_tfe_get_post_types() {
	$args = [
		'public' => true,
	];
	$post_types = get_post_types( $args, 'objects' );
	
	$options = [];
	foreach ( $post_types as $post_type ) {
		$options[ $post_type->name ] = $post_type->label;
	}
	
	/**
	 * Filter available post types.
	 *
	 * @param array $options
	 */
	return apply_filters( 'acf_tfe_post_types', $options );
}

/**
 * Get taxonomies for a specific post type.
 *
 * @param string $post_type Post type name.
 * @return array Array of taxonomy names => labels.
 */
function acf_tfe_get_taxonomies( $post_type ) {
	if ( empty( $post_type ) ) {
		return [];
	}

	$taxonomies = get_object_taxonomies( $post_type, 'objects' );
	
	$options = [];
	foreach ( $taxonomies as $taxonomy ) {
		if ( $taxonomy->public ) {
			$options[ $taxonomy->name ] = $taxonomy->label;
		}
	}

	/**
	 * Filter available taxonomies.
	 *
	 * @param array  $options
	 * @param string $post_type
	 */
	return apply_filters( 'acf_tfe_taxonomies', $options, $post_type );
}

/**
 * Get terms for a taxonomy.
 *
 * @param string $taxonomy Taxonomy name.
 * @param array  $args     WP_Term_Query arguments.
 * @return array|WP_Error Array of WP_Term objects or empty array.
 */
function acf_tfe_get_terms( $taxonomy, $args = [] ) {
	if ( empty( $taxonomy ) || ! taxonomy_exists( $taxonomy ) ) {
		return [];
	}

	$default_args = [
		'taxonomy'   => $taxonomy,
		'hide_empty' => true,
	];

	$parsed_args = wp_parse_args( $args, $default_args );
	
	$terms = get_terms( $parsed_args );
	
	if ( is_wp_error( $terms ) ) {
		return [];
	}

	/**
	 * Filter retrieved terms.
	 *
	 * @param array  $terms
	 * @param string $taxonomy
	 * @param array  $parsed_args
	 */
	return apply_filters( 'acf_tfe_terms', $terms, $taxonomy, $parsed_args );
}

/**
 * Sanitize a taxonomy name, returning empty string if it doesn't exist.
 *
 * @param string $taxonomy
 * @return string
 */
function acf_tfe_sanitize_taxonomy( $taxonomy ) {
	$taxonomy = sanitize_text_field( $taxonomy );
	return taxonomy_exists( $taxonomy ) ? $taxonomy : '';
}

/**
 * Sanitize a post type name, returning empty string if it doesn't exist.
 *
 * @param string $post_type
 * @return string
 */
function acf_tfe_sanitize_post_type( $post_type ) {
	$post_type = sanitize_text_field( $post_type );
	return post_type_exists( $post_type ) ? $post_type : '';
}
