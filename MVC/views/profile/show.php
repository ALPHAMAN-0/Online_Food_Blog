<div class="container">
    <div class="profile-card">
        <div class="profile-top">
            <?php if (!empty($user['profile_picture'])): ?>
                <img class="profile-pic" src="<?= e(upload_url($user['profile_picture'])) ?>" alt="profile">
            <?php else: ?>
                <div class="profile-pic-fallback"><?= e(strtoupper(substr($user['name'], 0, 1))) ?></div>
            <?php endif; ?>
            <div class="profile-info">
                <h2><?= e($user['name']) ?></h2>
                <span class="role"><?= e($user['role']) ?></span>
                <p style="color:var(--muted);margin-top:0.4rem;"><?= e($user['email']) ?></p>
                <p style="color:var(--muted);font-size:0.85rem;">Joined <?= nice_date($user['created_at']) ?></p>
            </div>
        </div>
    </div>

    <div class="profile-card">
        <h2>Edit profile</h2>
        <form method="post" action="<?= url('profile/update') ?>" enctype="multipart/form-data" data-validate novalidate>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" required value="<?= e($user['name']) ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required value="<?= e($user['email']) ?>">
            </div>
            <div class="form-group">
                <label for="picture">Profile picture (JPEG/PNG, max 2MB)</label>
                <input type="file" name="picture" id="picture" accept="image/jpeg,image/png">
            </div>
            <button class="btn" type="submit">Save changes</button>
        </form>
    </div>

    <div class="profile-card">
        <h2>Change password</h2>
        <form method="post" action="<?= url('profile/password') ?>" data-validate novalidate>
            <div class="form-group">
                <label for="current">Current password</label>
                <input type="password" name="current" id="current" required>
            </div>
            <div class="form-group">
                <label for="new">New password</label>
                <input type="password" name="new" id="new" required minlength="8">
            </div>
            <div class="form-group">
                <label for="confirm">Confirm new password</label>
                <input type="password" name="confirm" id="confirm" required>
            </div>
            <button class="btn" type="submit">Change password</button>
        </form>
    </div>
</div>
