/**
 * ACF Taxonomy Filter for Elementor - Frontend JS
 * Version 1.0.2
 *
 * Supports two filtering engines:
 * 1. CSS Engine (instant) - Shows/hides items in an external Loop Grid by CSS class matching.
 * 2. AJAX Engine - Fetches filtered posts from the server and renders them via Elementor templates.
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
        this.engine     = el.getAttribute('data-engine') || 'css';

        // CSS mode
        this.targetId   = el.getAttribute('data-target-id') || '';

        // AJAX mode
        this.templateId = el.getAttribute('data-template-id') || '';
        this.ajaxUrl    = el.getAttribute('data-ajax-url') || '';
        this.nonce      = el.getAttribute('data-nonce') || '';

        this.activeTerms = [];
        this.resetBtn    = el.querySelector('.acf-tax-filter__reset');
        this.countEl     = el.querySelector('.acf-tax-filter__result-count');
        this.countTpl    = this.countEl ? (this.countEl.getAttribute('data-template') || '{count} results') : '';

        // AJAX debounce
        this._fetchTimer = null;
        this._abortCtrl  = null;

        this._bindEvents();
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
    // MAIN FILTER DISPATCH
    // =====================================================
    ACFTaxFilter.prototype._filter = function () {
        // Update reset button visibility
        if (this.resetBtn) {
            this.resetBtn.style.display = this.activeTerms.length === 0 ? 'none' : 'inline-block';
        }

        if (this.engine === 'ajax') {
            this._filterAjax();
        } else {
            this._filterCSS();
        }
    };

    // =====================================================
    // CSS ENGINE - Instant filtering of external Loop Grid
    // =====================================================
    ACFTaxFilter.prototype._filterCSS = function () {
        var target = this._getCSSTarget();
        if (!target) return;

        var items = this._getLoopItems(target);
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

        // Try by CSS ID first
        var target = document.getElementById(this.targetId);
        if (target) return target;

        // Fallback: Elementor data-id attribute
        target = document.querySelector('[data-id="' + this.targetId + '"]');
        if (target) return target;

        // Fallback: Elementor class
        target = document.querySelector('.elementor-element-' + this.targetId);
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
    // AJAX ENGINE - Server-side rendering
    // =====================================================
    ACFTaxFilter.prototype._filterAjax = function () {
        var self = this;

        // Debounce
        if (this._fetchTimer) clearTimeout(this._fetchTimer);
        this._fetchTimer = setTimeout(function () {
            self._doAjaxFetch();
        }, 150);
    };

    ACFTaxFilter.prototype._doAjaxFetch = function () {
        var self = this;
        var gridEl = this.el.querySelector('.acf-tax-filter__loop-grid');
        if (!gridEl || !this.ajaxUrl || !this.templateId) return;

        // Abort previous request
        if (this._abortCtrl) {
            try { this._abortCtrl.abort(); } catch (e) { /* ignore */ }
        }
        this._abortCtrl = typeof AbortController !== 'undefined' ? new AbortController() : null;

        // Loading state
        gridEl.classList.add('acf-tax-filter-loading');
        gridEl.style.opacity = '0.5';
        gridEl.style.pointerEvents = 'none';
        gridEl.style.minHeight = '80px';

        var formData = new FormData();
        formData.append('action', 'acf_tfe_filter');
        formData.append('nonce', this.nonce);
        formData.append('taxonomy', this.taxonomy);
        formData.append('post_type', this.postType);
        formData.append('template_id', this.templateId);

        for (var i = 0; i < this.activeTerms.length; i++) {
            formData.append('terms[]', this.activeTerms[i]);
        }

        var fetchOpts = {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        };
        if (this._abortCtrl) {
            fetchOpts.signal = this._abortCtrl.signal;
        }

        fetch(this.ajaxUrl, fetchOpts)
            .then(function (res) {
                if (!res.ok) throw new Error('HTTP ' + res.status);
                return res.json();
            })
            .then(function (data) {
                gridEl.classList.remove('acf-tax-filter-loading');
                gridEl.style.opacity = '';
                gridEl.style.pointerEvents = '';
                gridEl.style.minHeight = '';

                if (data && data.success && data.data) {
                    gridEl.innerHTML = data.data.html || '';
                    self._updateCount(data.data.count || 0);

                    // Re-init Elementor widgets inside new content
                    if (typeof jQuery !== 'undefined' && typeof elementorFrontend !== 'undefined' && elementorFrontend.elementsHandler) {
                        jQuery(gridEl).find('.elementor-element').each(function () {
                            try {
                                elementorFrontend.elementsHandler.runReadyTrigger(jQuery(this));
                            } catch (e) { /* ignore */ }
                        });
                    }
                } else {
                    gridEl.innerHTML = '<p style="padding:20px;text-align:center;opacity:0.6;">No posts found.</p>';
                    self._updateCount(0);
                }
            })
            .catch(function (err) {
                if (err && err.name === 'AbortError') return;
                gridEl.classList.remove('acf-tax-filter-loading');
                gridEl.style.opacity = '';
                gridEl.style.pointerEvents = '';
                gridEl.style.minHeight = '';
            });
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
