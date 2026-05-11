(function () {
    const gallery   = document.querySelector('.car-gallery');
    if (!gallery) return;

    const images    = JSON.parse(gallery.dataset.images || '[]');
    const mainImg   = document.getElementById('car-gallery-img');
    const mainWrap  = document.getElementById('car-gallery-main');
    const thumbs    = document.querySelectorAll('.car-gallery__thumb');
    const counter   = document.getElementById('car-gallery-current');

    const lightbox  = document.getElementById('car-lightbox');
    const lbImg     = document.getElementById('car-lightbox-img');
    const lbCurrent = document.getElementById('car-lightbox-current');
    const lbClose   = document.getElementById('car-lightbox-close');
    const lbOverlay = document.getElementById('car-lightbox-overlay');
    const lbPrev    = document.getElementById('car-lightbox-prev');
    const lbNext    = document.getElementById('car-lightbox-next');

    let current = 0;

    function setActive(index) {
        current = index;
        mainImg.src = images[index];
        if (counter) counter.textContent = index + 1;
        thumbs.forEach((t) => t.classList.toggle('is-active', +t.dataset.index === index));
    }

    // Thumbnail clicks
    thumbs.forEach((btn) => {
        btn.addEventListener('click', () => setActive(+btn.dataset.index));
    });

    // Open lightbox
    if (mainWrap) {
        mainWrap.addEventListener('click', () => openLightbox(current));
    }

    function openLightbox(index) {
        current = index;
        lbImg.src = images[index];
        if (lbCurrent) lbCurrent.textContent = index + 1;
        lightbox.classList.add('is-open');
        lightbox.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        lightbox.classList.remove('is-open');
        lightbox.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    function navigate(dir) {
        const next = (current + dir + images.length) % images.length;
        setActive(next);
        lbImg.src = images[next];
        if (lbCurrent) lbCurrent.textContent = next + 1;
    }

    lbClose?.addEventListener('click', closeLightbox);
    lbOverlay?.addEventListener('click', closeLightbox);
    lightbox?.addEventListener('click', (e) => {
        if (!e.target.closest('img, button')) closeLightbox();
    });
    lbPrev?.addEventListener('click', () => navigate(-1));
    lbNext?.addEventListener('click', () => navigate(1));

    document.addEventListener('keydown', (e) => {
        if (!lightbox.classList.contains('is-open')) return;
        if (e.key === 'Escape')      closeLightbox();
        if (e.key === 'ArrowLeft')   navigate(-1);
        if (e.key === 'ArrowRight')  navigate(1);
    });
})();
