(function () {
    'use strict';

    function initHeroSlider(hero) {
        const slides   = hero.querySelectorAll('.hs-slide');
        const contents = hero.querySelectorAll('.hs-content');
        const dots     = hero.querySelectorAll('.hs-dot');
        const speed    = parseInt(hero.dataset.speed, 10) || 5000;
        const total    = slides.length;

        if (total < 2) return;

        let current   = 0;
        let isPaused  = false;
        let elapsed   = 0;       // ms elapsed in current slide
        let lastTick  = null;    // timestamp of last RAF
        let rafId     = null;

        // Progress bar
        const bar = document.createElement('div');
        bar.className = 'hs-progress';
        bar.style.transition = 'none';
        bar.style.width = '0%';
        hero.appendChild(bar);

        function activate(index) {
            slides[current].classList.remove('hs-slide--active');
            contents[current].classList.remove('hs-content--active');
            if (dots[current]) dots[current].classList.remove('hs-dot--active');

            current = (index + total) % total;

            slides[current].classList.add('hs-slide--active');
            contents[current].classList.add('hs-content--active');
            if (dots[current]) dots[current].classList.add('hs-dot--active');

            elapsed  = 0;
            bar.style.width = '0%';
        }

        function tick(timestamp) {
            if (!lastTick) lastTick = timestamp;
            const delta = timestamp - lastTick;
            lastTick = timestamp;

            if (!isPaused) {
                elapsed += delta;
                const pct = Math.min((elapsed / speed) * 100, 100);
                bar.style.width = pct + '%';

                if (elapsed >= speed) {
                    activate(current + 1);
                }
            }

            rafId = requestAnimationFrame(tick);
        }

        // Arrows
        const prevBtn = hero.querySelector('.hs-arrow--prev');
        const nextBtn = hero.querySelector('.hs-arrow--next');
        if (prevBtn) prevBtn.addEventListener('click', function () { activate(current - 1); });
        if (nextBtn) nextBtn.addEventListener('click', function () { activate(current + 1); });

        // Dot clicks
        dots.forEach(function (dot) {
            dot.addEventListener('click', function () {
                activate(parseInt(dot.dataset.index, 10));
            });
        });

        // Hover does NOT pause the slider

        // Swipe
        let touchStartX = 0;
        hero.addEventListener('touchstart', function (e) {
            touchStartX = e.changedTouches[0].clientX;
        }, { passive: true });
        hero.addEventListener('touchend', function (e) {
            const diff = touchStartX - e.changedTouches[0].clientX;
            if (Math.abs(diff) > 50) activate(diff > 0 ? current + 1 : current - 1);
        }, { passive: true });

        // Start
        rafId = requestAnimationFrame(tick);
    }

    function init() {
        document.querySelectorAll('.hs-hero').forEach(initHeroSlider);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    if (window.elementorFrontend) {
        window.elementorFrontend.hooks.addAction('frontend/element_ready/hero_slider.default', function ($el) {
            initHeroSlider($el[0]);
        });
    }
})();
