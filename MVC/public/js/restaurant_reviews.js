// AJAX add + delete reviews on restaurant detail page

(function () {
    var BASE = window.BASE_URL || '';
    var section = document.getElementById('restaurant-reviews-section');
    if (!section) return;
    var restaurantId = section.dataset.restaurantId;
    var form = document.getElementById('rest-review-form');
    var list = document.getElementById('rest-review-list');
    var errBox = document.getElementById('rest-review-error');
    var noMsg  = document.getElementById('no-rest-reviews-msg');

    function escapeHtml(s) {
        var d = document.createElement('div');
        d.textContent = s || '';
        return d.innerHTML;
    }

    function colorFromName(n) {
        var hash = 0;
        for (var i = 0; i < (n||'').length; i++) hash = (hash * 31 + n.charCodeAt(i)) % 360;
        return 'hsl(' + hash + ', 55%, 60%)';
    }

    function makeReviewHtml(rv, mine) {
        var letter = (rv.author || '?').charAt(0).toUpperCase();
        var date = rv.created_at ? new Date(rv.created_at.replace(' ', 'T')).toLocaleString() : '';
        var actions = mine
            ? '<div class="actions"><button type="button" class="del-rest-review">Delete</button></div>'
            : '';
        return '<li class="review" data-review-id="' + rv.id + '">' +
            '<div class="avatar" style="background:' + colorFromName(rv.author) + '">' + escapeHtml(letter) + '</div>' +
            '<div class="review-bubble">' +
            '<span class="name">' + escapeHtml(rv.author) + '</span>' +
            '<span class="date">' + escapeHtml(date) + '</span>' +
            '<div class="text">' + escapeHtml(rv.comment).replace(/\n/g,'<br>') + '</div>' +
            actions +
            '</div></li>';
    }

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            errBox.style.display = 'none';
            errBox.textContent = '';
            var ta = document.getElementById('rest-review-comment');
            var txt = ta.value.trim();
            if (!txt) {
                errBox.textContent = 'Please write something.';
                errBox.style.display = 'block';
                return;
            }
            if (txt.length > 500) {
                errBox.textContent = 'Review is too long (max 500 characters).';
                errBox.style.display = 'block';
                return;
            }
            var fd = new FormData();
            fd.append('restaurant_id', restaurantId);
            fd.append('comment', txt);
            fd.append('csrf_token', window.CSRF_TOKEN || '');
            fetch(BASE + '/api/restaurant-reviews/add', { method: 'POST', body: fd })
                .then(function (r) { return r.json().then(function (d) { return { ok: r.ok, data: d }; }); })
                .then(function (resp) {
                    if (!resp.ok || !resp.data.ok) {
                        errBox.textContent = (resp.data && resp.data.error) || 'Could not post review.';
                        errBox.style.display = 'block';
                        return;
                    }
                    ta.value = '';
                    if (noMsg) { noMsg.remove(); }
                    list.insertAdjacentHTML('afterbegin', makeReviewHtml(resp.data.review, true));
                })
                .catch(function () {
                    errBox.textContent = 'Network error.';
                    errBox.style.display = 'block';
                });
        });
    }

    if (list) {
        list.addEventListener('click', function (e) {
            var t = e.target;
            if (!t) return;
            var li = t.closest('.review');
            if (!li) return;
            var id = li.dataset.reviewId;
            var headers = { 'X-CSRF-Token': window.CSRF_TOKEN || '' };
            if (t.classList.contains('del-rest-review')) {
                if (!confirm('Delete your review?')) return;
                fetch(BASE + '/api/restaurant-reviews/' + id, { method: 'DELETE', headers: headers })
                    .then(function (r) { return r.json(); })
                    .then(function (d) {
                        if (d.ok) li.remove();
                        else alert(d.error || 'Could not delete.');
                    });
            } else if (t.classList.contains('del-rest-review-admin')) {
                if (!confirm('Delete this review (admin)?')) return;
                fetch(BASE + '/api/admin/restaurant-reviews/' + id, { method: 'DELETE', headers: headers })
                    .then(function (r) { return r.json(); })
                    .then(function (d) {
                        if (d.ok) li.remove();
                        else alert(d.error || 'Could not delete.');
                    });
            }
        });
    }
})();
