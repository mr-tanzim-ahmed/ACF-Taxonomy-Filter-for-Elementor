=== ACF Taxonomy Filter for Elementor ===
Contributors: mr-tanzim-ahmed
Donate link: https://github.com/mr-tanzim-ahmed/ACF-Taxonomy-Filter-for-Elementor
Tags: elementor, taxonomy filter, acf, loop grid, post filter, category filter, elementor addon, woocommerce filter
Requires at least: 6.0
Tested up to: 6.6
Requires PHP: 7.4
Stable tag: 1.0.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Filter Elementor Pro Loop Grid items by category, tag, or custom taxonomy without a page reload or a new AJAX request for each filter change. Choose buttons, checkboxes, radio buttons, a dropdown, or multi-select. Works with WordPress posts, WooCommerce products, and custom post types.

== Description ==

**ACF Taxonomy Filter for Elementor** adds client-side taxonomy filtering to Elementor Pro Loop Grids. Visitors can filter the grid items loaded on the page without a reload or a new AJAX request for each filter change.

Connect the widget to a Loop Grid with a CSS ID, then choose a post type, taxonomy, and filter style. Filtering uses the taxonomy classes on the grid items and happens in the browser. The initial page still needs to load the Loop Grid content.

Use it for WordPress blogs, WooCommerce product grids, portfolios, directories, and other layouts built with the Elementor Pro Loop Builder.

= Key Features =

* **Client-Side Filtering** — Filter loaded Loop Grid items without a page reload or a new AJAX request for each filter change.
* **Native Elementor Pro Loop Grid Support** — Link the filter to any Loop Grid with a simple CSS ID.
* **5 Filter Types** — Buttons, Checkboxes, Radio Buttons, Dropdown, and Multi-Select.
* **ACF & Custom Taxonomy Support** — Works with categories, tags, WooCommerce taxonomies, and custom taxonomies registered by Advanced Custom Fields (ACF) or any other plugin.
* **Smooth Animations** — Choose from Fade, Slide Up, Slide Down, Zoom In, Zoom Out, or no animation.
* **Complete Style Controls** — Typography, colors, backgrounds, borders, shadows, spacing, and hover/active states for every element, directly in the Elementor style panel.
* **Responsive Layouts** — Horizontal, vertical, and grid layouts with per-device alignment and gap controls.
* **Term Counts, Reset Button & Result Counter** — Optional post counts per term, a reset filter button, and a live result count message.
* **Hierarchical Terms** — Optional indentation for child categories and terms.
* **Accessible Markup** — ARIA roles, labels, and keyboard-focus navigation built in.
* **Lightweight Front End** — Uses vanilla JavaScript for filtering, with no jQuery dependency.

= How It Works =

1. Add an **Elementor Pro Loop Grid** widget to your page.
2. In the Loop Grid settings, go to **Advanced → Layout → CSS ID** and set a unique ID (e.g. `my-custom-grid`).
3. Add the **ACF Taxonomy Filter** widget above your grid.
4. In the widget's **Loop Action** settings, enter the same CSS ID (without the `#`).
5. Choose your post type, taxonomy, filter type, and style — done!

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/acf-taxonomy-filter-elementor` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Edit any page with Elementor, search for the "ACF Taxonomy Filter" widget, and drag it onto your layout.

== Frequently Asked Questions ==

= Does it support WooCommerce products? =
Yes. Select the `product` post type and any WooCommerce taxonomy (e.g. `product_cat` or `product_tag`) in the query settings.

= Do I need Elementor Pro? =
The filter widget itself loads with Elementor Free, but filtering Loop Grids requires the Loop Builder feature in Elementor Pro.

= Does each filter change send an AJAX request? =
No. Filtering happens in the browser using the Loop Grid items already loaded on the page. The initial page load still has to load the grid content.

= Does it work with custom post types and custom taxonomies? =
Yes. Any public post type and any public taxonomy — including those registered by ACF, CPT UI, or custom code — can be selected in the widget's Query settings.

= Can I filter by multiple terms at once? =
Yes. Use the Checkbox or Multi-Select filter types to let visitors combine multiple taxonomy terms.

== Changelog ==

= 1.0.8 =
* Fixed: Asset registration now works reliably in Elementor frontend and editor preview contexts.
* Fixed: Target CSS IDs and widget settings are validated and sanitized before rendering or filtering.
* Improved: Plugin activation/deactivation lifecycle and WordPress multisite uninstall cleanup.
* Added: Dynamic re-initialization and target-grid observation for editor changes and AJAX/pagination updates.
* Improved: Filter accessibility markup and plugin text-domain loading.
* Improved: Debug logging now reports initialization failures instead of failing silently.

= 1.0.7 =
* Added: Comprehensive icon styling and Elementor hover animations.
* Added: Margin controls for buttons and checkbox/radio items.
* Fixed: Taxonomy discovery now includes public taxonomies registered globally.

= 1.0.6 =
* Fixed: CSS ID handling, animation transitions, editor assets, and radio reset behavior.
* Improved: Elementor style specificity and exact taxonomy class matching.

= 1.0.5 =
* Fixed: Elementor detection could fail depending on plugin load order, showing a false "Elementor missing" notice.
* Fixed: Term class matching now uses exact class checks — filtering "news" no longer matches "news-updates".
* Fixed: Rapidly toggling filters no longer leaves items hidden (animation race condition).
* Fixed: Multi-select reset now correctly clears all selected options.
* Fixed: Implemented the Slide Down, Zoom In, and Zoom Out animations offered in widget settings.
* Fixed: Duplicate event listeners when a widget re-initializes.
* Fixed: Filter now initializes in the Elementor editor preview.
* Fixed: Removed invalid CSS and stray characters in stylesheet.
* Improved: No animation flash on initial page load.

= 1.0.0 =
* Initial release.
* Instant CSS-engine filtering for Elementor Pro Loop Grids.
* 5 filter types, full style controls, and responsive layouts.
