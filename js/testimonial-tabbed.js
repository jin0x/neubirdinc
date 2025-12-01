/**
 * Tabbed Testimonials JavaScript
 * Handles tab switching and auto-rotation functionality
 */

(function($) {
    'use strict';

    let testimonialInterval;
    let isUserInteracting = false;
    let currentIndex = 0;
    let totalTabs = 0;
    // Keep scoped references to the currently initialized section's tabs/panels
    let $tabs = $();
    let $panels = $();
    const ROTATION_MS = 4000; // 4 seconds per tab

    function initTabbedTestimonials() {
        const $testimonialSection = $('.testimonials-tabbed');
        
        if (!$testimonialSection.length) {
            return;
        }
        // Scope to the testimonial section to avoid collisions
        $tabs = $testimonialSection.find('.testimonial-tab');
        $panels = $testimonialSection.find('.testimonial-panel');
        
        totalTabs = $tabs.length;
        
        if (totalTabs <= 1) {
            return;
        }

        // Accessibility roles
        const $tabList = $tabs.parent();
        $tabList.attr('role', 'tablist');
        $tabs.attr('role', 'tab');

        // Handle tab clicks (namespace to prevent duplicate bindings on re-init)
        $tabs.off('click.testimonial').on('click.testimonial', function(e) {
            e.preventDefault();
            
            let tabIndex = $(this).data('testimonial');
            if (tabIndex === undefined) {
                tabIndex = $(this).index();
            }
            switchToTab(tabIndex, true);
            
            // Visual feedback
            $(this).addClass('clicked');
            setTimeout(() => $(this).removeClass('clicked'), 150);
            
            // Pause and resume after a full interval
            pauseAutoRotation();
            setTimeout(function() {
                startAutoRotation();
            }, ROTATION_MS);
        });

        // Keyboard navigation
        $tabs.off('keydown.testimonial').on('keydown.testimonial', function(e) {
            const key = e.key;
            if (key === 'ArrowRight' || key === 'ArrowLeft') {
                e.preventDefault();
                const idx = $(this).index();
                let next = key === 'ArrowRight' ? (idx + 1) % totalTabs : (idx - 1 + totalTabs) % totalTabs;
                $tabs.eq(next).focus();
                switchToTab(next, true);
                pauseAutoRotation();
                setTimeout(startAutoRotation, ROTATION_MS);
            } else if (key === 'Enter' || key === ' ') {
                e.preventDefault();
                $(this).trigger('click');
            }
        });

        // Note: Removed hover pause functionality to allow continuous auto-scrolling
        // Users can still click tabs to navigate manually

        // Start auto-rotation
        startAutoRotation();
    }

    function switchToTab(index, userInitiated = false) {
        
        // Normalize index bounds
        index = Math.max(0, Math.min(index, totalTabs - 1));
        
        // Update current index
        currentIndex = index;
        
        // Remove active classes
        $tabs.removeClass('active auto-rotating');
        $panels.removeClass('active');
        $tabs.attr('aria-selected', 'false');
        
        // Add active classes to current tab and panel
        const $activeTab = $tabs.eq(index).addClass('active');
        $activeTab.attr('aria-selected', 'true');
        $panels.eq(index).addClass('active');
    }

    function startAutoRotation() {
        if (totalTabs <= 1) return;
        
        clearInterval(testimonialInterval);
        
        testimonialInterval = setInterval(function() {
            // Add rotation indicator to current tab
            const $active = $('.testimonial-tab.active');
            $active.addClass('auto-rotating');
            
            // Move to next tab
            currentIndex = (currentIndex + 1) % totalTabs;
            switchToTab(currentIndex);
        }, ROTATION_MS); // 4 seconds
    }

    function pauseAutoRotation() {
        clearInterval(testimonialInterval);
        $('.testimonial-tab').removeClass('auto-rotating');
    }

    // Initialize when document is ready
    $(document).ready(function() {
        initTabbedTestimonials();
    });

    // Re-initialize on window resize (for responsive behavior)
    $(window).on('resize', function() {
        clearTimeout(window.testimonialResizeTimer);
        window.testimonialResizeTimer = setTimeout(function() {
            // Re-initialize if needed
            initTabbedTestimonials();
        }, 250);
    });

    // Handle visibility change (pause when tab is not visible)
    $(document).on('visibilitychange', function() {
        if (document.hidden) {
            pauseAutoRotation();
        } else {
            startAutoRotation();
        }
    });

})(jQuery);