// admin inline delete for food experience posts (from list / detail pages)

(function () {
    var BASE = window.BASE_URL || '';
    document.querySelectorAll('[data-fe-admin-delete]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var id = btn.getAttribute('data-fe-admin-delete');
            var redirect = btn.getAttribute('data-redirect');
            if (!confirm('Delete this post (admin)? This will remove its comments too.')) return;
            fetch(BASE + '/api/admin/posts/' + id, { method: 'DELETE' })
                .then(function (r) { return r.json(); })
                .then(function (d) {
                    if (!d.ok) { alert(d.error || 'Failed.'); return; }
                    if (redirect) { window.location.href = redirect; return; }
                    var card = btn.closest('.fe-post-card');
                    if (card) card.remove();
                });
        });
    });
})();
