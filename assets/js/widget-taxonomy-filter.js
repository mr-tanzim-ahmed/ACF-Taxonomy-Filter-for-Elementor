/**
 * ACF Taxonomy Filter for Elementor - Frontend JS
 * Version 1.0.6
 *
 * CSS Engine - Instant filtering of a targeted Elementor Loop Grid widget.
 *
 * @package ACF_TFE
 */
(function () {
    'use strict';

    /**
     * Main Filter Widget Class
     * @param {HTMLElement} el - The widget wrapper element
     */
    function ACFTaxFilter(el) {
        if (!el || el.dataset.acfTfeInit === '1') return;
        el.dataset.acfTfeInit = '1';

        this.el         = el;
        this.widgetId   = el.getAttribute('data-acf-tfe-widget') || '';
        this.taxonomy   = el.getAttribute('data-taxonomy') || 'category';
        this.postType   = el.getAttribute('data-post-type') || 'post';
        this.filterType = el.getAttribute('data-filter-type') || 'button';
        this.animation  = el.getAttribute('data-animation') || 'fade';

        // Sanitize target ID: strip leading # or . that users may accidentally include
        var rawId = el.getAttribute('data-target-id') || '';
        this.targetId = rawId.replace(/^[#.]+/, '');

        this.activeTerms = [];
        this.resetBtn    = el.querySelector('.acf-tax-filter__reset');
        this.countEl     = el.querySelector('.acf-tax-filter__result-count');
        this.countTpl    = this.countEl ? (this.countEl.getAttribute('data-template') || '{count} results') : '';

        this._bindEvents();
        // Wait a small tick on load to ensure Elementor grids are parsed
        var self = this;
        setTimeout(function() {
            self._filter(false); // Init counts correctly on load (no animation flash)
        }, 100);
    }

    // =====================================================
    // EVENT BINDING
    // =====================================================
    ACFTaxFilter.prototype._bindEvents = function () {
        var self = this;

        if (this.filterType === 'button') {
            this.el.addEventListener('click', function (e) {
                var btn = e.target.closest('.acf-tax-filter__item');
                if (!btn) return;
                e.preventDefault();
                var slug = btn.getAttribute('data-term-slug');

                if (slug === '' || slug === null) {
                    self.activeTerms = [];
                } else {
                    var idx = self.activeTerms.indexOf(slug);
                    if (idx !== -1) {
                        self.activeTerms = [];
                    } else {
                        self.activeTerms = [slug];
                    }
                }
                self._updateButtonUI();
                self._filter(true);
            });
        } else if (this.filterType === 'checkbox') {
            this.el.addEventListener('change', function (e) {
                if (e.target.type !== 'checkbox') return;
                self._syncFromInputs();
                self._filter(true);
            });
        } else if (this.filterType === 'radio') {
            this.el.addEventListener('change', function (e) {
                if (e.target.type !== 'radio') return;
                self._syncFromInputs();
                self._filter(true);
            });
        } else if (this.filterType === 'dropdown' || this.filterType === 'multiselect') {
            var select = this.el.querySelector('select');
            if (select) {
                select.addEventListener('change', function () {
                    self._syncFromSelect(select);
                    self._filter(true);
                });
            }
        }

        if (this.resetBtn) {
            this.resetBtn.addEventListener('click', function (e) {
                e.preventDefault();
                self._reset();
            });
        }
    };

    // =====================================================
    // UI SYNC HELPERS
    // =====================================================
    ACFTaxFilter.prototype._syncFromInputs = function () {
        this.activeTerms = [];
        var checked = this.el.querySelectorAll('input:checked');
        for (var i = 0; i < checked.length; i++) {
            var slug = checked[i].getAttribute('data-term-slug');
            if (slug) this.activeTerms.push(slug);
        }
    };

    ACFTaxFilter.prototype._syncFromSelect = function (select) {
        this.activeTerms = [];
        var opts = select.selectedOptions || select.options;
        for (var i = 0; i < opts.length; i++) {
            if (opts[i].selected && opts[i].value) {
                this.activeTerms.push(opts[i].value);
            }
        }
    };

    ACFTaxFilter.prototype._updateButtonUI = function () {
        var self = this;
        var items = this.el.querySelectorAll('.acf-tax-filter__item');
        for (var i = 0; i < items.length; i++) {
            var item = items[i];
            var slug = item.getAttribute('data-term-slug');
            var isActive;
            if (slug === '' || slug === null) {
                isActive = self.activeTerms.length === 0;
            } else {
                isActive = self.activeTerms.indexOf(slug) !== -1;
            }
            if (isActive) {
                item.classList.add('acf-tax-filter__item--active');
            } else {
                item.classList.remove('acf-tax-filter__item--active');
            }
            item.setAttribute('aria-pressed', String(isActive));
            item.setAttribute('aria-selected', String(isActive));
        }
    };

    // =====================================================
    // CSS ENGINE - Instant filtering of target Loop Grid
    // =====================================================
    ACFTaxFilter.prototype._filter = function (animate) {
        // FIX BUG 6: Default animate to true when not explicitly false
        if (typeof animate === 'undefined') {
            animate = true;
        }

        // Update reset button visibility
        if (this.resetBtn) {
            this.resetBtn.style.display = this.activeTerms.length === 0 ? 'none' : 'inline-block';
        }

        var target = this._getCSSTarget();
        if (!target) {
            if (this.targetId) {
                console.warn('ACF Taxonomy Filter: Could not find target Loop Grid with ID: ' + this.targetId);
            }
            return;
        }

        var items = this._getLoopItems(target);
        if (!items || items.length === 0) return;

        var showAll = this.activeTerms.length === 0;
        var visibleCount = 0;

        for (var i = 0; i < items.length; i++) {
            var item = items[i];
            var show = false;

            if (showAll) {
                show = true;
            } else if (item.classList) {
                for (var j = 0; j < this.activeTerms.length; j++) {
                    var cls = 'acf-tfe-' + this.taxonomy + '-' + this.activeTerms[j];
                    if (item.classList.contains(cls)) {
                        show = true;
                        break;
                    }
                }
            }

            this._toggleItem(item, show, animate);
            if (show) visibleCount++;
        }

        this._updateCount(visibleCount);
    };

    // FIX BUG 1: Wrap querySelector in try/catch to prevent crash on invalid selectors
    ACFTaxFilter.prototype._getCSSTarget = function () {
        if (!this.targetId) return null;

        var target = null;

        // Try as CSS ID first (the documented usage)
        try {
            target = document.getElementById(this.targetId);
        } catch (e) {
            // Ignore
        }

        // Fallback: Elementor internal class .elementor-element-{id}
        if (!target) {
            try {
                target = document.querySelector('.elementor-element-' + CSS.escape(this.targetId));
            } catch (e) {
                // CSS.escape may not exist in very old browsers; try without
                try {
                    target = document.querySelector('.elementor-element-' + this.targetId);
                } catch (e2) {
                    // Invalid selector, give up gracefully
                }
            }
        }

        return target || null;
    };

    ACFTaxFilter.prototype._getLoopItems = function (target) {
        // Elementor Pro Loop Grid items
        var items = target.querySelectorAll('.elementor-loop-item, .e-loop-item');
        if (items.length > 0) return items;

        // Fallback: items with our injected classes
        items = target.querySelectorAll('[class*="acf-tfe-"]');
        if (items.length > 0) return items;

        // Broader fallback: direct children of the grid container
        var grid = target.querySelector('.elementor-loop-container, .e-loop-container');
        if (grid) return grid.children;

        return [];
    };

    // =====================================================
    // SHARED HELPERS
    // =====================================================
    ACFTaxFilter.prototype._getHiddenTransform = function () {
        switch (this.animation) {
            case 'slide':      return 'translateY(12px)';
            case 'slide-down': return 'translateY(-12px)';
            case 'zoom-in':    return 'scale(0.9)';
            case 'zoom-out':   return 'scale(1.1)';
            default:           return ''; // fade / none
        }
    };

    // FIX BUG 2: Force reflow before setting show state so transitions actually fire
    ACFTaxFilter.prototype._toggleItem = function (item, show, animate) {
        // Cancel any pending hide timer (race condition fix)
        if (item._acfTfeHideTimer) {
            clearTimeout(item._acfTfeHideTimer);
            item._acfTfeHideTimer = null;
        }

        var anim = (animate === false) ? 'none' : this.animation;

        if (anim === 'none') {
            item.style.display = show ? '' : 'none';
            item.style.opacity = '';
            item.style.transform = '';
            item.style.transition = '';
            return;
        }

        var transform  = this._getHiddenTransform();
        var transition = transform
            ? 'opacity 0.3s ease, transform 0.3s ease'
            : 'opacity 0.3s ease';

        if (show) {
            // Step 1: Make visible but in hidden animation state
            item.style.display = '';
            item.style.transition = 'none'; // disable transition during setup
            item.style.opacity = '0';
            if (transform) item.style.transform = transform;

            // Step 2: Force reflow so the browser registers the hidden state
            void item.offsetHeight;

            // Step 3: Now enable transition and set final visible state
            item.style.transition = transition;
            item.style.opacity = '1';
            if (transform) item.style.transform = 'none';
        } else {
            item.style.transition = transition;
            item.style.opacity = '0';
            if (transform) item.style.transform = transform;
            item._acfTfeHideTimer = setTimeout(function () {
                item.style.display = 'none';
                item._acfTfeHideTimer = null;
            }, 300);
        }
    };

    ACFTaxFilter.prototype._updateCount = function (count) {
        if (!this.countEl) return;
        this.countEl.textContent = this.countTpl.replace('{count}', String(count));
        this.countEl.style.display = 'inline';
    };

    // FIX BUG 7: Explicit radio reset logic
    ACFTaxFilter.prototype._reset = function () {
        this.activeTerms = [];
        this._updateButtonUI();

        var checkboxes = this.el.querySelectorAll('input[type="checkbox"]');
        for (var i = 0; i < checkboxes.length; i++) checkboxes[i].checked = false;

        var radios = this.el.querySelectorAll('input[type="radio"]');
        for (var i = 0; i < radios.length; i++) {
            var slug = radios[i].getAttribute('data-term-slug');
            // "All" radio has slug="" or no slug at all — check it; uncheck all others
            radios[i].checked = (slug === '' || slug === null);
        }

        var select = this.el.querySelector('select');
        if (select) {
            if (select.multiple) {
                for (var k = 0; k < select.options.length; k++) select.options[k].selected = false;
            } else {
                select.selectedIndex = 0;
            }
        }

        this._filter(true);
    };

    // =====================================================
    // INITIALIZATION
    // =====================================================
    function initWidgets(scope) {
        var root = scope || document;
        // jQuery wrapped element
        if (root && root[0]) root = root[0];

        var widgets;
        if (root.hasAttribute && root.hasAttribute('data-acf-tfe-widget')) {
            widgets = [root];
        } else if (root.querySelectorAll) {
            widgets = root.querySelectorAll('[data-acf-tfe-widget]');
        } else {
            return;
        }

        for (var i = 0; i < widgets.length; i++) {
            if (widgets[i].dataset.acfTfeInit === '1') continue;
            new ACFTaxFilter(widgets[i]);
        }
    }

    // Elementor frontend handler
    if (typeof jQuery !== 'undefined') {
        jQuery(window).on('elementor/frontend/init', function () {
            if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
                elementorFrontend.hooks.addAction(
                    'frontend/element_ready/acf_taxonomy_filter.default',
                    function ($scope) {
                        initWidgets($scope);
                    }
                );
            }
        });
    }

    // Standard DOMContentLoaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            initWidgets();
        });
    } else {
        initWidgets();
    }
})();
