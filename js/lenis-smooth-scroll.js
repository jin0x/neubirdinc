/**
 * Lenis Smooth Scroll Initialization
 * Provides smooth scrolling throughout the site
 */
(function() {
    'use strict';

    let lenis = null;
    let rafId = null;
    let resizeTimeout = null;
    let mutationObserver = null;
    let resizeObserver = null;

    // Debounced resize function
    function debounceResize() {
        if (resizeTimeout) {
            clearTimeout(resizeTimeout);
        }
        resizeTimeout = setTimeout(function() {
            if (lenis) {
                lenis.resize();
            }
        }, 150);
    }

    // Wait for DOM to be ready and ensure all content is loaded
    function initLenis() {
        // Check if Lenis is available
        if (typeof Lenis === 'undefined') {
            console.warn('Lenis library not loaded');
            return;
        }

        // Clean up existing instance if any
        if (lenis) {
            lenis.destroy();
            lenis = null;
        }
        if (rafId) {
            cancelAnimationFrame(rafId);
            rafId = null;
        }

        // Initialize Lenis
        lenis = new Lenis({
            duration: 1.2,
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
            orientation: 'vertical',
            gestureOrientation: 'vertical',
            smoothWheel: true,
            wheelMultiplier: 1,
            smoothTouch: false,
            touchMultiplier: 2,
            infinite: false,
        });

        // Get scroll function
        function raf(time) {
            lenis.raf(time);
            rafId = requestAnimationFrame(raf);
        }

        rafId = requestAnimationFrame(raf);

        // Handle anchor links
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a[href^="#"]');
            
            if (link) {
                const href = link.getAttribute('href');
                
                // Skip empty hash or just #
                if (href === '#' || href === '') {
                    return;
                }

                // Get target element
                const targetId = href.substring(1);
                const targetElement = document.getElementById(targetId) || document.querySelector(`[data-anchor-id="${targetId}"]`);

                if (targetElement) {
                    e.preventDefault();
                    
                    // Calculate offset for fixed header (adjust as needed)
                    const headerOffset = 80;
                    const elementPosition = targetElement.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    // Scroll to target
                    lenis.scrollTo(offsetPosition, {
                        duration: 1.2,
                        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
                        offset: -headerOffset
                    });

                    // Update URL hash without triggering scroll
                    if (history.pushState) {
                        history.pushState(null, null, href);
                    }
                }
            }
        });

        // Handle hash on page load
        if (window.location.hash) {
            const hash = window.location.hash.substring(1);
            const targetElement = document.getElementById(hash) || document.querySelector(`[data-anchor-id="${hash}"]`);
            
            if (targetElement) {
                setTimeout(function() {
                    const headerOffset = 80;
                    lenis.scrollTo(targetElement, {
                        duration: 1.2,
                        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
                        offset: -headerOffset
                    });
                }, 100);
            }
        }

        // Expose lenis instance globally for advanced usage
        window.lenis = lenis;

        // Set up MutationObserver to watch for DOM changes
        if (mutationObserver) {
            mutationObserver.disconnect();
        }
        mutationObserver = new MutationObserver(function(mutations) {
            let shouldResize = false;
            mutations.forEach(function(mutation) {
                // Check if content was added, removed, or attributes changed
                if (mutation.type === 'childList' || 
                    (mutation.type === 'attributes' && 
                     (mutation.attributeName === 'style' || mutation.attributeName === 'class'))) {
                    shouldResize = true;
                }
            });
            if (shouldResize) {
                debounceResize();
            }
        });

        // Observe the entire document body for changes
        mutationObserver.observe(document.body, {
            childList: true,
            subtree: true,
            attributes: true,
            attributeFilter: ['style', 'class']
        });

        // Set up ResizeObserver to watch for size changes
        if (resizeObserver) {
            resizeObserver.disconnect();
        }
        resizeObserver = new ResizeObserver(function(entries) {
            debounceResize();
        });

        // Observe body and main content areas
        if (document.body) {
            resizeObserver.observe(document.body);
        }
        const mainContent = document.querySelector('main, .content-area, .container');
        if (mainContent) {
            resizeObserver.observe(mainContent);
        }

        // Handle window resize
        window.addEventListener('resize', debounceResize);

        // Handle page load completion
        window.addEventListener('load', function() {
            setTimeout(function() {
                lenis.resize();
                // Ensure FAQ blocks and other dynamic content are visible
                const faqBlocks = document.querySelectorAll('.faq-block');
                faqBlocks.forEach(function(block) {
                    block.style.visibility = 'visible';
                    block.style.opacity = '1';
                });
            }, 200);
        });

        // Handle browser back/forward navigation
        window.addEventListener('popstate', function() {
            setTimeout(function() {
                lenis.resize();
            }, 100);
        });

        // Handle page load from cache (bfcache)
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                // Page was loaded from cache
                setTimeout(function() {
                    lenis.resize();
                }, 100);
            }
        });

        // Ensure all content blocks are visible after Lenis initialization
        setTimeout(function() {
            // Update Lenis scroll height to account for all content
            lenis.resize();
            
            // Ensure FAQ blocks and other dynamic content are visible
            const faqBlocks = document.querySelectorAll('.faq-block');
            faqBlocks.forEach(function(block) {
                block.style.visibility = 'visible';
                block.style.opacity = '1';
            });
        }, 100);

        // Additional resize after a longer delay to catch lazy-loaded content
        setTimeout(function() {
            lenis.resize();
        }, 500);

        // Final resize after images and all content should be loaded
        setTimeout(function() {
            lenis.resize();
        }, 1000);

        // Watch for images loading and resize when they complete
        const images = document.querySelectorAll('img');
        let imagesLoaded = 0;
        const totalImages = images.length;
        
        if (totalImages > 0) {
            images.forEach(function(img) {
                if (img.complete) {
                    imagesLoaded++;
                } else {
                    img.addEventListener('load', function() {
                        imagesLoaded++;
                        if (imagesLoaded === totalImages) {
                            debounceResize();
                        }
                    });
                    img.addEventListener('error', function() {
                        imagesLoaded++;
                        if (imagesLoaded === totalImages) {
                            debounceResize();
                        }
                    });
                }
            });
            
            if (imagesLoaded === totalImages) {
                debounceResize();
            }
        }
    }

    // Wait for DOM to be ready and ensure all scripts are loaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            // Small delay to ensure all content blocks are rendered
            setTimeout(initLenis, 50);
        });
    } else {
        // DOM already ready, but wait a bit for dynamic content
        setTimeout(initLenis, 50);
    }

    // Reinitialize on page show (when coming back from another page)
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden && lenis) {
            setTimeout(function() {
                lenis.resize();
            }, 100);
        }
    });

    // Clean up on page unload
    window.addEventListener('beforeunload', function() {
        if (mutationObserver) {
            mutationObserver.disconnect();
        }
        if (resizeObserver) {
            resizeObserver.disconnect();
        }
        if (lenis) {
            lenis.destroy();
        }
        if (rafId) {
            cancelAnimationFrame(rafId);
        }
    });
})();

