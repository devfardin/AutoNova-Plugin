document.addEventListener("DOMContentLoaded", function () {

    gsap.registerPlugin(ScrollTrigger);

    const ease = "power3.out";
    const dur  = 0.8;

    // ── Helper: animate each element individually on enter ───────────────────
    function onEnter(selector, fromVars, toVars) {
        document.querySelectorAll(selector).forEach(function (el) {
            gsap.set(el, fromVars);
            gsap.to(el, {
                ...toVars,
                scrollTrigger: {
                    trigger: el,
                    start: "top 90%",
                    once: true,
                },
            });
        });
    }

    // ── Helper: animate a group together when parent enters ──────────────────
    function onEnterGroup(selector, triggerSelector, fromVars, toVars, stagger) {
        var trigger = document.querySelector(triggerSelector);
        var els     = document.querySelectorAll(selector);
        if (!trigger || !els.length) return;
        gsap.set(els, fromVars);
        gsap.to(els, {
            ...toVars,
            stagger: stagger || 0,
            scrollTrigger: {
                trigger: trigger,
                start: "top 88%",
                once: true,
            },
        });
    }

    // ── Utility classes (.fade-up / .fade-left / .fade-right / .scale-in) ────
    onEnter(".fade-up",    { opacity: 0, y: 60 },  { opacity: 1, y: 0,     duration: dur, ease });
    onEnter(".fade-left",  { opacity: 0, x: -60 }, { opacity: 1, x: 0,     duration: dur, ease });
    onEnter(".fade-right", { opacity: 0, x: 60 },  { opacity: 1, x: 0,     duration: dur, ease });
    onEnter(".scale-in",   { opacity: 0, scale: 0.88 }, { opacity: 1, scale: 1, duration: dur, ease });

    // ── Page Hero ─────────────────────────────────────────────────────────────
    if (document.querySelector(".header-content")) {
        var heroItems = [
            ".header-content .sub-heading-wrapper",
            ".header-content .title-description_wrapper",
            ".header-content .breadcrumb",
        ];
        heroItems.forEach(function (sel, i) {
            var el = document.querySelector(sel);
            if (!el) return;
            gsap.set(el, { opacity: 0, y: 30 });
            gsap.to(el, { opacity: 1, y: 0, duration: 0.7, ease, delay: 0.2 + i * 0.2 });
        });
    }

    // ── Feature Car Cards ─────────────────────────────────────────────────────
    onEnterGroup(
        ".feature-car__card",
        ".feature-cars__grid",
        { opacity: 0, y: 50 },
        { opacity: 1, y: 0, duration: 0.7, ease },
        0.12
    );

    // ── Team Member Cards ─────────────────────────────────────────────────────
    onEnterGroup(
        ".team-member__card",
        ".team-member__grid",
        { opacity: 0, y: 50 },
        { opacity: 1, y: 0, duration: 0.7, ease },
        0.12
    );

    // ── Single Car Hero (gallery ← left, info → right) ────────────────────────
    if (document.querySelector(".single-car__hero")) {
        var gallery = document.querySelector(".car-gallery");
        var info    = document.querySelector(".single-car__hero_info_wrap");
        if (gallery) gsap.set(gallery, { opacity: 0, x: -50 });
        if (info)    gsap.set(info,    { opacity: 0, x: 50 });

        var carTl = gsap.timeline({
            scrollTrigger: { trigger: ".single-car__hero", start: "top 88%", once: true },
            defaults: { ease, duration: 0.85 },
        });
        if (gallery) carTl.to(gallery, { opacity: 1, x: 0 }, 0);
        if (info)    carTl.to(info,    { opacity: 1, x: 0 }, 0.15);
    }

    // ── Single Car: Features & Similar sections ───────────────────────────────
    [".single-car__feature_conntainer", ".single-car__similar_conntainer"].forEach(function (sel) {
        var el = document.querySelector(sel);
        if (!el) return;
        gsap.set(el, { opacity: 0, y: 50 });
        gsap.to(el, {
            opacity: 1, y: 0, duration: dur, ease,
            scrollTrigger: { trigger: el, start: "top 88%", once: true },
        });
    });

    // ── Hero Slider Stats ─────────────────────────────────────────────────────
    onEnterGroup(
        ".hs-stat",
        ".hs-stats",
        { opacity: 0, x: 40 },
        { opacity: 1, x: 0, duration: 0.6, ease },
        0.1
    );

    // ── Image border (About / Services) ──────────────────────────────────────
    onEnterGroup(
        ".image-border",
        ".image-border",
        { opacity: 0, scale: 0.92 },
        { opacity: 1, scale: 1, duration: 0.9, ease },
        0.15
    );

    // ── Testimonial cards ─────────────────────────────────────────────────────
    onEnterGroup(
        ".testimonials_card",
        ".testimonials_card",
        { opacity: 0, y: 40 },
        { opacity: 1, y: 0, duration: 0.7, ease },
        0.1
    );

});
