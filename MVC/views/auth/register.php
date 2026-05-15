<div class="container narrow">
    <div class="form-card">
        <h1>Join Foodly</h1>
        <p style="color:var(--muted);margin-bottom:1.5rem;">Create an account to share your reviews and food experiences.</p>

        <form method="post" action="<?= url('register') ?>" data-validate novalidate>
            <div class="form-group">
                <label for="name">Full name</label>
                <input type="text" name="name" id="name" required value="<?= e($old['name']) ?>">
                <?php if (!empty($errors['name'])): ?><span class="field-error"><?= e($errors['name']) ?></span><?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required value="<?= e($old['email']) ?>">
                <?php if (!empty($errors['email'])): ?><span class="field-error"><?= e($errors['email']) ?></span><?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password">Password (at least 8 chars)</label>
                <input type="password" name="password" id="password" required minlength="8">
                <?php if (!empty($errors['password'])): ?><span class="field-error"><?= e($errors['password']) ?></span><?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password_confirm">Confirm password</label>
                <input type="password" name="password_confirm" id="password_confirm" required>
                <?php if (!empty($errors['password_confirm'])): ?><span class="field-error"><?= e($errors['password_confirm']) ?></span><?php endif; ?>
            </div>

            <div class="form-group">
                <label for="role">Account type</label>
                <select name="role" id="role">
                    <option value="member" <?= $old['role'] === 'member' ? 'selected' : '' ?>>Member</option>
                    <option value="admin"  <?= $old['role'] === 'admin'  ? 'selected' : '' ?>>Admin</option>
                </select>
                <?php if (!empty($errors['role'])): ?><span class="field-error"><?= e($errors['role']) ?></span><?php endif; ?>
            </div>

            <button class="btn" type="submit">Create account</button>
            <p style="margin-top:1rem;font-size:0.95rem;">Already have an account? <a href="<?= url('login') ?>">Log in</a></p>
        </form>
    </div>
</div>
