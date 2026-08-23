# ACF Taxonomy Filter for Elementor

## 👋 Meet Your New Favorite Elementor Filter

Hi there! Welcome to the **ACF Taxonomy Filter for Elementor**. 

If you've ever built a beautiful Loop Grid in Elementor Pro and wanted a simple, blazing-fast way to filter those posts by categories, tags, or Advanced Custom Fields (ACF) custom taxonomies—without writing any code or dealing with clunky page reloads—you're in the right place.

I built this Elementor filtering plugin because I was tired of heavy, AJAX-bloated filtering plugins that broke layouts, caused duplicate database queries, and slowed down my WordPress site. I wanted an experience that felt native to Elementor Pro. 

**Here is what makes this WordPress filtering plugin special:**
- **Zero AJAX Lag:** It uses a highly-optimized CSS toggling engine. When a user clicks a filter, the posts sort and animate instantly. No loading spinners, no database strain.
- **Unbreakable Stability:** The core engine is wrapped in robust exception handling (`try/catch` blocks). Even if another plugin misbehaves, this plugin will gracefully log the error in the background instead of crashing your live site.
- **Bulletproof CSS Targeting:** Link your filter to any Elementor Loop Grid instantly using standard CSS IDs. No complicated setups.
- **Developer-Friendly & Secure:** It’s built with strict WordPress security standards, proper sanitization, and lightweight vanilla JavaScript (no jQuery bloat).

Whether you're building a WooCommerce store, a dynamic real estate portfolio, or a simple WordPress blog, this Elementor plugin gives you the ultimate, buttery-smooth filtering experience your users deserve.

---

## ✨ Key Features for SEO & Performance

- ⚡ **Instant CSS-Based Filtering:** Seamless, smooth, tab-like filtering with zero page refresh, zero database lag, and no URL changes. Improves Core Web Vitals.
- 🎨 **Native Loop Grid Integration:** Built to work natively with Elementor Pro's Loop Builder. 
- 🖌️ **100% Visual Styling Controls:** Complete style settings in Elementor's style panel that adapt dynamically to your selected layout. Style filter buttons, checkboxes, dropdowns, icons, animations, and layouts individually.
- 🏷️ **Dynamic & ACF Integration:** Fully supports standard WordPress categories, tags, custom taxonomies, and custom fields registered via Advanced Custom Fields (ACF).
- 📱 **Mobile & Responsive Friendly:** Adjust alignment, grid columns, layouts (horizontal, vertical), and gaps independently for desktop, tablet, and mobile devices.
- ♿ **Accessible Markup:** Keyboard navigability, semantic tags, and ARIA labels (e.g. `aria-selected`, `aria-pressed`, `role="tablist"`).
- 🚀 **Performance Optimized:** Clean CSS and lightweight vanilla JavaScript. No external library dependencies.

---

## 📋 Clear Step-by-Step Instructions

It takes less than a minute to set up your first filter!

1. Open any page or template using the **Elementor editor**.
2. **Add your Loop Grid:** Drag an Elementor Loop Grid widget onto your page and set up your template.
3. **Give your Loop Grid an ID:** Go to the Loop Grid's settings -> **Advanced** -> **Layout** -> **CSS ID**. Enter a unique ID (for example: `my-custom-grid`).
4. **Add the Filter:** Search for the **ACF Taxonomy Filter** widget in the Elementor panel and drag it onto your page (usually right above your Loop Grid).
5. **Link them together:** 
   - In the filter widget settings, go to the **Loop Action** tab.
   - In the **Selected Loop Grid (CSS ID)** field, enter the exact same ID you used in step 3 (e.g., `my-custom-grid`). *Do not include the `#` symbol.*
6. **Configure the Query & Style:** Choose your post type, taxonomy, and filter style (Buttons, Checkboxes, Dropdowns, etc.). Add icons and animations from the Style tab!

---

## 🛠️ Widget Settings Guide

### Content Tab
* **Loop Action:** The CSS ID that connects this filter to your Elementor Loop Grid.
* **Filter Type:** Toggle between Buttons, Checkboxes, Radio Buttons, Dropdowns, and Multi-Select views. Add custom icons and choose your entry animation (Fade, Slide Up, Zoom, etc.).
* **Query:** Select Post Type, select Taxonomy, hide empty terms, set term sort order.
* **Display:** Toggle taxonomy title, hierarchy indentation, term post counts, and active reset buttons.
* **Labels & Actions:** Control visual appearance of the "Reset Filter" button and "Result Count" message.

### Style Tab
* **Layout Container:** Setup background, border, margins, and padding for the entire wrapper.
* **Title:** Style the taxonomy title text.
* **Buttons Layout:** Normal, Hover, and Active controls for colors, backgrounds, borders, typography, and box shadows.
* **Checkbox & Radio:** Adjust spacings, label sizes, gap controls, and focus states.
* **Dropdown & Multi-Select:** Style native options, selection borders, padding, and text properties.
* **Actions & Reset:** Customize the look of the reset button and count text.

---

## ⚙️ Requirements

| Requirement | Version |
|------------|---------|
| WordPress | 6.0+ |
| Tested up to | 6.6 |
| PHP | 7.4+ |
| Elementor / Elementor Pro | Latest Recommended (Loop Templates require Elementor Pro) |

---

## 💡 Frequently Asked Questions

### Does it work with WooCommerce products?
Yes! Simply select the `product` post type and a WooCommerce taxonomy (like `product_cat` or `product_tag`) in the widget's Query settings.

### Do I need Elementor Pro?
While the taxonomy filter widget itself can be placed in the free version of Elementor, filtering Loop Item Templates natively requires **Elementor Pro's Loop Builder** feature.

### Will this slow down my website or affect SEO?
No. Because this plugin uses CSS toggling rather than making expensive AJAX database calls every time a user clicks a term, it loads instantly and runs entirely in the browser. Search engines can still read all your content, and your server stays fast.

---

## 👨‍💻 Author

**Tanzim Ahmed**

GitHub:
[https://github.com/mr-tanzim-ahmed/ACF-Taxonomy-Filter-for-Elementor](https://github.com/mr-tanzim-ahmed/ACF-Taxonomy-Filter-for-Elementor)
