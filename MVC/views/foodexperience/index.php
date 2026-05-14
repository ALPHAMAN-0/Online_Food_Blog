<div class="container">
    <div class="page-head">
        <div>
            <h1>Food Experience</h1>
            <p style="color:var(--cocoa-light);">Descriptive reviews and stories from members and admins.</p>
        </div>
        <?php if (is_member() || is_admin()): ?>
            <a class="btn" href="/food-experience/new">+ Share your experience</a>
        <?php elseif (!is_logged_in()): ?>
            <a class="btn btn-ghost" href="/login">Log in to post</a>
        <?php endif; ?>
    </div>

    <?php if (empty($posts)): ?>
        <p class="no-items">No posts yet. Be the first to share!</p>
    <?php else: ?>
        <?php foreach ($posts as $p): ?>
            <article class="fe-post-card">
                <h2>
                    <a href="/food-experience/<?= (int)$p['id'] ?>"><?= e($p['title']) ?></a>
                    <span class="fe-type-pill"><?= e($p['post_type']) ?></span>
                </h2>
                <div class="fe-meta">
                    by <strong><?= e($p['author']) ?></strong>
                    &middot; <?= nice_date($p['created_at']) ?>
                    <?php if (!empty($p['restaurant_name'])): ?>
                        &middot; about <?= e($p['restaurant_name']) ?>
                    <?php endif; ?>
                    <?php if (!empty($p['menu_item_name'])): ?>
                        &middot; <?= e($p['menu_item_name']) ?>
                    <?php endif; ?>
                </div>
                <div class="fe-content">
                    <?= nl2br(e(mb_strimwidth($p['content'], 0, 280, '...'))) ?>
                </div>
                <div class="fe-actions">
                    <a class="btn btn-small" href="/food-experience/<?= (int)$p['id'] ?>">Read more</a>
                    <?php if (is_logged_in() && $p['user_id'] == current_user_id()): ?>
                        <a class="btn btn-small btn-ghost" href="/food-experience/edit/<?= (int)$p['id'] ?>">Edit</a>
                        <a class="btn btn-small btn-danger" href="/food-experience/delete/<?= (int)$p['id'] ?>" data-confirm="Delete this post?">Delete</a>
                    <?php elseif (is_admin()): ?>
                        <button class="btn btn-small btn-danger" type="button" data-fe-admin-delete="<?= (int)$p['id'] ?>">Delete (admin)</button>
                    <?php endif; ?>
                </div>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<script src="/public/js/admin_inline.js"></script>
