import Alpine from 'alpinejs';
import './hotel-motion.js';

export function createHeroSlider() {
    return {
        active: 0,
        total: 4,
        duration: 5000,
        progress: 0,
        progressId: null,
        touchStartX: 0,
        touchEndX: 0,

        init() {
            this.start();
        },
        start() {
            this.stop();
            this.progress = 0;
            const stepTime = 50;
            const increment = (stepTime / this.duration) * 100;
            this.progressId = setInterval(() => {
                this.progress += increment;
                if (this.progress >= 100) {
                    this.progress = 0;
                    this.next();
                }
            }, stepTime);
        },
        stop() {
            if (this.progressId) {
                clearInterval(this.progressId);
                this.progressId = null;
            }
        },
        goTo(index) {
            this.active = (index + this.total) % this.total;
            this.progress = 0;
        },
        next() {
            this.goTo(this.active + 1);
        },
        prev() {
            this.goTo(this.active - 1);
        },
        handleTouchStart(e) {
            if (e.changedTouches && e.changedTouches.length > 0) {
                this.touchStartX = e.changedTouches[0].screenX;
            }
        },
        handleTouchEnd(e) {
            if (e.changedTouches && e.changedTouches.length > 0) {
                this.touchEndX = e.changedTouches[0].screenX;
                const diff = this.touchStartX - this.touchEndX;
                if (Math.abs(diff) > 40) {
                    if (diff > 0) {
                        this.next();
                    } else {
                        this.prev();
                    }
                }
            }
        }
    };
}

export function createRotatingFleetCarousel(totalRooms = 18) {
    return {
        currentIndex: 0,
        total: totalRooms,
        isPaused: false,
        timer: null,
        intervalMs: 3600,
        canScrollPrev: false,
        canScrollNext: true,

        init() {
            this.startAutoRotate();
            this.$nextTick(() => {
                this.updateScrollState();
            });

            const track = this.$refs.sliderTrack;
            if (track) {
                track.addEventListener('scroll', () => {
                    this.updateScrollState();
                }, { passive: true });
            }
        },

        getStep() {
            const track = this.$refs.sliderTrack;
            if (!track || !track.children || track.children.length === 0) return 340;
            const firstCard = track.children[0];
            const style = window.getComputedStyle(track);
            const gap = parseFloat(style.columnGap || style.gap || '24') || 24;
            return firstCard.offsetWidth + gap;
        },

        updateScrollState() {
            const track = this.$refs.sliderTrack;
            if (!track) return;
            const scrollLeft = track.scrollLeft;
            const maxScroll = track.scrollWidth - track.clientWidth;
            this.canScrollPrev = scrollLeft > 15;
            this.canScrollNext = scrollLeft < maxScroll - 15;

            const step = this.getStep();
            if (step > 0) {
                this.currentIndex = Math.min(
                    this.total - 1,
                    Math.max(0, Math.round(scrollLeft / step))
                );
            }
        },

        startAutoRotate() {
            this.stopAutoRotate();
            this.timer = setInterval(() => {
                if (!this.isPaused) {
                    this.next();
                }
            }, this.intervalMs);
        },

        stopAutoRotate() {
            if (this.timer) {
                clearInterval(this.timer);
                this.timer = null;
            }
        },

        pause() {
            this.isPaused = true;
        },

        resume() {
            this.isPaused = false;
        },

        toggleAutoRotate() {
            this.isPaused = !this.isPaused;
        },

        next() {
            const track = this.$refs.sliderTrack;
            if (!track) return;
            const maxScroll = track.scrollWidth - track.clientWidth;
            const step = this.getStep();

            if (track.scrollLeft >= maxScroll - 20) {
                // Smooth infinite loop back to beginning
                track.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                track.scrollBy({ left: step, behavior: 'smooth' });
            }
        },

        prev() {
            const track = this.$refs.sliderTrack;
            if (!track) return;
            const maxScroll = track.scrollWidth - track.clientWidth;
            const step = this.getStep();

            if (track.scrollLeft <= 20) {
                // Loop to end
                track.scrollTo({ left: maxScroll, behavior: 'smooth' });
            } else {
                track.scrollBy({ left: -step, behavior: 'smooth' });
            }
        },

        goTo(index) {
            const track = this.$refs.sliderTrack;
            if (!track) return;
            const step = this.getStep();
            track.scrollTo({ left: index * step, behavior: 'smooth' });
        }
    };
}

window.heroSlider = createHeroSlider;
window.rotatingFleetCarousel = createRotatingFleetCarousel;
window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.data('heroSlider', createHeroSlider);
    Alpine.data('rotatingFleetCarousel', createRotatingFleetCarousel);
});

Alpine.data('heroSlider', createHeroSlider);
Alpine.data('rotatingFleetCarousel', createRotatingFleetCarousel);
Alpine.start();



