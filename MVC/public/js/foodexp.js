// AJAX for food experience comments

(function () {
    var BASE = window.BASE_URL || '';
    var section = document.getElementById('comments-section');
    if (!section) return;
    var postId = section.dataset.postId;
    var form   = document.getElementById('comment-form');
    var list   = document.getElementById('comment-list');
    var errBox = document.getElementById('comment-error');
    var noMsg  = document.getElementById('no-comments-msg');

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
    function buildHtml(c, mine) {
        var letter = (c.author || '?').charAt(0).toUpperCase();
        var date = c.created_at ? new Date(c.created_at.replace(' ', 'T')).toLocaleString() : '';
        var actions = mine ? '<div class="actions"><button type="button" class="del-comment">Delete</button></div>' : '';
        return '<li class="review" data-comment-id="' + c.id + '">' +
            '<div class="avatar" style="background:' + colorFromName(c.author) + '">' + escapeHtml(letter) + '</div>' +
            '<div class="review-bubble">' +
            '<span class="name">' + escapeHtml(c.author) + '</span>' +
            '<span class="date">' + escapeHtml(date) + '</span>' +
            '<div class="text">' + escapeHtml(c.comment).replace(/\n/g,'<br>') + '</div>' +
            actions +
            '</div></li>';
    }

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            errBox.style.display = 'none';
            var ta = document.getElementById('comment-box');
            var txt = ta.value.trim();
            if (!txt) {
                errBox.textContent = 'Please write something.';
                errBox.style.display = 'block';
                return;
            }
            var fd = new FormData();
            fd.append('post_id', postId);
            fd.append('comment', txt);
            fetch(BASE + '/api/food-exp/comments/add', { method: 'POST', body: fd })
                .then(function (r) { return r.json().then(function (d) { return { ok: r.ok, data: d }; }); })
                .then(function (resp) {
                    if (!resp.ok || !resp.data.ok) {
                        errBox.textContent = (resp.data && resp.data.error) || 'Could not post.';
                        errBox.style.display = 'block';
                        return;
                    }
                    ta.value = '';
                    if (noMsg) noMsg.remove();
                    list.insertAdjacentHTML('beforeend', buildHtml(resp.data.comment, true));
                });
        });
    }

    if (list) {
        list.addEventListener('click', function (e) {
            var t = e.target;
            var li = t.closest('.review');
            if (!li) return;
            var id = li.dataset.commentId;
            if (t.classList.contains('del-comment')) {
                if (!confirm('Delete your comment?')) return;
                fetch(BASE + '/api/food-exp/comments/' + id, { method: 'DELETE' })
                    .then(function (r) { return r.json(); })
                    .then(function (d) {
                        if (d.ok) li.remove();
                        else alert(d.error || 'Could not delete.');
                    });
            } else if (t.classList.contains('del-comment-admin')) {
                if (!confirm('Delete this comment (admin)?')) return;
                fetch(BASE + '/api/admin/comments/' + id, { method: 'DELETE' })
                    .then(function (r) { return r.json(); })
                    .then(function (d) {
                        if (d.ok) li.remove();
                        else alert(d.error || 'Could not delete.');
                    });
            }
        });
    }
})();
