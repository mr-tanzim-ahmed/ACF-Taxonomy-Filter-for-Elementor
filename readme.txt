=== ACF Taxonomy Filter for Elementor ===
Contributors: mr-tanzim-ahmed
Donate link: https://github.com/mr-tanzim-ahmed/acf-taxonomy-filter-elementor
Tags: elementor, taxonomy, filter, acf, loop-grid, elementor-addon, post-filter, category-filter
Requires at least: 6.0
Tested up to: 6.6
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A high-performance, lightweight Elementor widget to filter posts, products, and custom post types instantly using a smooth, tab-like interface without page reloads.

== Description ==

ACF Taxonomy Filter for Elementor is a lightweight, responsive, and highly optimized WordPress plugin designed to solve the issues commonly associated with AJAX-based query filtering. Rather than forcing expensive database queries on every click, this plugin loads your posts and filters them instantly on the frontend using optimized CSS toggling.

It integrates seamlessly with the Elementor Pro Loop Builder, allowing you to select your Loop Templates directly within the widget settings and style every visual state (normal, hover, and active) from the Elementor style panel.

= Features =
* **Instant Client-Side Filtering:** Filters posts instantly without AJAX database lag or page refreshes.
* **Native Elementor Loop Templates:** Render Elementor Loop Items directly.
* **ACF & Custom Taxonomy Support:** Full compatibility with Advanced Custom Fields (ACF) dynamic tags.
* **100% Layout Style Controls:** Adjust padding, borders, backgrounds, typography, and responsive columns.
* **Responsive Column Gaps:** Layouts scale smoothly on mobile, tablet, and desktop views.
* **Accessiblity Minded:** Features ARIA roles, labels, and keyboard-focus navigation.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/acf-taxonomy-filter-elementor` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Use the Elementor Editor to search for and drag the "ACF Taxonomy Filter" widget onto your layout.

== Frequently Asked Questions ==

= Does it support WooCommerce products? =
Yes. Select the post type `product` and any WooCommerce taxonomy (e.g. `product_cat`) in the query settings.

= Do I need Elementor Pro? =
While standard taxonomy rendering works with Elementor Free, rendering loop templates natively requires the Loop Builder feature in Elementor Pro.

= Does this plugin affect page loading speeds? =
No. The plugin assets are minimal, and client-side filtering avoids additional AJAX database queries, keeping your page load times optimized.

== Changelog ==

= 1.0.0 =
* Initial release.
* Implemented native Elementor Pro Loop Template rendering.
* Rebuilt responsive grid column structures.
* Complete Style controls package integrated.
