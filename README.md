# ACF Taxonomy Filter for Elementor

**The fastest taxonomy filter widget for Elementor Pro Loop Grids — instant CSS-based filtering with zero AJAX, zero page reloads, and zero database overhead.** Filter WordPress posts, WooCommerce products, and custom post types by categories, tags, or ACF custom taxonomies using buttons, checkboxes, radio buttons, dropdowns, or multi-select — all with smooth animations and full Elementor visual style controls.

[![WordPress](https://img.shields.io/badge/WordPress-6.0%2B-blue?logo=wordpress)](https://wordpress.org/)
[![Elementor](https://img.shields.io/badge/Elementor-Pro-purple?logo=elementor)](https://elementor.com/)
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![License](https://img.shields.io/badge/License-GPL--2.0--or--later-green)](LICENSE)
[![Version](https://img.shields.io/badge/Version-1.0.8-orange)](CHANGELOG.md)

---

## 👋 Why This Plugin Exists

Hi, I'm Tanzim! I built this plugin because I was frustrated with the heavy, AJAX-bloated filtering plugins available for Elementor. They broke my layouts, fired duplicate database queries on every click, and slowed down my sites.

I wanted something that felt **completely native** to Elementor Pro — a widget you just drop in, connect to your Loop Grid with a simple CSS ID, and it **just works**. No configuration headaches, no performance penalties, no broken designs.

The result is a filter engine that runs entirely in the browser using an optimized CSS visibility system. Your visitors get instant results with smooth animations, and your server doesn't even know a filter was clicked.

### What makes this different from other WordPress filter plugins:

- **⚡ Zero AJAX Lag** — Posts filter and animate instantly on click. No loading spinners, no server roundtrips, better Core Web Vitals scores.
- **🛡️ Unbreakable Stability** — Every critical path is wrapped in `try/catch` exception handling. Even if another plugin throws an error, this one keeps working.
- **🎯 Simple CSS ID Targeting** — Connect your filter to any Loop Grid with one CSS ID. No complicated query builders or shortcodes.
- **🔒 Secure & Lightweight** — Built with strict WordPress coding standards, proper sanitization/escaping, and vanilla JavaScript (zero jQuery dependency).

---

## ✨ Features at a Glance

| Feature | Description |
|---------|-------------|
| **5 Filter Types** | Buttons, Checkboxes, Radio Buttons, Dropdown, Multi-Select |
| **6 Animations** | Fade, Slide Up, Slide Down, Zoom In, Zoom Out, None |
| **Custom Icons** | Add Font Awesome or SVG icons next to filter labels |
| **Live Result Count** | Shows "{count} results found" with customizable text |
| **Reset Button** | One-click filter reset with customizable label |
| **Term Counts** | Optional post count badge next to each term |
| **Hierarchical Terms** | Indented child categories for organized display |
| **3 Layouts** | Horizontal, Vertical, or Grid with responsive alignment |
| **Full Style Controls** | Normal/Hover/Active states for colors, backgrounds, borders, typography, shadows |
| **WooCommerce Ready** | Filter products by `product_cat`, `product_tag`, or any custom taxonomy |
| **ACF Compatible** | Works with any taxonomy registered via ACF, CPT UI, or custom code |
| **Accessible** | ARIA roles, keyboard navigation, focus-visible outlines |
| **No Dependencies** | Vanilla JS, no jQuery, no external libraries |

---

## 📋 Setup Guide — Under 60 Seconds

### Step 1: Add a Loop Grid
Open any page in the **Elementor editor** and drag an **Elementor Pro Loop Grid** widget onto your page. Configure your loop template as usual.

### Step 2: Set a CSS ID on Your Loop Grid
In the Loop Grid widget settings, navigate to:
> **Advanced** → **Layout** → **CSS ID**

Enter a unique identifier, for example: `my-product-grid`

### Step 3: Add the Taxonomy Filter Widget
Search for **"ACF Taxonomy Filter"** in the Elementor widget panel and drag it above your Loop Grid.

### Step 4: Link the Filter to Your Grid
In the filter widget's **Loop Action** section, enter the exact same CSS ID:
> `my-product-grid` *(do not include the `#` symbol)*

### Step 5: Configure & Style
- Choose your **Post Type** and **Taxonomy** in the Query tab
- Pick your **Filter Type** (Buttons, Checkboxes, etc.)
- Select an **Animation** (Fade, Slide Up, Zoom In, etc.)
- Style everything from the **Style tab** — colors, typography, borders, shadows, spacing

**That's it!** Your filter is live and filtering instantly.

---

## 🛠️ Complete Widget Settings Reference

### Content Tab

| Section | Controls |
|---------|----------|
| **Loop Action** | CSS ID to connect filter to your Loop Grid |
| **Filter Type** | Type selector, "All" button toggle/label, icon picker, animation |
| **Query** | Post type, taxonomy, hide empty, term sort order |
| **Display** | Layout direction, alignment, term counts, hierarchy, title |
| **Labels & Actions** | Result count text template, reset button label |

### Style Tab

| Section | Controls |
|---------|----------|
| **Container** | Background, border, radius, padding, margin, gap, box shadow |
| **Title** | Typography, color, spacing, text shadow |
| **Buttons** | Normal/Hover/Active tabs: text color, background, border, box shadow, text shadow, transition, radius, padding, min-width |
| **Dropdown** | Typography, color, background, border, radius, padding, height, box shadow |
| **Checkbox/Radio** | Typography, label color, hover color, input size, gap, padding, background, hover background, border, radius |
| **Term Count** | Typography, color |
| **Reset Button** | Normal/Hover tabs: typography, color, background, border, radius, padding |
| **Actions Bar** | Top spacing, result count typography/color |

---

## ⚙️ Requirements

| Requirement | Minimum Version |
|-------------|----------------|
| WordPress | 6.0+ |
| Tested up to | 6.6 |
| PHP | 7.4+ |
| Elementor Free | For placing the widget |
| Elementor Pro | Required for Loop Grid filtering |

---

## 🌐 Browser Compatibility

Tested and working across all modern browsers:

- ✅ Chrome (Desktop & Mobile)
- ✅ Firefox
- ✅ Safari (macOS & iOS)
- ✅ Edge
- ✅ Opera / Android Chrome

---

## ♿ Accessibility

Built with WCAG best practices:

- Native button, checkbox, radio, and select controls
- Group and pressed-state semantics for filter controls
- Dynamic `aria-pressed` state updates for button filters
- Full keyboard navigation with `focus-visible` outlines
- Screen reader friendly labels

---

## 💡 Frequently Asked Questions

**Does it work with WooCommerce products?**
Yes! Select `product` as the post type and choose any WooCommerce taxonomy (`product_cat`, `product_tag`, or custom attributes) in the Query settings.

**Do I need Elementor Pro?**
The filter widget loads with Elementor Free, but actually filtering a Loop Grid requires **Elementor Pro's Loop Builder**.

**Will this slow down my website or hurt my SEO?**
No. All filtering happens in the browser via CSS — no server calls, no extra database queries. All post content stays in the HTML source, so search engines can still crawl and index everything.

**Can visitors select multiple taxonomy terms?**
Yes — use the **Checkbox** or **Multi-Select** filter types to let users combine multiple terms.

**Does it work with custom post types and ACF fields?**
Yes. Any public post type and any public taxonomy works, including those registered by ACF, CPT UI, Toolset, or custom PHP code.

**What happens if I don't enter a CSS ID?**
The widget shows a clear warning message in the Elementor editor telling you to set up the CSS ID connection. On the frontend, it simply won't filter anything — no errors, no crashes.

---

## 📝 Changelog

### 1.0.8 — Stability & Elementor Compatibility
- **Fixed:** Asset registration now works reliably in Elementor frontend and editor preview contexts.
- **Fixed:** Target CSS IDs and widget settings are validated and sanitized before rendering or filtering.
- **Added:** Dynamic re-initialization and grid observation for Elementor updates and AJAX/pagination changes.
- **Improved:** Activation/deactivation lifecycle, dependency notice, and multisite uninstall cleanup.
- **Improved:** Filter accessibility semantics and plugin text-domain loading.
- **Improved:** Debug logging now reports failures instead of failing silently.

### 1.0.7 — New Style Controls & Fixes
- **Added:** Comprehensive Icon styling section (size, spacing, normal/hover/active colors).
- **Added:** Elementor Hover Animation support for Buttons (Grow, Shrink, Pulse, etc.).
- **Added:** Margin controls for Buttons and Checkbox/Radio items.
- **Fixed:** Taxonomy query logic now captures all ACF custom taxonomies reliably by using `get_taxonomies()` globally.

### 1.0.6 — Bug Fixes & Stability
- **Fixed:** `querySelector` crash when user accidentally includes `#` or `.` in the CSS ID field
- **Fixed:** Animation transitions never played due to missing DOM reflow — now smooth on all browsers
- **Fixed:** CSS specificity too low — Elementor theme styles could override filter button appearance
- **Fixed:** Hardcoded default colors removed — Elementor Style tab controls are now the sole authority
- **Fixed:** SVG icons rendered as `[object Object]` in Elementor editor live preview
- **Fixed:** Radio reset logic was fragile — now uses explicit null/empty check
- **Fixed:** `animate` parameter was implicitly `undefined` on user clicks — now explicitly defaults to `true`
- **Cleaned up:** Removed dead CSS from deleted AJAX engine (loading spinner, loop-grid classes)
- **Cleaned up:** `uninstall.php` no longer references non-existent database options

### 1.0.5 — Stability Release
- Fixed Elementor detection race condition
- Fixed exact term-class matching (e.g. "news" no longer matches "news-updates")
- Fixed animation race condition on rapid toggling
- Fixed multi-select reset behavior
- Added Slide Down, Zoom In, and Zoom Out animations
- Fixed duplicate event listeners on re-initialization
- Filter now initializes in Elementor editor preview

### 1.0.0 — Initial Release
- 5 filter types with instant CSS-engine filtering
- Full Elementor style controls (Normal/Hover/Active)
- Accessible markup with ARIA roles and keyboard navigation

---

## 📄 License

This plugin is free software released under the [GNU General Public License v2.0 or later](LICENSE).

You are free to use, modify, and distribute this plugin under the terms of the GPL-2.0-or-later license. See the [LICENSE](LICENSE) file for the complete legal text.

---

## 👨‍💻 Author

**Tanzim Ahmed**

- GitHub: [@mr-tanzim-ahmed](https://github.com/mr-tanzim-ahmed)
- Repository: [ACF-Taxonomy-Filter-for-Elementor](https://github.com/mr-tanzim-ahmed/ACF-Taxonomy-Filter-for-Elementor)

---

*If this plugin helped you, consider giving it a ⭐ on GitHub!*
