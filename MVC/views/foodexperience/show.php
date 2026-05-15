<div class="container">
    <p style="margin-bottom:1rem;"><a href="<?= url('food-experience') ?>">&larr; All experiences</a></p>

    <article class="fe-post-card" style="padding:2.4rem;">
        <h1 style="font-size:2.2rem;"><?= e($post['title']) ?> <span class="fe-type-pill"><?= e($post['post_type']) ?></span></h1>
        <div class="fe-meta">
            by <strong><?= e($post['author']) ?></strong>
            &middot; <?= nice_date($post['created_at']) ?>
            <?php if ($post['updated_at'] !== $post['created_at']): ?>
                &middot; <em>edited</em>
            <?php endif; ?>
            <?php if (!empty($post['restaurant_name'])): ?>
                &middot; about <strong><?= e($post['restaurant_name']) ?></strong>
            <?php endif; ?>
            <?php if (!empty($post['menu_item_name'])): ?>
                &middot; dish: <strong><?= e($post['menu_item_name']) ?></strong>
            <?php endif; ?>
        </div>
        <div class="fe-content" style="margin-top:1rem;font-size:1.05rem;">
            <?= nl2br(e($post['content'])) ?>
        </div>

        <div class="fe-actions" style="margin-top:2rem;">
            <?php if (is_logged_in() && $post['user_id'] == current_user_id()): ?>
                <a class="btn btn-small btn-ghost" href="<?= url('food-experience/edit/' . (int)$post['id']) ?>">Edit</a>
                <a class="btn btn-small btn-danger" href="<?= url('food-experience/delete/' . (int)$post['id']) ?>" data-confirm="Delete this post?">Delete</a>
            <?php elseif (is_admin()): ?>
                <button class="btn btn-small btn-danger" type="button" data-fe-admin-delete="<?= (int)$post['id'] ?>" data-redirect="<?= url('food-experience') ?>">Delete (admin)</button>
            <?php endif; ?>
        </div>
    </article>

    <div class="reviews-section" id="comments-section" data-post-id="<?= (int)$post['id'] ?>" style="margin-top:1.5rem;">
        <h2>Comments</h2>

        <?php if (is_logged_in()): ?>
            <form id="comment-form" data-validate novalidate style="margin: 1rem 0 2rem;">
                <div class="form-group">
                    <label for="comment-box">Add a comment</label>
                    <textarea id="comment-box" name="comment" required data-max="500" placeholder="Say something..."></textarea>
                </div>
                <button class="btn" type="submit">Post comment</button>
                <span class="field-error" id="comment-error" style="display:none;"></span>
            </form>
        <?php else: ?>
            <p style="color:var(--muted);"><a href="<?= url('login') ?>">Log in</a> to comment.</p>
        <?php endif; ?>

        <ul class="comment-list review-list" id="comment-list">
            <?php if (empty($comments)): ?>
                <li class="no-items" id="no-comments-msg">No comments yet.</li>
            <?php else: ?>
                <?php foreach ($comments as $c): ?>
                    <li class="review" data-comment-id="<?= (int)$c['id'] ?>">
                        <div class="avatar" style="background:<?= e(color_from_name($c['author'])) ?>"><?= e(strtoupper(substr($c['author'], 0, 1))) ?></div>
                        <div class="review-bubble">
                            <span class="name"><?= e($c['author']) ?></span>
                            <span class="date"><?= nice_date($c['created_at']) ?></span>
                            <div class="text"><?= nl2br(e($c['comment'])) ?></div>
                            <?php if (is_logged_in() && ($c['user_id'] == current_user_id() || is_admin())): ?>
                                <div class="actions">
                                    <?php if ($c['user_id'] == current_user_id()): ?>
                                        <button type="button" class="del-comment">Delete</button>
                                    <?php else: ?>
                                        <button type="button" class="del-comment-admin">Delete (admin)</button>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>

<script>
window.CURRENT_USER = <?= is_logged_in() ? json_encode(['id'=>current_user_id(),'name'=>$_SESSION['name'],'role'=>$_SESSION['role']]) : 'null' ?>;
</script>
<script src="<?= asset('js/foodexp.js') ?>"></script>
<script src="<?= asset('js/admin_inline.js') ?>"></script>
