# ACF Taxonomy Filter for Elementor

A high-performance, lightweight Elementor widget that lets you filter posts, custom post types, and WooCommerce products instantly using a smooth, tab-like interface without any page reloads or layout breaks.

Unlike heavy AJAX-based filtering widgets that break the Elementor Pro Loop Grid layout and cause database overhead, this plugin utilizes a highly optimized CSS-based visibility toggling engine. It renders your Elementor Pro Loop Templates natively and filters them instantly on the client side.

---

## ✨ Features

- ⚡ **Instant CSS-Based Filtering:** Seamless, smooth, tab-like filtering with zero page refresh, zero database lag, and no URL changes.
- 🎨 **Native Loop Grid Integration:** Built to work natively with Elementor Pro's Loop Builder. Select your Loop Templates right inside the widget.
- 🖌️ **100% Visual Styling Controls:** Complete style settings in Elementor's style panel that adapt dynamically to your selected layout. Style buttons, checkboxes, dropdowns, and layouts individually.
- 🏷️ **Dynamic & ACF Integration:** Supports standard WordPress categories/tags, custom taxonomies, and custom fields registered via Advanced Custom Fields (ACF).
- 📱 **Mobile & Responsive Friendly:** Adjust alignment, grid columns, layouts (horizontal, vertical), and gaps independently for desktop, tablet, and mobile.
- ♿ **Accessible Markup:** Keyboard navigability, semantic tags, and ARIA labels (e.g. `aria-selected`, `aria-pressed`, `role="tablist"`).
- 🚀 **Performance Optimized:** Clean CSS and lightweight vanilla JavaScript. No external library dependencies.

---

## Requirements

| Requirement | Version |
|------------|---------|
| WordPress | 6.0+ |
| Tested up to | 6.6 |
| PHP | 7.4+ |
| Elementor / Elementor Pro | Latest Recommended (Loop Templates require Elementor Pro) |

---

## Installation

### Method 1 — Upload Plugin

1. Download the plugin ZIP file.
2. Log into your WordPress Dashboard and navigate to **Plugins → Add New**.
3. Click **Upload Plugin** at the top.
4. Choose the plugin ZIP and click **Install Now**.
5. Activate the plugin.

### Method 2 — Manual Installation

1. Unzip the plugin folder.
2. Upload the `acf-taxonomy-filter-elementor` directory to your server's `/wp-content/plugins/` directory.
3. Go to **Dashboard → Plugins** and click **Activate** under the plugin name.

---

## Usage

1. Open any page or template using the Elementor editor.
2. Search for the widget named:
   ```
   ACF Taxonomy Filter
   ```
3. Drag the widget onto your section.
4. **Configure the Query:** Select your desired post type and choose the taxonomy you want to filter by.
5. **Set the Loop Template:** Under the **Loop Grid** settings section, select the saved Elementor Loop Item Template you want to use.
6. Configure columns, sorting order (Date, Title, Random, Menu Order), and sorting direction.
7. Customize layouts, buttons, reset options, or dropdown views using the **Style** tab.

---

## Widget Settings

### Content Tab

* **Query:** Select Post Type, select Taxonomy, hide empty terms, set term sort order.
* **Filter Layout:** Toggle between Buttons, Checkboxes, Radio Buttons, Dropdowns, and Multi-Select views.
* **Loop Grid:** Select the Loop Item Template, set posts per page limit, order by options, sorting direction, and grid columns.
* **Display Options:** Toggle taxonomy title, hierarchy indentation, term post counts, and active reset buttons.

### Style Tab

* **Layout Container:** Setup background, border, margins, and padding for the entire wrapper.
* **Buttons Layout:** Normal, Hover, and Active controls for colors, backgrounds, borders, typography, and box shadows.
* **Checkbox & Radio:** Adjust spacings, label sizes, gap controls, and focus states.
* **Dropdown & Multi-Select:** Style native options, selection borders, padding, and text properties.
* **Actions & Reset:** Control visual appearance of the "Reset Filter" button and "Result Count" message.

---

## Browser Compatibility

Fully compatible and tested across all modern web browsers:

- ✅ Chrome (Desktop & Mobile)
- ✅ Safari (macOS & iOS Safari)
- ✅ Firefox
- ✅ Edge
- ✅ Opera / Android Chrome

---

## Accessibility

Built with web accessibility best practices:

- Includes semantic `role="tablist"` and `role="tab"` markup for filter lists.
- Full keyboard focus visibility styling.
- `aria-selected` and `aria-pressed` states are updated dynamically on interaction.

---

## Changelog

### Version 1.0.0
- Initial Release.
- Rebuilt from the ground up using native Elementor Pro Loop rendering context.
- Added comprehensive style controls for Buttons, Checkboxes, and Dropdowns.
- Replaced external widget target selectors with direct grid generation.

---

## Frequently Asked Questions

### Does it work with WooCommerce products?
Yes. Simply select the `product` post type and a WooCommerce taxonomy (e.g. `product_cat` or `product_tag`) in the widget settings.

### Do I need Elementor Pro?
While the basic taxonomy filter structure works with the free version of Elementor, rendering Loop Item Templates natively requires **Elementor Pro's Loop Builder** capability.

### Will this slow down my website?
No. Because the plugin uses CSS toggling rather than making expensive AJAX database calls every time a user clicks a term, it loads instantly and runs entirely on the client browser.

---

## Author

**Tanzim Ahmed**

GitHub:
https://github.com/mr-tanzim-ahmed/acf-taxonomy-filter-elementor
