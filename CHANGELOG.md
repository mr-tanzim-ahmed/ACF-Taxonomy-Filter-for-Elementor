# Changelog

All notable changes to this project will be documented in this file.

## [1.0.6] - Bug Fixes & Stability

- **Fixed:** `querySelector` crash when user accidentally includes `#` or `.` in the CSS ID field — now sanitized and wrapped in try/catch.
- **Fixed:** Animation transitions never played due to missing DOM reflow — now forces reflow for smooth animations on all browsers.
- **Fixed:** CSS specificity too low — Elementor theme styles could override filter button appearance. All selectors now nest under `.acf-tax-filter` parent.
- **Fixed:** Hardcoded default button colors removed — Elementor Style tab controls are now the sole authority for colors.
- **Fixed:** SVG icons rendered as `[object Object]` in Elementor editor live preview — added type guard for string vs SVG object.
- **Fixed:** Radio reset logic was fragile — now uses explicit null/empty slug check.
- **Fixed:** `animate` parameter was implicitly `undefined` on user clicks — now explicitly defaults to `true`.
- **Cleaned up:** Removed dead CSS from deleted AJAX engine (loading spinner, loop-grid, loop-item classes).
- **Cleaned up:** `uninstall.php` no longer references non-existent database options from the removed cache system.

## [1.0.5] - Stability & bug-fix release

- Fixed: Elementor detection used a load-order-dependent check (`did_action('elementor/loaded')`), which could show a false "Elementor is missing" admin notice. Now uses a load-order-independent check.
- Fixed: Term matching used substring matching on the class attribute, so filtering by "news" also matched "news-updates". Now uses exact `classList.contains()` checks.
- Fixed: Animation race condition — rapidly re-showing an item within the 300ms hide transition left it hidden. Pending hide timers are now cancelled.
- Fixed: Multi-select reset selected the first option instead of clearing all selections.
- Fixed: The Slide Down, Zoom In, and Zoom Out animations offered in widget settings were not implemented; all animation options now work.
- Fixed: Re-initialization could stack duplicate event listeners, causing double-toggle behavior.
- Fixed: The filter now initializes in the Elementor editor preview.
- Improved: No animation flash on initial page load; result count updates even when no items match.

## [1.0.0] - Initial release

- Added ACF Taxonomy Filter widget with 5 filter types (button, checkbox, radio, dropdown, multiselect).
- Instant client-side CSS-engine filtering for Elementor Pro Loop Grids via CSS ID targeting.
- Full Elementor style controls (normal/hover/active states, typography, borders, shadows).
- Accessible markup with ARIA roles and keyboard navigation.
