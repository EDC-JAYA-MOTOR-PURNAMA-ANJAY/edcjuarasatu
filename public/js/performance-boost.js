// ⚡ PERFORMANCE BOOST - Fast Loading & Smooth Navigation

(function() {
    'use strict';

    // 1. PAGE LOADER - UPGRADED WITH LOGO ANIMATION!
    function initPageLoader() {
        // Animation styles: 'pulse-glow', 'path-draw', 'rotate-3d'
        const animationStyle = 'pulse-glow'; // Change this to try different animations!
        
        // Create loader overlay with logo
        const loader = document.createElement('div');
        loader.className = 'page-loader';
        loader.innerHTML = `
            <div class="loader-logo-container">
                <img src="/images/EDClogo.svg" alt="EduCounsel Logo" class="loader-logo ${animationStyle}">
            </div>
            <div class="loader-text">Loading...</div>
            <div class="loader-bar">
                <div class="loader-bar-fill"></div>
            </div>
        `;
        document.body.appendChild(loader);

        // Hide loader when page fully loaded
        window.addEventListener('load', function() {
            setTimeout(() => {
                loader.classList.add('hidden');
                // Remove after transition
                setTimeout(() => loader.remove(), 500);
            }, 300);
        });

        // Show loader on navigation
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a[href]');
            if (link && !link.hasAttribute('target') && !link.href.includes('#')) {
                const newLoader = document.createElement('div');
                newLoader.className = 'page-loader';
                newLoader.innerHTML = `
                    <div class="loader-logo-container">
                        <img src="/images/EDClogo.svg" alt="EduCounsel Logo" class="loader-logo ${animationStyle}">
                    </div>
                    <div class="loader-text">Loading...</div>
                    <div class="loader-bar">
                        <div class="loader-bar-fill"></div>
                    </div>
                `;
                document.body.appendChild(newLoader);
            }
        });
    }

    // 2. SMOOTH PAGE TRANSITION
    function initPageTransition() {
        const main = document.querySelector('main') || document.querySelector('.container');
        if (main) {
            main.classList.add('page-transition');
        }
    }

    // 3. LAZY LOAD IMAGES
    function initLazyImages() {
        if ('loading' in HTMLImageElement.prototype) {
            // Native lazy loading support
            const images = document.querySelectorAll('img[loading="lazy"]');
            images.forEach(img => {
                img.addEventListener('load', function() {
                    this.classList.add('loaded');
                });
            });
        } else {
            // Fallback: Intersection Observer
            const images = document.querySelectorAll('img[data-src]');
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.add('loaded');
                        observer.unobserve(img);
                    }
                });
            });
            images.forEach(img => imageObserver.observe(img));
        }
    }

    // 4. PREFETCH LINKS (preload on hover)
    function initLinkPrefetch() {
        const links = document.querySelectorAll('a[href^="/"]');
        const prefetched = new Set();

        links.forEach(link => {
            link.addEventListener('mouseenter', function() {
                const href = this.getAttribute('href');
                if (href && !prefetched.has(href)) {
                    const prefetchLink = document.createElement('link');
                    prefetchLink.rel = 'prefetch';
                    prefetchLink.href = href;
                    document.head.appendChild(prefetchLink);
                    prefetched.add(href);
                }
            }, { once: true });
        });
    }

    // 5. DEFER VOICE SCRIPT (tidak block rendering)
    function deferVoiceInit() {
        // Voice script akan di-defer, jadi tidak block page load
        // Ini sudah handled di HTML dengan defer attribute
    }

    // 6. OPTIMIZE FORM SUBMISSIONS
    function optimizeForms() {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                // Add loading state to submit button
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<span class="loader-spinner" style="width:16px;height:16px;border-width:2px;margin:0 auto;"></span>';
                    
                    // Restore after 5s if no redirect
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }, 5000);
                }
            });
        });
    }

    // 7. SMOOTH SCROLL untuk anchor links
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href && href !== '#') {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }
            });
        });
    }

    // 8. DEBOUNCE untuk event yang sering fire
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // 9. OPTIMIZE SEARCH/FILTER
    function optimizeSearch() {
        const searchInputs = document.querySelectorAll('input[type="search"], input[name="search"]');
        searchInputs.forEach(input => {
            input.addEventListener('input', debounce(function(e) {
                // Search logic here (already debounced)
            }, 300));
        });
    }

    // 10. MONITOR PERFORMANCE
    function monitorPerformance() {
        if ('performance' in window) {
            window.addEventListener('load', function() {
                setTimeout(() => {
                    const perfData = performance.getEntriesByType('navigation')[0];
                    if (perfData) {
                        console.log('⚡ Performance Stats:');
                        console.log('  - DOM Content Loaded:', Math.round(perfData.domContentLoadedEventEnd - perfData.domContentLoadedEventStart), 'ms');
                        console.log('  - Page Load Time:', Math.round(perfData.loadEventEnd - perfData.loadEventStart), 'ms');
                        console.log('  - Total Time:', Math.round(perfData.duration), 'ms');
                    }
                }, 0);
            });
        }
    }

    // INITIALIZE ALL
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    function init() {
        initPageLoader();
        initPageTransition();
        initLazyImages();
        initLinkPrefetch();
        optimizeForms();
        initSmoothScroll();
        optimizeSearch();
        monitorPerformance();
        
        console.log('⚡ Performance Boost: ACTIVE');
    }
})();
