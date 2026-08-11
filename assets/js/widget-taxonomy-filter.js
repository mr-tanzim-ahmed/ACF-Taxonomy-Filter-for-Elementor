/**
 * ACF Taxonomy Filter for Elementor - Frontend JS
 * Version 1.0.3
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
        this.targetId   = el.getAttribute('data-target-id') || '';

        this.activeTerms = [];
        this.resetBtn    = el.querySelector('.acf-tax-filter__reset');
        this.countEl     = el.querySelector('.acf-tax-filter__result-count');
        this.countTpl    = this.countEl ? (this.countEl.getAttribute('data-template') || '{count} results') : '';

        this._bindEvents();
        // Wait a small tick on load to ensure Elementor grids are parsed
        var self = this;
        setTimeout(function() {
            self._filter(); // Init counts correctly on load
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
                self._filter();
            });
        } else if (this.filterType === 'checkbox') {
            this.el.addEventListener('change', function (e) {
                if (e.target.type !== 'checkbox') return;
                self._syncFromInputs();
                self._filter();
            });
        } else if (this.filterType === 'radio') {
            this.el.addEventListener('change', function (e) {
                if (e.target.type !== 'radio') return;
                self._syncFromInputs();
                self._filter();
            });
        } else if (this.filterType === 'dropdown' || this.filterType === 'multiselect') {
            var select = this.el.querySelector('select');
            if (select) {
                select.addEventListener('change', function () {
                    self._syncFromSelect(select);
                    self._filter();
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
    ACFTaxFilter.prototype._filter = function () {
        // Update reset button visibility
        if (this.resetBtn) {
            this.resetBtn.style.display = this.activeTerms.length === 0 ? 'none' : 'inline-block';
        }

        var target = this._getCSSTarget();
        if (!target) {
            console.warn('ACF Taxonomy Filter: Could not find target Loop Grid with ID: ' + this.targetId);
            return;
        }

        var items = this._getLoopItems(target);
        if (!items || items.length === 0) return;

        var showAll = this.activeTerms.length === 0;
        var visibleCount = 0;

        for (var i = 0; i < items.length; i++) {
            var item = items[i];
            var classes = item.className || '';
            var show = false;

            if (showAll) {
                show = true;
            } else {
                for (var j = 0; j < this.activeTerms.length; j++) {
                    var cls = 'acf-tfe-' + this.taxonomy + '-' + this.activeTerms[j];
                    if (classes.indexOf(cls) !== -1) {
                        show = true;
                        break;
                    }
                }
            }

            this._toggleItem(item, show);
            if (show) visibleCount++;
        }

        this._updateCount(visibleCount);
    };

    ACFTaxFilter.prototype._getCSSTarget = function () {
        if (!this.targetId) return null;
        
        // Elementor uses .elementor-element-{widget_id} for widgets
        var target = document.querySelector('.elementor-element-' + this.targetId);
        
        // Fallback: Check if user manually set it as a CSS ID (Mode 1 legacy compat)
        if (!target) {
            target = document.getElementById(this.targetId);
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
    ACFTaxFilter.prototype._toggleItem = function (item, show) {
        if (this.animation === 'fade') {
            if (show) {
                item.style.display = '';
                item.style.opacity = '0';
                item.style.transition = 'opacity 0.3s ease';
                requestAnimationFrame(function () {
                    item.style.opacity = '1';
                });
            } else {
                item.style.opacity = '0';
                item.style.transition = 'opacity 0.3s ease';
                setTimeout(function () {
                    item.style.display = 'none';
                }, 300);
            }
        } else if (this.animation === 'slide') {
            if (show) {
                item.style.display = '';
                item.style.transform = 'scale(0.95)';
                item.style.opacity = '0';
                item.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                requestAnimationFrame(function () {
                    item.style.transform = 'scale(1)';
                    item.style.opacity = '1';
                });
            } else {
                item.style.opacity = '0';
                item.style.transform = 'scale(0.95)';
                item.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                setTimeout(function () {
                    item.style.display = 'none';
                }, 300);
            }
        } else {
            // No animation
            item.style.display = show ? '' : 'none';
        }
    };

    ACFTaxFilter.prototype._updateCount = function (count) {
        if (!this.countEl) return;
        this.countEl.textContent = this.countTpl.replace('{count}', String(count));
        this.countEl.style.display = 'inline';
    };

    ACFTaxFilter.prototype._reset = function () {
        this.activeTerms = [];
        this._updateButtonUI();

        var checkboxes = this.el.querySelectorAll('input[type="checkbox"]');
        for (var i = 0; i < checkboxes.length; i++) checkboxes[i].checked = false;

        var radios = this.el.querySelectorAll('input[type="radio"]');
        for (var i = 0; i < radios.length; i++) {
            radios[i].checked = !radios[i].getAttribute('data-term-slug');
        }

        var select = this.el.querySelector('select');
        if (select) select.selectedIndex = 0;

        this._filter();
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
            // Reset init flag to allow re-initialization (e.g., in Elementor editor)
            delete widgets[i].dataset.acfTfeInit;
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
