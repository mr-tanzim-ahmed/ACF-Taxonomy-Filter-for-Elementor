/**
 * ACF Taxonomy Filter for Elementor - Admin JS
 * Populates the 'target_id' select control with all Loop Grids on the current page.
 */
jQuery(window).on('elementor:init', function() {
    'use strict';

    if ( typeof elementor === 'undefined' || ! elementor.hooks ) {
        return;
    }

    elementor.hooks.addAction('panel/open_editor/widget/acf_taxonomy_filter', function(panel, model, view) {
        var loopGrids = {};
        
        // Helper to recursively find Loop Grids in the Elementor data models
        function findLoopGrids(elements) {
            if ( ! elements ) return;
            elements.forEach(function(el) {
                if ( el.get('widgetType') === 'loop-grid' ) {
                    var title = el.getSetting('_title') || 'Loop Grid';
                    loopGrids[el.get('id')] = title + ' (' + el.get('id') + ')';
                }
                
                // Recursively check children (columns, sections, containers)
                var childElements = el.get('elements');
                if ( childElements && childElements.models ) {
                    findLoopGrids(childElements.models);
                }
            });
        }
        
        // Start scanning from the root
        if ( elementor.elements && elementor.elements.models ) {
            findLoopGrids(elementor.elements.models);
        }
        
        // Find the 'target_id' control in the panel
        var controlView = panel.getControlView('target_id');
        
        if ( controlView ) {
            // Build the new options object preserving the empty default option
            var newOptions = {
                '': '— Select a Loop Grid —'
            };
            
            Object.assign(newOptions, loopGrids);
            
            // Update the control model and re-render
            controlView.model.set('options', newOptions);
            controlView.render();
        }
    });
});
