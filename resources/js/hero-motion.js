import { animate, scroll } from 'motion';

/**
 * Initialize Motion.dev scroll animations and entrance choreography.
 */
export function initHeroMotion() {
    const heroSection = document.querySelector('#hero-section');
    if (!heroSection) return;

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // 1. Initial Staggered Entrance Animations
    if (!prefersReducedMotion) {
        animate(
            '#hero-badge',
            { opacity: [0, 1], y: [-15, 0], scale: [0.96, 1] },
            { duration: 0.6, ease: [0.16, 1, 0.3, 1] }
        );

        animate(
            '#hero-headline',
            { opacity: [0, 1], y: [24, 0] },
            { duration: 0.8, delay: 0.15, ease: [0.16, 1, 0.3, 1] }
        );

        animate(
            '#hero-subheadline',
            { opacity: [0, 1], y: [20, 0] },
            { duration: 0.8, delay: 0.28, ease: [0.16, 1, 0.3, 1] }
        );

        animate(
            '#hero-ctas',
            { opacity: [0, 1], y: [16, 0] },
            { duration: 0.7, delay: 0.4, ease: [0.16, 1, 0.3, 1] }
        );

        animate(
            '#hero-mockup-card',
            { opacity: [0, 1], y: [50, 0] },
            { duration: 1.1, delay: 0.5, ease: [0.16, 1, 0.3, 1] }
        );

        animate(
            '.floating-badge',
            { opacity: [0, 1], scale: [0.8, 1] },
            { duration: 0.8, delay: 0.75, ease: [0.16, 1, 0.3, 1] }
        );
    } else {
        // Fallback for reduced motion: ensure visibility immediately
        const elements = ['#hero-badge', '#hero-headline', '#hero-subheadline', '#hero-ctas', '#hero-mockup-card', '.floating-badge'];
        elements.forEach((selector) => {
            const el = document.querySelector(selector);
            if (el) {
                el.style.opacity = '1';
                el.style.transform = 'none';
            }
        });
    }

    // 2. Scroll-driven Progress Indicator
    const progressBar = document.querySelector('#scroll-progress-bar');
    if (progressBar) {
        scroll((progress) => {
            progressBar.style.transform = `scaleX(${progress})`;
        });
    }

    // 3. Scroll-driven 3D Perspective Tilt on the Mockup Card
    const mockupCard = document.querySelector('#hero-mockup-card');
    if (mockupCard && !prefersReducedMotion) {
        scroll(
            (progress) => {
                // Starts at perspective 1200px rotateX(18deg) scale(0.93)
                // Flattens to rotateX(0deg) scale(1) as user scrolls down into it
                const normalized = Math.min(1, Math.max(0, progress * 2.2));
                const rotateX = 18 * (1 - normalized);
                const scale = 0.93 + (0.07 * normalized);
                const translateY = -25 * normalized;
                mockupCard.style.transform = `perspective(1200px) rotateX(${rotateX.toFixed(2)}deg) scale(${scale.toFixed(3)}) translateY(${translateY.toFixed(1)}px)`;
            },
            {
                target: heroSection,
                offset: ['start start', 'end start']
            }
        );
    }

    // 4. Scroll-driven Ambient Glow Dynamic Shift
    const ambientGlow = document.querySelector('#ambient-glow-mesh');
    if (ambientGlow && !prefersReducedMotion) {
        scroll(
            (progress) => {
                const opacity = Math.max(0.15, 0.65 - (progress * 0.5));
                const scale = 1 + (progress * 0.25);
                ambientGlow.style.opacity = `${opacity.toFixed(2)}`;
                ambientGlow.style.transform = `translate(-50%, -50%) scale(${scale.toFixed(2)})`;
            },
            {
                target: heroSection,
                offset: ['start start', 'end start']
            }
        );
    }

    // 5. Parallax Floating Elements
    const floaters = document.querySelectorAll('[data-parallax-depth]');
    if (floaters.length > 0 && !prefersReducedMotion) {
        scroll(
            (progress) => {
                floaters.forEach((floater) => {
                    const depth = parseFloat(floater.getAttribute('data-parallax-depth') || '20');
                    const offset = progress * depth * 3.5;
                    floater.style.transform = `translateY(${-offset.toFixed(1)}px)`;
                });
            },
            {
                target: heroSection,
                offset: ['start start', 'end start']
            }
        );
    }
}

// Auto-run if DOM is already ready, or on DOMContentLoaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initHeroMotion);
} else {
    initHeroMotion();
}
