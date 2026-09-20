import { animate, scroll, inView, stagger } from 'motion';
import Lenis from 'lenis';

/**
 * Studenterkilden-Style High-End Page Scrolling Animations & Smooth Inertial Scroll
 * For Serenity Villa Luxury Boutique Hotel System
 */

export let lenis = null;

/**
 * 1. Initialize Lenis Smooth Inertial Scrolling with Danish boutique weighted momentum
 */
export function initSmoothScroll() {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReducedMotion) return;

    try {
        lenis = new Lenis({
            duration: 1.25,
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
            orientation: 'vertical',
            gestureOrientation: 'vertical',
            smoothWheel: true,
            wheelMultiplier: 1.15,
            touchMultiplier: 1.5,
        });

        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }
        requestAnimationFrame(raf);

        // Smooth Scroll on Anchor Click with Navbar Offset
        document.querySelectorAll('a[href*="#"]').forEach((anchor) => {
            anchor.addEventListener('click', (e) => {
                const href = anchor.getAttribute('href');
                if (href) {
                    const hashIndex = href.indexOf('#');
                    if (hashIndex !== -1) {
                        const targetHash = href.substring(hashIndex);
                        if (targetHash && targetHash.length > 1) {
                            const targetEl = document.querySelector(targetHash);
                            if (targetEl) {
                                e.preventDefault();
                                lenis.scrollTo(targetEl, {
                                    offset: -85, // Header height offset
                                    duration: 1.3,
                                });
                            }
                        }
                    }
                }
            });
        });
    } catch (err) {
        console.warn('[SmoothScroll] Lenis initialization fallback', err);
    }
}

/**
 * 2. Studenterkilden-style Smart Auto-Hiding Navbar (initNavHide)
 * Glides offscreen on scroll down, reappears immediately on scroll up, always visible at top.
 */
export function initNavHide() {
    const nav = document.querySelector('[data-nav]');
    if (!nav) return;

    let lastScrollY = window.scrollY || 0;
    let isHidden = false;
    const scrollThreshold = 8; // Minimum movement before triggering state change

    const handleScroll = (currentScroll) => {
        const delta = currentScroll - lastScrollY;

        if (currentScroll <= 20) {
            // At the very top of page: always reveal
            if (isHidden) {
                nav.style.transform = 'translateY(0)';
                isHidden = false;
            }
        } else if (delta > scrollThreshold && currentScroll > 90) {
            // Scrolling down past threshold: glide up out of view
            if (!isHidden) {
                nav.style.transform = 'translateY(-100%)';
                isHidden = true;
            }
        } else if (delta < -scrollThreshold) {
            // Scrolling up: reveal navbar
            if (isHidden) {
                nav.style.transform = 'translateY(0)';
                isHidden = false;
            }
        }

        lastScrollY = currentScroll;
    };

    if (lenis) {
        lenis.on('scroll', ({ scroll }) => {
            handleScroll(scroll);
        });
    } else {
        window.addEventListener('scroll', () => {
            handleScroll(window.scrollY);
        }, { passive: true });
    }
}

/**
 * 3. Studenterkilden Continuous Image Parallax Scrubbing (initImageParallax)
 * Subtly shifts photos inside overflow-hidden card wrappers as the user scrolls.
 */
export function initImageParallax() {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReducedMotion) return;

    const parallaxWrappers = document.querySelectorAll('.parallax-img-wrapper');
    parallaxWrappers.forEach((wrapper) => {
        const container = wrapper.parentElement;
        if (!container) return;

        scroll(
            (progress) => {
                // progress goes from 0 (start entering viewport) to 1 (leaving viewport)
                // Parallax shift from -18px to +18px
                const yShift = (progress - 0.5) * 36;
                wrapper.style.transform = `translate3d(0, ${yShift.toFixed(2)}px, 0)`;
            },
            {
                target: container,
                offset: ['start end', 'end start']
            }
        );
    });
}

/**
 * 4. Staggered Content & Section Typography Reveals (initSectionReveals)
 * Cascades eyebrows, Playfair Display serif headings, descriptions, and cards.
 */
export function initSectionReveals() {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReducedMotion) {
        document.querySelectorAll('.room-type-card, .fleet-room-card, .amenity-card, #search-widget, #cta-banner, .section-reveal-header').forEach((el) => {
            el.style.opacity = '1';
            el.style.transform = 'none';
        });
        return;
    }

    // Editorial Section Headers (Eyebrow -> Title -> Description cascade)
    const headers = document.querySelectorAll('.section-reveal-header');
    headers.forEach((header) => {
        inView(
            header,
            () => {
                const eyebrow = header.querySelector('.section-eyebrow');
                const title = header.querySelector('.section-title');
                const desc = header.querySelector('.section-desc');

                const elementsToAnimate = [eyebrow, title, desc].filter(Boolean);
                if (elementsToAnimate.length > 0) {
                    const anim = animate(
                        elementsToAnimate,
                        { opacity: [0, 1], y: [22, 0] },
                        { delay: stagger(0.12), duration: 0.75, ease: [0.16, 1, 0.3, 1] }
                    );
                    if (anim && anim.finished) {
                        anim.finished.then(() => {
                            elementsToAnimate.forEach((el) => { el.style.transform = ''; });
                        });
                    }
                }
            },
            { margin: '-50px 0px' }
        );
    });

    // Top Search & Booking Filter Widget Reveal
    const searchWidget = document.querySelector('#search-widget');
    if (searchWidget) {
        inView(
            searchWidget,
            (info) => {
                const anim = animate(
                    info.target,
                    { opacity: [0, 1], y: [35, 0], scale: [0.98, 1] },
                    { duration: 0.8, ease: [0.16, 1, 0.3, 1] }
                );
                if (anim && anim.finished) {
                    anim.finished.then(() => {
                        info.target.style.transform = '';
                    });
                }
            },
            { margin: '-50px 0px' }
        );
    }

    // Featured Accommodations Cards - Staggered Scroll In-View Reveal
    const accommodationsSection = document.querySelector('#accommodations-section');
    const roomCards = document.querySelectorAll('.room-type-card');
    if (accommodationsSection && roomCards.length > 0) {
        inView(
            accommodationsSection,
            () => {
                const anim = animate(
                    roomCards,
                    { opacity: [0, 1], y: [42, 0], scale: [0.97, 1] },
                    { delay: stagger(0.12), duration: 0.75, ease: [0.16, 1, 0.3, 1] }
                );
                if (anim && anim.finished) {
                    anim.finished.then(() => {
                        roomCards.forEach((c) => { c.style.transform = ''; });
                    });
                }
            },
            { margin: '-60px 0px' }
        );
    }

    // Individual Rooms Fleet Grid - Staggered Scroll In-View Reveal
    const fleetSection = document.querySelector('#fleet-section');
    const fleetCards = document.querySelectorAll('.fleet-room-card');
    if (fleetSection && fleetCards.length > 0) {
        inView(
            fleetSection,
            () => {
                const anim = animate(
                    fleetCards,
                    { opacity: [0, 1], y: [36, 0], scale: [0.97, 1] },
                    { delay: stagger(0.06), duration: 0.65, ease: [0.16, 1, 0.3, 1] }
                );
                if (anim && anim.finished) {
                    anim.finished.then(() => {
                        fleetCards.forEach((c) => { c.style.transform = ''; });
                    });
                }
            },
            { margin: '-50px 0px' }
        );
    }

    // Amenities Section - Staggered Scroll In-View Reveal
    const amenitiesSection = document.querySelector('#amenities');
    const amenityCards = document.querySelectorAll('.amenity-card');
    if (amenitiesSection && amenityCards.length > 0) {
        inView(
            amenitiesSection,
            () => {
                const anim = animate(
                    amenityCards,
                    { opacity: [0, 1], y: [35, 0], scale: [0.97, 1] },
                    { delay: stagger(0.08), duration: 0.7, ease: [0.16, 1, 0.3, 1] }
                );
                if (anim && anim.finished) {
                    anim.finished.then(() => {
                        amenityCards.forEach((c) => { c.style.transform = ''; });
                    });
                }
            },
            { margin: '-60px 0px' }
        );
    }

    // Call to Action Banner Scroll In-View Reveal
    const ctaBanner = document.querySelector('#cta-banner');
    if (ctaBanner) {
        inView(
            ctaBanner,
            (info) => {
                const anim = animate(
                    info.target,
                    { opacity: [0, 1], y: [35, 0], scale: [0.98, 1] },
                    { duration: 0.8, ease: [0.16, 1, 0.3, 1] }
                );
                if (anim && anim.finished) {
                    anim.finished.then(() => {
                        info.target.style.transform = '';
                    });
                }
            },
            { margin: '-50px 0px' }
        );
    }
}

/**
 * 5. Studenterkilden Footer Curtain Parallax Reveal (initFooterParallax)
 * Gives the footer content an elevated parallax curtain reveal as it enters viewport.
 */
export function initFooterParallax() {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReducedMotion) return;

    const footer = document.querySelector('[data-footer]');
    const footerInner = document.querySelector('[data-footer-inner]');
    if (!footer || !footerInner) return;

    scroll(
        (progress) => {
            // progress goes from 0 (footer top reaches viewport bottom) to 1 (footer bottom reached)
            const yShift = (1 - progress) * -22;
            const opacity = 0.88 + progress * 0.12;
            footerInner.style.transform = `translate3d(0, ${yShift.toFixed(2)}px, 0)`;
            footerInner.style.opacity = `${opacity.toFixed(3)}`;
        },
        {
            target: footer,
            offset: ['start end', 'end end']
        }
    );
}

/**
 * 6. Top Page Scroll Progress Bar
 */
export function initProgressBar() {
    const progressBar = document.querySelector('#scroll-progress-bar');
    if (progressBar) {
        scroll((progress) => {
            progressBar.style.transform = `scaleX(${progress})`;
        });
    }
}

/**
 * 7. Hero Section Entrance and Parallax Depth
 */
export function initHeroParallax() {
    const heroSection = document.querySelector('#hotel-hero');
    const heroBg = document.querySelector('#hero-parallax-bg');
    const heroContent = document.querySelector('#hero-content-wrapper');

    if (heroSection) {
        // Initial entrance on load
        if (heroContent) {
            animate(heroContent, { opacity: [0, 1], y: [20, 0] }, { duration: 0.85, ease: [0.16, 1, 0.3, 1] });
        }

        // Scroll parallax on hero background container
        if (heroBg) {
            scroll(
                (progress) => {
                    heroBg.style.transform = `scale(${1 + progress * 0.12}) translateY(${progress * 70}px)`;
                    if (heroContent) {
                        heroContent.style.opacity = `${Math.max(0, 1 - progress * 1.4)}`;
                        heroContent.style.transform = `translateY(${progress * 45}px)`;
                    }
                },
                {
                    target: heroSection,
                    offset: ['start start', 'end start']
                }
            );
        }
    }
}

/**
 * Master Initialization
 */
function start() {
    initSmoothScroll();
    initNavHide();
    initProgressBar();
    initHeroParallax();
    initSectionReveals();
    initImageParallax();
    initFooterParallax();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', start);
} else {
    start();
}
