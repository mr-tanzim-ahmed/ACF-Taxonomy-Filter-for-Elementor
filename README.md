# ACF Taxonomy Filter for Elementor

**Instant taxonomy filtering for Elementor Pro Loop Grids — no AJAX, no page reloads, no database strain.** Filter WordPress posts, WooCommerce products, and custom post types by categories, tags, or ACF custom taxonomies with buttons, checkboxes, radio buttons, dropdowns, or multi-select — all with smooth animations and full Elementor style controls.

**Version:** 1.0.5 · **Requires:** WordPress 6.0+, PHP 7.4+, Elementor (Loop Grid requires Elementor Pro) · **License:** GPL-2.0-or-later

---

## 👋 Meet Your New Favorite Elementor Filter

If you've ever built a beautiful Loop Grid in Elementor Pro and wanted a simple, blazing-fast way to filter those posts by categories, tags, or Advanced Custom Fields (ACF) custom taxonomies — without writing any code or dealing with clunky page reloads — you're in the right place.

This WordPress filtering plugin was built as an answer to heavy, AJAX-bloated filter plugins that break layouts, fire duplicate database queries, and slow down your site. Instead, it filters instantly in the browser using an optimized CSS engine that feels completely native to Elementor Pro.

**What makes this Elementor taxonomy filter different:**

- **Zero AJAX Lag:** A highly optimized CSS toggling engine sorts and animates posts instantly on click. No loading spinners, no database strain, better Core Web Vitals.
- **Unbreakable Stability:** The core engine is wrapped in robust exception handling. Even if another plugin misbehaves, errors are logged gracefully instead of crashing your live site.
- **Bulletproof CSS Targeting:** Link your filter to any Elementor Loop Grid instantly using a standard CSS ID. No complicated setup.
- **Developer-Friendly & Secure:** Strict WordPress coding standards, proper sanitization and escaping, and lightweight vanilla JavaScript with no jQuery dependency.

Whether you're building a WooCommerce store, a real estate portfolio, a directory, or a WordPress blog, this plugin delivers the buttery-smooth filtering experience your visitors expect.

---

## ✨ Key Features

- ⚡ **Instant CSS-Based Filtering** — Smooth, tab-like filtering with zero page refresh, zero database lag, and no URL changes.
- 🎨 **Native Loop Grid Integration** — Built to work natively with Elementor Pro's Loop Builder via a simple CSS ID link.
- 🔘 **5 Filter Types** — Buttons, Checkboxes, Radio Buttons, Dropdown, and Multi-Select, with optional icons.
- 🎬 **6 Animation Options** — Fade, Slide Up, Slide Down, Zoom In, Zoom Out, or none.
- 🏷️ **ACF & Custom Taxonomy Support** — Works with categories, tags, WooCommerce taxonomies, and any custom taxonomy registered via ACF, CPT UI, or custom code.
- 🖌️ **100% Visual Styling Controls** — Style buttons, checkboxes, dropdowns, icons, counts, and reset button across normal, hover, and active states — all from the Elementor panel.
- 📱 **Fully Responsive** — Horizontal, vertical, and grid layouts with per-device alignment, gaps, and spacing.
- 🔢 **Term Counts & Result Counter** — Optional post count per term, live result count message, and a reset filter button.
- 🌳 **Hierarchical Terms** — Optional indentation for child categories.
- ♿ **Accessible Markup** — Keyboard navigability, semantic tags, and ARIA attributes (`aria-selected`, `aria-pressed`, `role="tablist"`).
- 🚀 **Performance Optimized** — Clean CSS and lightweight vanilla JS. No external library dependencies.

---

## 📋 Setup in Under a Minute

1. Open any page or template in the **Elementor editor**.
2. **Add your Loop Grid:** Drag an Elementor Pro Loop Grid widget onto your page and set up your template.
3. **Give your Loop Grid an ID:** In the Loop Grid settings, go to **Advanced → Layout → CSS ID** and enter a unique ID (e.g. `my-custom-grid`).
4. **Add the Filter:** Search for **ACF Taxonomy Filter** in the Elementor panel and drag it above your Loop Grid.
5. **Link them together:** In the filter widget's **Loop Action** tab, enter the exact same CSS ID in the **Selected Loop Grid (CSS ID)** field — without the `#`.
6. **Configure & Style:** Choose your post type, taxonomy, and filter type, then customize everything from the Style tab.

---

## 🛠️ Widget Settings Guide

### Content Tab
* **Loop Action:** The CSS ID that connects this filter to your Elementor Loop Grid.
* **Filter Type:** Buttons, Checkboxes, Radio Buttons, Dropdown, or Multi-Select — with custom icons and entry animations.
* **Query:** Post type, taxonomy, hide empty terms, and term sort order (name/count, ascending/descending).
* **Display:** Taxonomy title, hierarchy indentation, term post counts, and layout/alignment.
* **Labels & Actions:** Result count text and reset button label.

### Style Tab
* **Container:** Background, border, radius, margin, padding, gap, and box shadow.
* **Title:** Typography, color, spacing, and text shadow.
* **Buttons:** Normal, Hover, and Active states — colors, backgrounds, borders, typography, shadows, transitions.
* **Checkbox & Radio:** Input size, label gap, padding, hover background, and borders.
* **Dropdown & Multi-Select:** Typography, colors, borders, padding, and height.
* **Actions Bar:** Result count typography/color and reset button styling.

---

## ⚙️ Requirements

| Requirement | Version |
|------------|---------|
| WordPress | 6.0+ |
| Tested up to | 6.6 |
| PHP | 7.4+ |
| Elementor | Free or Pro |
| Elementor Pro | Required for Loop Grid filtering |

---

## 💡 Frequently Asked Questions

### Does it work with WooCommerce products?
Yes! Select the `product` post type and a WooCommerce taxonomy (like `product_cat` or `product_tag`) in the widget's Query settings.

### Do I need Elementor Pro?
The filter widget loads with Elementor Free, but filtering Loop Grids requires **Elementor Pro's Loop Builder** feature.

### Will this slow down my website or hurt SEO?
No. Filtering runs entirely in the browser via CSS toggling — no AJAX calls, no extra database queries. All posts remain in the HTML, so search engines can crawl everything.

### Can visitors select multiple terms?
Yes — use the Checkbox or Multi-Select filter types to combine multiple taxonomy terms.

### Does it support custom post types and ACF taxonomies?
Yes. Any public post type and any public taxonomy, including those registered by ACF, CPT UI, or custom code.

---

## 📝 Changelog

### 1.0.5
- Fixed Elementor detection race that could show a false "Elementor missing" notice.
- Fixed exact term-class matching (e.g. "news" no longer matches "news-updates").
- Fixed animation race condition when toggling filters rapidly.
- Fixed multi-select reset clearing all options correctly.
- Implemented Slide Down, Zoom In, and Zoom Out animations.
- Fixed duplicate event listeners on widget re-initialization.
- Filter now initializes in the Elementor editor preview.
- CSS cleanup and no animation flash on initial page load.

### 1.0.0
- Initial release with instant CSS-engine filtering, 5 filter types, and full style controls.

---

## 📄 License

This plugin is free software, released under the **GNU General Public License v2.0 or later**. See [LICENSE](LICENSE) for the full text.

---

## 👨‍💻 Author

**Tanzim Ahmed**

GitHub: [https://github.com/mr-tanzim-ahmed/ACF-Taxonomy-Filter-for-Elementor](https://github.com/mr-tanzim-ahmed/ACF-Taxonomy-Filter-for-Elementor)
