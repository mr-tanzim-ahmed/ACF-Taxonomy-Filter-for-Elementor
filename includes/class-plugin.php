<?php
namespace ACF_TFE;

if ( ! defined( 'ABSPATH' ) ) exit;

class ACF_TFE_Plugin {
    private static $instance = null;

    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        try {
            // class_exists() is load-order independent: all active plugin files are
            // included before plugins_loaded fires, so this works regardless of
            // whether Elementor's own plugins_loaded callback has run yet.
            if ( ! did_action( 'elementor/loaded' ) && ! class_exists( '\Elementor\Plugin' ) ) {
                add_action( 'admin_notices', [ $this, 'admin_notice_missing_elementor' ] );
                return;
            }
            $this->load_dependencies();
            $this->init_hooks();
        } catch ( \Throwable $e ) {
            if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
                error_log( 'ACF TFE Init Error: ' . $e->getMessage() );
            }
        }
    }

    private function load_dependencies() {
        require_once ACF_TFE_PATH . 'includes/helpers.php';
        require_once ACF_TFE_PATH . 'includes/class-loader.php';
    }

    private function init_hooks() {
        new ACF_TFE_Loader();

        add_action( 'elementor/elements/categories_registered', [ $this, 'register_widget_categories' ] );
        add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
        add_filter( 'post_class', [ $this, 'add_taxonomy_classes_to_post' ], 10, 3 );
    }

    public function add_taxonomy_classes_to_post( $classes, $class, $post_id ) {
        try {
            $post = get_post( $post_id );
            if ( ! $post ) return $classes;

            $taxonomies = get_object_taxonomies( $post->post_type, 'objects' );
            foreach ( $taxonomies as $tax ) {
                if ( ! $tax->public ) continue;
                $terms = get_the_terms( $post_id, $tax->name );
                if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                    foreach ( $terms as $term ) {
                        $classes[] = 'acf-tfe-' . sanitize_html_class( $tax->name . '-' . $term->slug );
                    }
                }
            }
        } catch ( \Throwable $e ) {
            // Silently fail - never break post rendering
        }
        return $classes;
    }

    public function register_widget_categories( $elements_manager ) {
        try {
            $elements_manager->add_category(
                'acf-taxonomy-filter',
                [
                    'title' => esc_html__( 'ACF Taxonomy Filter', 'acf-taxonomy-filter-elementor' ),
                    'icon'  => 'fa fa-filter',
                ]
            );
        } catch ( \Throwable $e ) {
            // Silently fail
        }
    }

    public function register_widgets( $widgets_manager ) {
        try {
            $widget_file = ACF_TFE_PATH . 'widgets/class-taxonomy-filter-widget.php';
            if ( file_exists( $widget_file ) ) {
                require_once $widget_file;
                if ( class_exists( '\ACF_TFE\Widgets\Taxonomy_Filter_Widget' ) ) {
                    $widgets_manager->register( new \ACF_TFE\Widgets\Taxonomy_Filter_Widget() );
                }
            }
        } catch ( \Throwable $e ) {
            if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
                error_log( 'ACF TFE Widget Registration Error: ' . $e->getMessage() );
            }
        }
    }

    public function admin_notice_missing_elementor() {
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'acf-taxonomy-filter-elementor' ),
            '<strong>' . esc_html__( 'ACF Taxonomy Filter for Elementor', 'acf-taxonomy-filter-elementor' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'acf-taxonomy-filter-elementor' ) . '</strong>'
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }
}
