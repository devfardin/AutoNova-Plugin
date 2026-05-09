(function () {
    var wrap     = document.querySelector('.feature-cars__wrapper');
    if (!wrap) return;

    var selects  = wrap.querySelectorAll('.feature-cars__select');
    var grid     = wrap.querySelector('.feature-cars__grid');
    var countEl  = wrap.querySelector('.feature-cars__count strong');
    var resetBtn = wrap.querySelector('.feature-cars__reset');

    function hasActiveFilter() {
        return Array.from(selects).some(function (sel) { return sel.value !== ''; });
    }

    function toggleReset() {
        resetBtn.style.display = hasActiveFilter() ? 'inline-flex' : 'none';
    }

    function getFilters() {
        var filters = {};
        selects.forEach(function (sel) { filters[sel.name] = sel.value; });
        return filters;
    }

    function setLoading(loading) {
        grid.style.opacity      = loading ? '0.4' : '1';
        grid.style.pointerEvents = loading ? 'none' : '';
    }

    function doFilter() {
        var data = new FormData();
        data.append('action', 'cars_inventory_filter');
        data.append('nonce', carsInventory.nonce);
        Object.entries(getFilters()).forEach(function (entry) {
            data.append(entry[0], entry[1]);
        });

        setLoading(true);

        fetch(carsInventory.ajaxUrl, { method: 'POST', body: data })
            .then(function (res) { return res.json(); })
            .then(function (res) {
                grid.innerHTML = res.html;
                if (countEl) countEl.textContent = res.count;
                setLoading(false);
            })
            .catch(function () { setLoading(false); });
    }

    selects.forEach(function (sel) {
        sel.addEventListener('change', function () {
            toggleReset();
            doFilter();
        });
    });

    resetBtn.addEventListener('click', function () {
        selects.forEach(function (sel) { sel.value = ''; });
        toggleReset();
        doFilter();
    });

    // delegate reset click from no-results section
    grid.addEventListener('click', function (e) {
        if (e.target.closest('.feature-cars__empty-reset')) {
            selects.forEach(function (sel) { sel.value = ''; });
            toggleReset();
            doFilter();
        }
    });
})();
