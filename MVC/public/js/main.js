// shared form validation. forms that opt-in get data-validate attribute

document.addEventListener('DOMContentLoaded', function () {

    // generic validation
    var forms = document.querySelectorAll('form[data-validate]');
    forms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            var ok = true;
            // clear old errors
            form.querySelectorAll('.field-error').forEach(function (el) { el.remove(); });

            // required fields
            form.querySelectorAll('[required]').forEach(function (input) {
                if (!input.value.trim()) {
                    showError(input, 'This field is required.');
                    ok = false;
                }
            });

            // email format
            form.querySelectorAll('input[type="email"]').forEach(function (input) {
                if (input.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input.value)) {
                    showError(input, 'Please enter a valid email.');
                    ok = false;
                }
            });

            // password min length 8
            var pw = form.querySelector('input[name="password"]');
            if (pw && pw.value && pw.value.length < 8) {
                showError(pw, 'Password must be at least 8 characters.');
                ok = false;
            }

            // password match (for register)
            var pw2 = form.querySelector('input[name="password_confirm"]');
            if (pw && pw2 && pw.value !== pw2.value) {
                showError(pw2, 'Passwords do not match.');
                ok = false;
            }

            // price > 0
            var price = form.querySelector('input[name="price"]');
            if (price && price.value) {
                var n = parseFloat(price.value);
                if (isNaN(n) || n <= 0) {
                    showError(price, 'Price must be greater than 0.');
                    ok = false;
                }
            }

            // image size check (2MB)
            form.querySelectorAll('input[type="file"]').forEach(function (input) {
                if (input.files && input.files[0]) {
                    var f = input.files[0];
                    if (f.size > 2 * 1024 * 1024) {
                        showError(input, 'File is too big. Max 2MB.');
                        ok = false;
                    }
                    if (!/^image\/(jpeg|png)$/.test(f.type)) {
                        showError(input, 'Only JPEG / PNG images allowed.');
                        ok = false;
                    }
                }
            });

            // text-length check for reviews/comments (max 500)
            form.querySelectorAll('textarea[data-max]').forEach(function (ta) {
                var max = parseInt(ta.dataset.max);
                if (ta.value.length > max) {
                    showError(ta, 'Too long. Max ' + max + ' chars.');
                    ok = false;
                }
            });

            if (!ok) e.preventDefault();
        });
    });

    function showError(input, msg) {
        var span = document.createElement('span');
        span.className = 'field-error';
        span.textContent = msg;
        input.parentNode.appendChild(span);
    }

    // confirm delete buttons
    document.querySelectorAll('[data-confirm]').forEach(function (el) {
        el.addEventListener('click', function (e) {
            var msg = el.dataset.confirm || 'Are you sure?';
            if (!confirm(msg)) e.preventDefault();
        });
    });
});
