<div class="container narrow">
    <div class="form-card">
        <h1>Welcome back</h1>
        <p style="color:var(--muted);margin-bottom:1.5rem;">Log in to post reviews and share your food experience.</p>

        <?php if (!empty($errors['_'])): ?>
            <div class="flash flash-error"><?= e($errors['_']) ?></div>
        <?php endif; ?>

        <form method="post" action="<?= url('login') ?>" data-validate novalidate>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required value="<?= e($old['email']) ?>">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="form-group">
                <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;">
                    <input type="checkbox" name="remember" value="1" style="width:auto;">
                    Remember me for 30 days
                </label>
            </div>

            <button class="btn" type="submit">Log in</button>
            <p style="margin-top:1rem;font-size:0.95rem;">Need an account? <a href="<?= url('register') ?>">Register</a></p>
        </form>
    </div>
</div>
