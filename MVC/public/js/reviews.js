// AJAX add + delete reviews on menu item detail page

(function () {
    var BASE = window.BASE_URL || '';
    var section = document.getElementById('reviews-section');
    if (!section) return;
    var menuId = section.dataset.menuId;
    var form = document.getElementById('review-form');
    var list = document.getElementById('review-list');
    var errBox = document.getElementById('review-error');
    var noMsg  = document.getElementById('no-reviews-msg');

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
            ? '<div class="actions"><button type="button" class="del-review">Delete</button></div>'
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
            var ta = document.getElementById('review-comment');
            var txt = ta.value.trim();
            if (!txt) {
                errBox.textContent = 'Please write something.';
                errBox.style.display = 'block';
                return;
            }
            var fd = new FormData();
            fd.append('menu_item_id', menuId);
            fd.append('comment', txt);
            fetch(BASE + '/api/reviews/add', { method: 'POST', body: fd })
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

    // delegate delete clicks
    if (list) {
        list.addEventListener('click', function (e) {
            var t = e.target;
            if (!t) return;
            var li = t.closest('.review');
            if (!li) return;
            var id = li.dataset.reviewId;
            if (t.classList.contains('del-review')) {
                if (!confirm('Delete your review?')) return;
                fetch(BASE + '/api/reviews/' + id, { method: 'DELETE' })
                    .then(function (r) { return r.json(); })
                    .then(function (d) {
                        if (d.ok) li.remove();
                        else alert(d.error || 'Could not delete.');
                    });
            } else if (t.classList.contains('del-review-admin')) {
                if (!confirm('Delete this review (admin)?')) return;
                fetch(BASE + '/api/admin/reviews/' + id, { method: 'DELETE' })
                    .then(function (r) { return r.json(); })
                    .then(function (d) {
                        if (d.ok) li.remove();
                        else alert(d.error || 'Could not delete.');
                    });
            }
        });
    }
})();
