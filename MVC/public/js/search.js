// AJAX search on home + restaurants page

(function () {
    var BASE = window.BASE_URL || '';
    var q = document.getElementById('hp-q');
    var loc = document.getElementById('hp-loc');
    var ar = document.getElementById('hp-area');
    var btn = document.getElementById('hp-go');
    var results = document.getElementById('hp-results');
    var resultsItems = document.getElementById('hp-results-items');
    var title = document.getElementById('results-title');

    if (!q || !btn || !results) return;

    function fmt(money) {
        return '৳ ' + Number(money).toFixed(2);
    }

    function escapeHtml(s) {
        var d = document.createElement('div');
        d.textContent = s || '';
        return d.innerHTML;
    }

    function renderRestaurants(list) {
        results.innerHTML = '';
        if (!list.length) {
            results.innerHTML = '<p class="no-items">No restaurants found.</p>';
            return;
        }
        list.forEach(function (r) {
            var letter = (r.name || '?').charAt(0).toUpperCase();
            var html = '<a class="card" href="' + BASE + '/restaurants/' + r.id + '">' +
                '<div class="card-img-fallback">' + escapeHtml(letter) + '</div>' +
                '<div class="card-body">' +
                '<h3 class="card-title">' + escapeHtml(r.name) + '</h3>' +
                '<p class="card-meta">' + escapeHtml(r.location) + ' · ' + escapeHtml(r.area) + '</p>' +
                '</div></a>';
            results.insertAdjacentHTML('beforeend', html);
        });
    }

    function renderItems(list) {
        if (!resultsItems) return;
        resultsItems.innerHTML = '';
        if (!list.length) return;
        var heading = document.createElement('h3');
        heading.textContent = 'Matching food items';
        heading.style.gridColumn = '1 / -1';
        heading.style.marginTop = '1rem';
        resultsItems.appendChild(heading);

        list.forEach(function (it) {
            var imgSrc = it.image_path
                ? (/^https?:\/\//i.test(it.image_path) ? it.image_path : BASE + '/' + String(it.image_path).replace(/^\/+/, ''))
                : '';
            var imgHtml = imgSrc
                ? '<img class="card-img" src="' + escapeHtml(imgSrc) + '" alt="">'
                : '<div class="card-img-fallback">' + escapeHtml((it.name||'?').charAt(0).toUpperCase()) + '</div>';
            var html = '<a class="card" href="' + BASE + '/menu/' + it.id + '">' +
                imgHtml +
                '<div class="card-body">' +
                '<h3 class="card-title">' + escapeHtml(it.name) + '</h3>' +
                '<p class="card-meta">' + escapeHtml(it.restaurant_name || '') + '</p>' +
                '<span class="card-price">' + fmt(it.price) + '</span>' +
                '</div></a>';
            resultsItems.insertAdjacentHTML('beforeend', html);
        });
    }

    function doSearch() {
        var params = new URLSearchParams();
        if (q.value.trim())   params.set('q', q.value.trim());
        if (loc.value.trim()) params.set('location', loc.value.trim());
        if (ar.value.trim())  params.set('area', ar.value.trim());

        fetch(BASE + '/api/search?' + params.toString())
            .then(function (r) {
                if (!r.ok) throw new Error('Network error');
                return r.json();
            })
            .then(function (data) {
                if (title) title.textContent = (q.value || loc.value || ar.value) ? 'Search results' : 'Featured restaurants';
                renderRestaurants(data.restaurants || []);
                renderItems(data.items || []);
            })
            .catch(function (err) {
                results.innerHTML = '<p class="flash flash-error">Search failed: ' + escapeHtml(err.message) + '</p>';
            });
    }

    btn.addEventListener('click', doSearch);

    // also search on enter / typing (debounced a bit)
    var timer = null;
    function onInput() {
        clearTimeout(timer);
        timer = setTimeout(doSearch, 300);
    }
    [q, loc, ar].forEach(function (el) {
        if (el) el.addEventListener('input', onInput);
    });
})();
