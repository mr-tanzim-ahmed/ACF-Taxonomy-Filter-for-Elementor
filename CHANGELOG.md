# Changelog

All notable changes to this project will be documented in this file.

## [1.0.5] - Stability & bug-fix release
- Fixed: Elementor detection used a load-order-dependent check (`did_action('elementor/loaded')`), which could show a false "Elementor is missing" admin notice and prevent the widget from registering. Now uses a load-order-independent check.
- Fixed: Term matching used substring matching on the class attribute, so filtering by "news" also matched "news-updates". Now uses exact `classList.contains()` checks.
- Fixed: Animation race condition — rapidly re-showing an item within the 300ms hide transition left it hidden. Pending hide timers are now cancelled.
- Fixed: Multi-select reset selected the first option instead of clearing all selections.
- Fixed: The Slide Down, Zoom In, and Zoom Out animations offered in widget settings were not implemented; all animation options now work.
- Fixed: Re-initialization could stack duplicate event listeners, causing double-toggle behavior.
- Fixed: The filter now initializes in the Elementor editor preview (data attributes added to the JS render template).
- Fixed: Removed invalid `justify-content: stretch` declaration and stray carriage return from the frontend stylesheet.
- Improved: No animation flash on initial page load; result count updates even when no items match.
- Updated: Version synced across plugin header, JS, readme.txt, and README.md; author URI corrected.

## [1.0.0] - Initial release
- Added ACF Taxonomy Filter widget with 5 filter types (button, checkbox, radio, dropdown, multiselect).
- Instant client-side CSS-engine filtering for Elementor Pro Loop Grids via CSS ID targeting.
- Full Elementor style controls (normal/hover/active states, typography, borders, shadows).
- Accessible markup with ARIA roles and keyboard navigation.
