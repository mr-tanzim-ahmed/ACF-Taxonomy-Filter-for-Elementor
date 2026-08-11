<?php
namespace ACF_TFE;

if ( ! defined( 'ABSPATH' ) ) exit;

class ACF_TFE_Loader {

    public function __construct() {
        add_action( 'elementor/frontend/after_register_scripts', [ $this, 'register_frontend_assets' ] );
        add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'editor_scripts' ] );
        add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'editor_styles' ] );
    }

    public function register_frontend_assets() {
        wp_register_script(
            'acf-tfe-frontend',
            ACF_TFE_URL . 'assets/js/widget-taxonomy-filter.js',
            [],
            ACF_TFE_VERSION,
            true
        );

        wp_register_style(
            'acf-tfe-frontend',
            ACF_TFE_URL . 'assets/css/widget-taxonomy-filter.css',
            [],
            ACF_TFE_VERSION
        );
    }

    public function editor_scripts() {
        wp_enqueue_script(
            'acf-tfe-admin-js',
            ACF_TFE_URL . 'assets/js/admin.js',
            [ 'jquery' ],
            ACF_TFE_VERSION,
            true
        );
    }

    public function editor_styles() {
        wp_enqueue_style(
            'acf-tfe-admin',
            ACF_TFE_URL . 'assets/css/admin.css',
            [],
            ACF_TFE_VERSION
        );
    }
}
