<?php
namespace ACF_TFE\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit;

class Taxonomy_Filter_Widget extends Widget_Base {

    public function get_name() { return 'acf_taxonomy_filter'; }
    public function get_title() { return esc_html__( 'ACF Taxonomy Filter', 'acf-taxonomy-filter-elementor' ); }
    public function get_icon() { return 'eicon-filter'; }
    public function get_categories() { return [ 'acf-taxonomy-filter' ]; }
    public function get_keywords() { return [ 'filter', 'taxonomy', 'acf', 'category', 'tag', 'loop', 'tab' ]; }
    public function get_script_depends() { return [ 'acf-tfe-frontend' ]; }
    public function get_style_depends() { return [ 'acf-tfe-frontend' ]; }

    protected function register_controls() {
        // CONTENT TAB
        $this->register_content_loop_section();
        $this->register_content_filter_section();
        $this->register_content_query_section();
        $this->register_content_display_section();
        $this->register_content_labels_section();

        // STYLE TAB
        $this->register_style_container_section();
        $this->register_style_title_section();
        $this->register_style_button_section();
        $this->register_style_dropdown_section();
        $this->register_style_checkbox_radio_section();
        $this->register_style_count_section();
        $this->register_style_reset_section();
        $this->register_style_actions_section();
    }

    // ======================================================================
    // CONTENT TAB SECTIONS
    // ======================================================================

    protected function register_content_query_section() {
        $this->start_controls_section( 'section_query', [
            'label' => esc_html__( 'Query', 'acf-taxonomy-filter-elementor' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

        // Build post type options
        $post_types = get_post_types( [ 'public' => true ], 'objects' );
        $pt_options = [];
        foreach ( $post_types as $pt ) {
            $pt_options[ $pt->name ] = $pt->label;
        }

        $this->add_control( 'post_type', [
            'label'   => esc_html__( 'Post Type', 'acf-taxonomy-filter-elementor' ),
            'type'    => Controls_Manager::SELECT,
            'options' => $pt_options,
            'default' => 'post',
        ] );

        // Build taxonomy options - gather from ALL post types
        $all_taxonomies = [];
        foreach ( $pt_options as $pt_slug => $pt_label ) {
            $taxs = get_object_taxonomies( $pt_slug, 'objects' );
            foreach ( $taxs as $tax ) {
                if ( $tax->public ) {
                    $all_taxonomies[ $tax->name ] = $tax->label;
                }
            }
        }

        $this->add_control( 'taxonomy', [
            'label'   => esc_html__( 'Taxonomy', 'acf-taxonomy-filter-elementor' ),
            'type'    => Controls_Manager::SELECT,
            'options' => $all_taxonomies,
            'default' => 'category',
        ] );

        $this->add_control( 'hide_empty', [
            'label'        => esc_html__( 'Hide Empty Terms', 'acf-taxonomy-filter-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->add_control( 'term_order', [
            'label'   => esc_html__( 'Order By', 'acf-taxonomy-filter-elementor' ),
            'type'    => Controls_Manager::SELECT,
            'options' => [
                'default'    => esc_html__( 'Default', 'acf-taxonomy-filter-elementor' ),
                'name_asc'   => esc_html__( 'Name (A → Z)', 'acf-taxonomy-filter-elementor' ),
                'name_desc'  => esc_html__( 'Name (Z → A)', 'acf-taxonomy-filter-elementor' ),
                'count_desc' => esc_html__( 'Count (Most)', 'acf-taxonomy-filter-elementor' ),
                'count_asc'  => esc_html__( 'Count (Least)', 'acf-taxonomy-filter-elementor' ),
            ],
            'default' => 'default',
        ] );

        $this->end_controls_section();
    }

    protected function register_content_filter_section() {
        $this->start_controls_section( 'section_filter', [
            'label' => esc_html__( 'Filter Type', 'acf-taxonomy-filter-elementor' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'filter_type', [
            'label'   => esc_html__( 'Type', 'acf-taxonomy-filter-elementor' ),
            'type'    => Controls_Manager::SELECT,
            'options' => [
                'button'      => esc_html__( 'Buttons', 'acf-taxonomy-filter-elementor' ),
                'checkbox'    => esc_html__( 'Checkboxes', 'acf-taxonomy-filter-elementor' ),
                'radio'       => esc_html__( 'Radio Buttons', 'acf-taxonomy-filter-elementor' ),
                'dropdown'    => esc_html__( 'Dropdown', 'acf-taxonomy-filter-elementor' ),
                'multiselect' => esc_html__( 'Multi-Select', 'acf-taxonomy-filter-elementor' ),
            ],
            'default' => 'button',
        ] );

        $this->add_control( 'show_all_button', [
            'label'        => esc_html__( 'Show "All" Option', 'acf-taxonomy-filter-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->add_control( 'all_button_label', [
            'label'     => esc_html__( '"All" Label', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => esc_html__( 'All', 'acf-taxonomy-filter-elementor' ),
            'condition' => [ 'show_all_button' => 'yes' ],
        ] );

        $this->add_control( 'filter_icon', [
            'label'       => esc_html__( 'Filter Icon', 'acf-taxonomy-filter-elementor' ),
            'type'        => Controls_Manager::ICONS,
            'description' => esc_html__( 'Optional icon to display next to the term name.', 'acf-taxonomy-filter-elementor' ),
            'condition'   => [ 'filter_type' => [ 'button', 'checkbox', 'radio' ] ],
        ] );

        $this->add_control( 'filter_animation', [
            'label'   => esc_html__( 'Animation', 'acf-taxonomy-filter-elementor' ),
            'type'    => Controls_Manager::SELECT,
            'options' => [
                'none'       => esc_html__( 'None', 'acf-taxonomy-filter-elementor' ),
                'fade'       => esc_html__( 'Fade', 'acf-taxonomy-filter-elementor' ),
                'slide'      => esc_html__( 'Slide Up', 'acf-taxonomy-filter-elementor' ),
                'slide-down' => esc_html__( 'Slide Down', 'acf-taxonomy-filter-elementor' ),
                'zoom-in'    => esc_html__( 'Zoom In', 'acf-taxonomy-filter-elementor' ),
                'zoom-out'   => esc_html__( 'Zoom Out', 'acf-taxonomy-filter-elementor' ),
            ],
            'default' => 'fade',
        ] );

        $this->end_controls_section();
    }
    protected function register_content_loop_section() {
        $this->start_controls_section( 'section_loop', [
            'label' => esc_html__( 'Loop Action', 'acf-taxonomy-filter-elementor' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'css_mode_heading', [
            'label'     => esc_html__( 'How to use', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::RAW_HTML,
            'raw'       => '<ol style="margin:0;padding-left:18px;color:#555;font-size:12px;line-height:1.6;">'
                         . '<li>' . esc_html__( 'Add an Elementor Loop Grid widget to your page.', 'acf-taxonomy-filter-elementor' ) . '</li>'
                         . '<li>' . esc_html__( 'Go to the Loop Grid → Advanced → Layout → CSS ID.', 'acf-taxonomy-filter-elementor' ) . '</li>'
                         . '<li>' . esc_html__( 'Add a custom, unique CSS ID (e.g., "my-custom-grid").', 'acf-taxonomy-filter-elementor' ) . '</li>'
                         . '<li>' . esc_html__( 'Enter that same unique CSS ID below to link this filter.', 'acf-taxonomy-filter-elementor' ) . '</li>'
                         . '</ol>',
        ] );

        $this->add_control( 'target_id', [
            'label'       => esc_html__( 'Selected Loop Grid (CSS ID)', 'acf-taxonomy-filter-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => '',
            'placeholder' => 'my-custom-grid',
            'label_block' => true,
            'description' => esc_html__( 'The CSS ID you assigned to the target Loop Grid. Do not include the "#".', 'acf-taxonomy-filter-elementor' ),
        ] );

        $this->end_controls_section();
    }

    protected function register_content_display_section() {
        $this->start_controls_section( 'section_display', [
            'label' => esc_html__( 'Display', 'acf-taxonomy-filter-elementor' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'layout', [
            'label'   => esc_html__( 'Layout', 'acf-taxonomy-filter-elementor' ),
            'type'    => Controls_Manager::SELECT,
            'options' => [
                'horizontal' => esc_html__( 'Horizontal', 'acf-taxonomy-filter-elementor' ),
                'vertical'   => esc_html__( 'Vertical', 'acf-taxonomy-filter-elementor' ),
                'grid'       => esc_html__( 'Grid', 'acf-taxonomy-filter-elementor' ),
            ],
            'default' => 'horizontal',
        ] );

        $this->add_responsive_control( 'alignment', [
            'label'   => esc_html__( 'Alignment', 'acf-taxonomy-filter-elementor' ),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'left'    => [ 'title' => esc_html__( 'Left', 'acf-taxonomy-filter-elementor' ), 'icon' => 'eicon-text-align-left' ],
                'center'  => [ 'title' => esc_html__( 'Center', 'acf-taxonomy-filter-elementor' ), 'icon' => 'eicon-text-align-center' ],
                'right'   => [ 'title' => esc_html__( 'Right', 'acf-taxonomy-filter-elementor' ), 'icon' => 'eicon-text-align-right' ],
                'stretch' => [ 'title' => esc_html__( 'Stretch', 'acf-taxonomy-filter-elementor' ), 'icon' => 'eicon-text-align-justify' ],
            ],
            'default' => 'left',
        ] );

        $this->add_control( 'show_term_count', [
            'label'        => esc_html__( 'Show Term Count', 'acf-taxonomy-filter-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => '',
        ] );

        $this->add_control( 'show_hierarchy', [
            'label'        => esc_html__( 'Show Hierarchy', 'acf-taxonomy-filter-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => '',
        ] );

        $this->add_control( 'show_taxonomy_title', [
            'label'        => esc_html__( 'Show Title', 'acf-taxonomy-filter-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => '',
        ] );

        $this->add_control( 'taxonomy_title_text', [
            'label'     => esc_html__( 'Title Text', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => esc_html__( 'Filter by', 'acf-taxonomy-filter-elementor' ),
            'condition' => [ 'show_taxonomy_title' => 'yes' ],
        ] );

        $this->end_controls_section();
    }

    protected function register_content_labels_section() {
        $this->start_controls_section( 'section_labels', [
            'label' => esc_html__( 'Labels & Actions', 'acf-taxonomy-filter-elementor' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'show_result_count', [
            'label'        => esc_html__( 'Show Result Count', 'acf-taxonomy-filter-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => '',
        ] );

        $this->add_control( 'result_count_text', [
            'label'     => esc_html__( 'Count Text', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => '{count} results found',
            'condition' => [ 'show_result_count' => 'yes' ],
        ] );

        $this->add_control( 'show_reset_button', [
            'label'        => esc_html__( 'Show Reset Button', 'acf-taxonomy-filter-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => '',
        ] );

        $this->add_control( 'reset_button_label', [
            'label'     => esc_html__( 'Reset Label', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => esc_html__( 'Reset', 'acf-taxonomy-filter-elementor' ),
            'condition' => [ 'show_reset_button' => 'yes' ],
        ] );

        $this->end_controls_section();
    }

    // ======================================================================
    // STYLE TAB SECTIONS
    // ======================================================================

    protected function register_style_container_section() {
        $this->start_controls_section( 'section_style_container', [
            'label' => esc_html__( 'Container', 'acf-taxonomy-filter-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'     => 'container_background',
            'selector' => '{{WRAPPER}} .acf-tax-filter',
        ] );

        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'     => 'container_border',
            'selector' => '{{WRAPPER}} .acf-tax-filter',
        ] );

        $this->add_responsive_control( 'container_border_radius', [
            'label'      => esc_html__( 'Border Radius', 'acf-taxonomy-filter-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors'  => [
                '{{WRAPPER}} .acf-tax-filter' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'container_padding', [
            'label'      => esc_html__( 'Padding', 'acf-taxonomy-filter-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors'  => [
                '{{WRAPPER}} .acf-tax-filter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'container_margin', [
            'label'      => esc_html__( 'Margin', 'acf-taxonomy-filter-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors'  => [
                '{{WRAPPER}} .acf-tax-filter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'items_gap', [
            'label'     => esc_html__( 'Items Gap', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
            'selectors' => [
                '{{WRAPPER}} .acf-tax-filter__items' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'container_box_shadow',
            'selector' => '{{WRAPPER}} .acf-tax-filter',
        ] );

        $this->end_controls_section();
    }

    protected function register_style_title_section() {
        $this->start_controls_section( 'section_style_title', [
            'label'     => esc_html__( 'Title', 'acf-taxonomy-filter-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_taxonomy_title' => 'yes' ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'title_typography',
            'selector' => '{{WRAPPER}} .acf-tax-filter__title',
        ] );

        $this->add_control( 'title_color', [
            'label'     => esc_html__( 'Color', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .acf-tax-filter__title' => 'color: {{VALUE}};' ],
        ] );

        $this->add_responsive_control( 'title_spacing', [
            'label'     => esc_html__( 'Bottom Spacing', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
            'selectors' => [ '{{WRAPPER}} .acf-tax-filter__title' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_group_control( Group_Control_Text_Shadow::get_type(), [
            'name'     => 'title_text_shadow',
            'selector' => '{{WRAPPER}} .acf-tax-filter__title',
        ] );

        $this->end_controls_section();
    }

    /**
     * BUTTON style section - shows when filter_type = button.
     * Contains ALL possible CSS controls: typography, colors, background, border, radius, padding, margin, shadow, text-shadow for Normal/Hover/Active states.
     */
    protected function register_style_button_section() {
        $this->start_controls_section( 'section_style_button', [
            'label'     => esc_html__( 'Buttons', 'acf-taxonomy-filter-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [ 'filter_type' => 'button' ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'btn_typography',
            'selector' => '{{WRAPPER}} .acf-tax-filter__item',
        ] );

        $this->start_controls_tabs( 'tabs_btn_style' );

        // --- NORMAL TAB ---
        $this->start_controls_tab( 'tab_btn_normal', [
            'label' => esc_html__( 'Normal', 'acf-taxonomy-filter-elementor' ),
        ] );

        $this->add_control( 'btn_color', [
            'label'     => esc_html__( 'Text Color', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .acf-tax-filter__item' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'     => 'btn_background',
            'selector' => '{{WRAPPER}} .acf-tax-filter__item',
        ] );

        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'     => 'btn_border',
            'selector' => '{{WRAPPER}} .acf-tax-filter__item',
        ] );

        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'btn_box_shadow',
            'selector' => '{{WRAPPER}} .acf-tax-filter__item',
        ] );

        $this->add_group_control( Group_Control_Text_Shadow::get_type(), [
            'name'     => 'btn_text_shadow',
            'selector' => '{{WRAPPER}} .acf-tax-filter__item',
        ] );

        $this->end_controls_tab();

        // --- HOVER TAB ---
        $this->start_controls_tab( 'tab_btn_hover', [
            'label' => esc_html__( 'Hover', 'acf-taxonomy-filter-elementor' ),
        ] );

        $this->add_control( 'btn_hover_color', [
            'label'     => esc_html__( 'Text Color', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .acf-tax-filter__item:hover' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'     => 'btn_hover_background',
            'selector' => '{{WRAPPER}} .acf-tax-filter__item:hover',
        ] );

        $this->add_control( 'btn_hover_border_color', [
            'label'     => esc_html__( 'Border Color', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .acf-tax-filter__item:hover' => 'border-color: {{VALUE}};' ],
        ] );

        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'btn_hover_box_shadow',
            'selector' => '{{WRAPPER}} .acf-tax-filter__item:hover',
        ] );

        $this->add_control( 'btn_hover_transition', [
            'label'     => esc_html__( 'Transition Duration (ms)', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 0, 'max' => 2000, 'step' => 100 ] ],
            'selectors' => [
                '{{WRAPPER}} .acf-tax-filter__item' => 'transition-duration: {{SIZE}}ms;',
            ],
        ] );

        $this->end_controls_tab();

        // --- ACTIVE TAB ---
        $this->start_controls_tab( 'tab_btn_active', [
            'label' => esc_html__( 'Active', 'acf-taxonomy-filter-elementor' ),
        ] );

        $this->add_control( 'btn_active_color', [
            'label'     => esc_html__( 'Text Color', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .acf-tax-filter__item--active' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'     => 'btn_active_background',
            'selector' => '{{WRAPPER}} .acf-tax-filter__item--active',
        ] );

        $this->add_control( 'btn_active_border_color', [
            'label'     => esc_html__( 'Border Color', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .acf-tax-filter__item--active' => 'border-color: {{VALUE}};' ],
        ] );

        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'btn_active_box_shadow',
            'selector' => '{{WRAPPER}} .acf-tax-filter__item--active',
        ] );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        // After tabs - border radius & padding apply to all states
        $this->add_responsive_control( 'btn_border_radius', [
            'label'      => esc_html__( 'Border Radius', 'acf-taxonomy-filter-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'separator'  => 'before',
            'selectors'  => [
                '{{WRAPPER}} .acf-tax-filter__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'btn_padding', [
            'label'      => esc_html__( 'Padding', 'acf-taxonomy-filter-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors'  => [
                '{{WRAPPER}} .acf-tax-filter__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'btn_min_width', [
            'label'     => esc_html__( 'Min Width', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 0, 'max' => 500 ] ],
            'selectors' => [
                '{{WRAPPER}} .acf-tax-filter__item' => 'min-width: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();
    }

    protected function register_style_dropdown_section() {
        $this->start_controls_section( 'section_style_dropdown', [
            'label'     => esc_html__( 'Dropdown', 'acf-taxonomy-filter-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [ 'filter_type' => [ 'dropdown', 'multiselect' ] ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'dropdown_typography',
            'selector' => '{{WRAPPER}} .acf-tax-filter__select',
        ] );

        $this->add_control( 'dropdown_color', [
            'label'     => esc_html__( 'Text Color', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .acf-tax-filter__select' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'     => 'dropdown_background',
            'selector' => '{{WRAPPER}} .acf-tax-filter__select',
        ] );

        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'     => 'dropdown_border',
            'selector' => '{{WRAPPER}} .acf-tax-filter__select',
        ] );

        $this->add_responsive_control( 'dropdown_border_radius', [
            'label'      => esc_html__( 'Border Radius', 'acf-taxonomy-filter-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
                '{{WRAPPER}} .acf-tax-filter__select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'dropdown_padding', [
            'label'      => esc_html__( 'Padding', 'acf-taxonomy-filter-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em' ],
            'selectors'  => [
                '{{WRAPPER}} .acf-tax-filter__select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'dropdown_height', [
            'label'     => esc_html__( 'Height', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 30, 'max' => 400 ] ],
            'condition' => [ 'filter_type' => 'multiselect' ],
            'selectors' => [
                '{{WRAPPER}} .acf-tax-filter__select[multiple]' => 'min-height: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'dropdown_box_shadow',
            'selector' => '{{WRAPPER}} .acf-tax-filter__select',
        ] );

        $this->end_controls_section();
    }

    protected function register_style_checkbox_radio_section() {
        $this->start_controls_section( 'section_style_check', [
            'label'     => esc_html__( 'Checkbox / Radio', 'acf-taxonomy-filter-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [ 'filter_type' => [ 'checkbox', 'radio' ] ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'check_typography',
            'selector' => '{{WRAPPER}} .acf-tax-filter__item .acf-tax-filter__item-name',
        ] );

        $this->add_control( 'check_label_color', [
            'label'     => esc_html__( 'Label Color', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .acf-tax-filter__item .acf-tax-filter__item-name' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'check_label_hover_color', [
            'label'     => esc_html__( 'Label Hover Color', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .acf-tax-filter__item:hover .acf-tax-filter__item-name' => 'color: {{VALUE}};' ],
        ] );

        $this->add_responsive_control( 'check_size', [
            'label'     => esc_html__( 'Input Size', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 10, 'max' => 40 ] ],
            'selectors' => [
                '{{WRAPPER}} .acf-tax-filter__item input[type="checkbox"], {{WRAPPER}} .acf-tax-filter__item input[type="radio"]' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'check_gap', [
            'label'     => esc_html__( 'Label Gap', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
            'selectors' => [ '{{WRAPPER}} .acf-tax-filter__item' => 'gap: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_responsive_control( 'check_item_padding', [
            'label'      => esc_html__( 'Item Padding', 'acf-taxonomy-filter-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em' ],
            'selectors'  => [
                '{{WRAPPER}} .acf-tax-filter__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'     => 'check_background',
            'selector' => '{{WRAPPER}} .acf-tax-filter__item',
        ] );

        $this->add_control( 'check_hover_bg', [
            'label'     => esc_html__( 'Hover Background', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .acf-tax-filter__item:hover' => 'background-color: {{VALUE}};' ],
        ] );

        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'     => 'check_border',
            'selector' => '{{WRAPPER}} .acf-tax-filter__item',
        ] );

        $this->add_responsive_control( 'check_border_radius', [
            'label'      => esc_html__( 'Border Radius', 'acf-taxonomy-filter-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
                '{{WRAPPER}} .acf-tax-filter__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();
    }

    protected function register_style_count_section() {
        $this->start_controls_section( 'section_style_count', [
            'label'     => esc_html__( 'Term Count', 'acf-taxonomy-filter-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_term_count' => 'yes' ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'count_typography',
            'selector' => '{{WRAPPER}} .acf-tax-filter__item-count',
        ] );

        $this->add_control( 'count_color', [
            'label'     => esc_html__( 'Color', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .acf-tax-filter__item-count' => 'color: {{VALUE}};' ],
        ] );

        $this->end_controls_section();
    }

    protected function register_style_reset_section() {
        $this->start_controls_section( 'section_style_reset', [
            'label'     => esc_html__( 'Reset Button', 'acf-taxonomy-filter-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [ 'show_reset_button' => 'yes' ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'reset_typography',
            'selector' => '{{WRAPPER}} .acf-tax-filter__reset',
        ] );

        $this->start_controls_tabs( 'tabs_reset_style' );

        $this->start_controls_tab( 'tab_reset_normal', [
            'label' => esc_html__( 'Normal', 'acf-taxonomy-filter-elementor' ),
        ] );

        $this->add_control( 'reset_color', [
            'label'     => esc_html__( 'Color', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .acf-tax-filter__reset' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'     => 'reset_background',
            'selector' => '{{WRAPPER}} .acf-tax-filter__reset',
        ] );

        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'     => 'reset_border',
            'selector' => '{{WRAPPER}} .acf-tax-filter__reset',
        ] );

        $this->end_controls_tab();

        $this->start_controls_tab( 'tab_reset_hover', [
            'label' => esc_html__( 'Hover', 'acf-taxonomy-filter-elementor' ),
        ] );

        $this->add_control( 'reset_hover_color', [
            'label'     => esc_html__( 'Color', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .acf-tax-filter__reset:hover' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'     => 'reset_hover_background',
            'selector' => '{{WRAPPER}} .acf-tax-filter__reset:hover',
        ] );

        $this->add_control( 'reset_hover_border_color', [
            'label'     => esc_html__( 'Border Color', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .acf-tax-filter__reset:hover' => 'border-color: {{VALUE}};' ],
        ] );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control( 'reset_border_radius', [
            'label'      => esc_html__( 'Border Radius', 'acf-taxonomy-filter-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'separator'  => 'before',
            'selectors'  => [
                '{{WRAPPER}} .acf-tax-filter__reset' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'reset_padding', [
            'label'      => esc_html__( 'Padding', 'acf-taxonomy-filter-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em' ],
            'selectors'  => [
                '{{WRAPPER}} .acf-tax-filter__reset' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();
    }

    protected function register_style_actions_section() {
        $this->start_controls_section( 'section_style_actions', [
            'label' => esc_html__( 'Actions Bar', 'acf-taxonomy-filter-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'actions_spacing', [
            'label'     => esc_html__( 'Top Spacing', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'selectors' => [ '{{WRAPPER}} .acf-tax-filter__actions' => 'margin-top: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'result_count_typography',
            'label'    => esc_html__( 'Result Count Typography', 'acf-taxonomy-filter-elementor' ),
            'selector' => '{{WRAPPER}} .acf-tax-filter__result-count',
            'condition' => [ 'show_result_count' => 'yes' ],
        ] );

        $this->add_control( 'result_count_color', [
            'label'     => esc_html__( 'Result Count Color', 'acf-taxonomy-filter-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .acf-tax-filter__result-count' => 'color: {{VALUE}};' ],
            'condition' => [ 'show_result_count' => 'yes' ],
        ] );

        $this->end_controls_section();
    }

    // ======================================================================
    // RENDER
    // ======================================================================

    protected function render() {
        $settings = $this->get_settings_for_display();

        $taxonomy    = sanitize_text_field( $settings['taxonomy'] ?? 'category' );
        $post_type   = sanitize_text_field( $settings['post_type'] ?? 'post' );
        $filter_type = $settings['filter_type'] ?? 'button';
        $widget_id   = $this->get_id();
        $layout      = $settings['layout'] ?? 'horizontal';
        $alignment   = $settings['alignment'] ?? 'left';
        $animation   = $settings['filter_animation'] ?? 'fade';

        // Build get_terms args
        $args = [
            'taxonomy'   => $taxonomy,
            'hide_empty' => ( 'yes' === ( $settings['hide_empty'] ?? 'yes' ) ),
        ];

        $term_order = $settings['term_order'] ?? 'default';
        if ( 'default' !== $term_order ) {
            $parts = explode( '_', $term_order );
            if ( count( $parts ) === 2 ) {
                $args['orderby'] = $parts[0];
                $args['order']   = strtoupper( $parts[1] );
            }
        }

        $terms = get_terms( $args );
        if ( is_wp_error( $terms ) ) $terms = [];

        // Build wrapper classes
        $wrapper_classes = [
            'acf-tax-filter',
            'acf-tax-filter--' . esc_attr( $filter_type ),
            'acf-tax-filter--layout-' . esc_attr( $layout ),
            'acf-tax-filter--align-' . esc_attr( $alignment ),
        ];

        $show_all       = 'yes' === ( $settings['show_all_button'] ?? 'yes' );
        $all_label      = $settings['all_button_label'] ?? __( 'All', 'acf-taxonomy-filter-elementor' );
        $show_count     = 'yes' === ( $settings['show_term_count'] ?? 'no' );
        $show_hierarchy = 'yes' === ( $settings['show_hierarchy'] ?? 'no' );
        $target_id      = $settings['target_id'] ?? '';

        if ( \Elementor\Plugin::$instance->editor->is_edit_mode() && empty( $target_id ) ) {
            echo '<div class="elementor-alert elementor-alert-warning">' . esc_html__( 'Please enter a Target CSS ID in the Loop Action settings to link this filter to your Loop Grid.', 'acf-taxonomy-filter-elementor' ) . '</div>';
        }

        $icon_html = '';
        if ( ! empty( $settings['filter_icon']['value'] ) ) {
            ob_start();
            \Elementor\Icons_Manager::render_icon( $settings['filter_icon'], [ 'aria-hidden' => 'true' ] );
            $icon_html = ob_get_clean();
            if ( $icon_html ) {
                $icon_html = '<span class="acf-tax-filter__item-icon">' . $icon_html . '</span>';
            }
        }

        // Open main wrapper
        ?>
        <div class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>"
             data-acf-tfe-widget="<?php echo esc_attr( $widget_id ); ?>"
             data-taxonomy="<?php echo esc_attr( $taxonomy ); ?>"
             data-post-type="<?php echo esc_attr( $post_type ); ?>"
             data-filter-type="<?php echo esc_attr( $filter_type ); ?>"
             data-animation="<?php echo esc_attr( $animation ); ?>"
             data-target-id="<?php echo esc_attr( ltrim( $target_id, '#' ) ); ?>"
             role="tablist"
             aria-label="<?php esc_attr_e( 'Filter by taxonomy', 'acf-taxonomy-filter-elementor' ); ?>">

            <?php if ( 'yes' === ( $settings['show_taxonomy_title'] ?? 'no' ) && ! empty( $settings['taxonomy_title_text'] ) ) : ?>
                <h4 class="acf-tax-filter__title"><?php echo esc_html( $settings['taxonomy_title_text'] ); ?></h4>
            <?php endif; ?>

            <div class="acf-tax-filter__items">
                <?php if ( 'dropdown' === $filter_type || 'multiselect' === $filter_type ) :
                    $is_multi = 'multiselect' === $filter_type;
                ?>
                    <select class="acf-tax-filter__select" <?php echo $is_multi ? 'multiple' : ''; ?>>
                        <?php if ( $show_all && ! $is_multi ) : ?>
                            <option value="" selected><?php echo esc_html( $all_label ); ?></option>
                        <?php endif; ?>
                        <?php foreach ( $terms as $term ) :
                            $indent = ( $show_hierarchy && $term->parent > 0 ) ? '— ' : '';
                            $label  = $indent . $term->name;
                            if ( $show_count ) $label .= ' (' . $term->count . ')';
                        ?>
                            <option value="<?php echo esc_attr( $term->slug ); ?>" data-term-id="<?php echo esc_attr( $term->term_id ); ?>"><?php echo esc_html( $label ); ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php else :
                    // "All" button
                    if ( $show_all ) :
                        if ( 'button' === $filter_type ) : ?>
                            <button type="button"
                                    class="acf-tax-filter__item acf-tax-filter__item--all acf-tax-filter__item--active"
                                    data-term-slug=""
                                    role="tab"
                                    aria-selected="true"
                                    aria-pressed="true">
                                <span class="acf-tax-filter__item-name"><?php echo $icon_html . esc_html( $all_label ); ?></span>
                            </button>
                        <?php elseif ( 'radio' === $filter_type ) : ?>
                            <label class="acf-tax-filter__item acf-tax-filter__item--all">
                                <input type="radio"
                                       name="acf_tfe_<?php echo esc_attr( $widget_id ); ?>"
                                       value=""
                                       data-term-slug=""
                                       checked>
                                <span class="acf-tax-filter__item-name"><?php echo $icon_html . esc_html( $all_label ); ?></span>
                            </label>
                        <?php endif;
                    endif;

                    // Term items
                    foreach ( $terms as $term ) :
                        $child_class = ( $show_hierarchy && $term->parent > 0 ) ? ' acf-tax-filter__item--child' : '';
                        $count_html  = $show_count ? '<span class="acf-tax-filter__item-count">(' . esc_html( $term->count ) . ')</span>' : '';

                        switch ( $filter_type ) {
                            case 'button': ?>
                                <button type="button"
                                        class="acf-tax-filter__item<?php echo esc_attr( $child_class ); ?>"
                                        data-term-slug="<?php echo esc_attr( $term->slug ); ?>"
                                        data-term-id="<?php echo esc_attr( $term->term_id ); ?>"
                                        role="tab"
                                        aria-selected="false"
                                        aria-pressed="false">
                                    <span class="acf-tax-filter__item-name"><?php echo $icon_html . esc_html( $term->name ); ?></span>
                                    <?php echo $count_html; ?>
                                </button>
                                <?php break;
                            case 'checkbox': ?>
                                <label class="acf-tax-filter__item<?php echo esc_attr( $child_class ); ?>">
                                    <input type="checkbox"
                                           value="<?php echo esc_attr( $term->slug ); ?>"
                                           data-term-slug="<?php echo esc_attr( $term->slug ); ?>"
                                           data-term-id="<?php echo esc_attr( $term->term_id ); ?>">
                                    <span class="acf-tax-filter__item-name"><?php echo $icon_html . esc_html( $term->name ); ?></span>
                                    <?php echo $count_html; ?>
                                </label>
                                <?php break;
                            case 'radio': ?>
                                <label class="acf-tax-filter__item<?php echo esc_attr( $child_class ); ?>">
                                    <input type="radio"
                                           name="acf_tfe_<?php echo esc_attr( $widget_id ); ?>"
                                           value="<?php echo esc_attr( $term->slug ); ?>"
                                           data-term-slug="<?php echo esc_attr( $term->slug ); ?>"
                                           data-term-id="<?php echo esc_attr( $term->term_id ); ?>">
                                    <span class="acf-tax-filter__item-name"><?php echo $icon_html . esc_html( $term->name ); ?></span>
                                    <?php echo $count_html; ?>
                                </label>
                                <?php break;
                        }
                    endforeach;
                endif; ?>
            </div>

            <?php if ( 'yes' === ( $settings['show_result_count'] ?? 'no' ) || 'yes' === ( $settings['show_reset_button'] ?? 'no' ) ) : ?>
            <div class="acf-tax-filter__actions">
                <?php if ( 'yes' === ( $settings['show_result_count'] ?? 'no' ) ) : ?>
                    <span class="acf-tax-filter__result-count"
                          data-template="<?php echo esc_attr( $settings['result_count_text'] ?? '{count} results found' ); ?>"></span>
                <?php endif; ?>
                <?php if ( 'yes' === ( $settings['show_reset_button'] ?? 'no' ) ) : ?>
                    <button type="button" class="acf-tax-filter__reset" style="display:none;">
                        <?php echo esc_html( $settings['reset_button_label'] ?? __( 'Reset', 'acf-taxonomy-filter-elementor' ) ); ?>
                    </button>
                <?php endif; ?>
            </div>
            <?php endif; ?>

        </div> <!-- Close main wrapper -->
    <?php
    }

    protected function content_template() {
        ?>
        <#
        var filterType = settings.filter_type || 'button';
        var layout     = settings.layout || 'horizontal';
        var alignment  = settings.alignment || 'left';
        var wrapperCls = 'acf-tax-filter acf-tax-filter--' + filterType + ' acf-tax-filter--layout-' + layout + ' acf-tax-filter--align-' + alignment;
        var showAll    = settings.show_all_button === 'yes';
        var allLabel   = settings.all_button_label || 'All';
        var showTitle  = settings.show_taxonomy_title === 'yes';
        var titleText  = settings.taxonomy_title_text || '';
        
        var iconHTML = '';
        if ( settings.filter_icon && settings.filter_icon.value ) {
            var iconClass = settings.filter_icon.value;
            iconHTML = '<span class="acf-tax-filter__item-icon"><i class="' + iconClass + '" aria-hidden="true"></i></span>';
        }
        
        if ( ! settings.target_id ) {
            print( '<div class="elementor-alert elementor-alert-warning">Please enter a Target CSS ID in the Loop Action settings to link this filter to your Loop Grid.</div>' );
        }
        #>
        <div class="{{ wrapperCls }}"
             data-filter-type="{{ filterType }}"
             data-animation="{{ settings.filter_animation || 'fade' }}"
             role="tablist">

            <# if ( showTitle && titleText ) { #>
                <h4 class="acf-tax-filter__title">{{ titleText }}</h4>
            <# } #>

            <div class="acf-tax-filter__items">
                <# if ( filterType === 'dropdown' || filterType === 'multiselect' ) {
                    var isMulti = filterType === 'multiselect' ? 'multiple' : '';
                #>
                    <select class="acf-tax-filter__select" {{ isMulti }}>
                        <# if ( showAll && filterType !== 'multiselect' ) { #>
                            <option value="">{{ allLabel }}</option>
                        <# } #>
                        <option value="term-1">Term 1</option>
                        <option value="term-2">Term 2</option>
                        <option value="term-3">Term 3</option>
                    </select>
                <# } else {
                    if ( showAll ) {
                        if ( filterType === 'button' ) { #>
                            <button type="button" class="acf-tax-filter__item acf-tax-filter__item--all acf-tax-filter__item--active" role="tab" aria-selected="true" aria-pressed="true">
                                <span class="acf-tax-filter__item-name">{{{ iconHTML }}}{{ allLabel }}</span>
                            </button>
                        <# } else if ( filterType === 'radio' ) { #>
                            <label class="acf-tax-filter__item acf-tax-filter__item--all">
                                <input type="radio" checked>
                                <span class="acf-tax-filter__item-name">{{{ iconHTML }}}{{ allLabel }}</span>
                            </label>
                        <# }
                    }
                    #>
                    <# if ( filterType === 'button' ) { #>
                        <button type="button" class="acf-tax-filter__item" role="tab" aria-selected="false" aria-pressed="false">
                            <span class="acf-tax-filter__item-name">{{{ iconHTML }}}Sample Term 1</span>
                        </button>
                        <button type="button" class="acf-tax-filter__item" role="tab" aria-selected="false" aria-pressed="false">
                            <span class="acf-tax-filter__item-name">{{{ iconHTML }}}Sample Term 2</span>
                        </button>
                    <# } else if ( filterType === 'checkbox' ) { #>
                        <label class="acf-tax-filter__item">
                            <input type="checkbox">
                            <span class="acf-tax-filter__item-name">{{{ iconHTML }}}Sample Term 1</span>
                        </label>
                        <label class="acf-tax-filter__item">
                            <input type="checkbox">
                            <span class="acf-tax-filter__item-name">{{{ iconHTML }}}Sample Term 2</span>
                        </label>
                    <# } else if ( filterType === 'radio' ) { #>
                        <label class="acf-tax-filter__item">
                            <input type="radio">
                            <span class="acf-tax-filter__item-name">{{{ iconHTML }}}Sample Term 1</span>
                        </label>
                        <label class="acf-tax-filter__item">
                            <input type="radio">
                            <span class="acf-tax-filter__item-name">{{{ iconHTML }}}Sample Term 2</span>
                        </label>
                    <# }
                } #>
            </div>      

            <# if ( settings.show_result_count === 'yes' || settings.show_reset_button === 'yes' ) { #>
            <div class="acf-tax-filter__actions">
                <# if ( settings.show_result_count === 'yes' ) { #>
                    <span class="acf-tax-filter__result-count">{{{ (settings.result_count_text || '{count} results').replace('{count}', '—') }}}</span>
                <# } #>
                <# if ( settings.show_reset_button === 'yes' ) { #>
                    <button type="button" class="acf-tax-filter__reset">{{{ settings.reset_button_label || 'Reset' }}}</button>
                <# } #>
            </div>
            <# } #>
        </div>
        <?php
    }
}
