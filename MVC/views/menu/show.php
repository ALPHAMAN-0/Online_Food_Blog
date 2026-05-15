<div class="container">
    <p style="margin-bottom:1.5rem;">
        <a href="<?= url('restaurants/' . (int)$item['restaurant_id']) ?>" style="font-size:0.85rem;text-transform:uppercase;letter-spacing:2px;color:var(--muted);">&larr; Back to <?= e($item['restaurant_name']) ?></a>
    </p>

    <div class="menu-detail">
        <?php if (!empty($item['image_path'])): ?>
            <img class="menu-detail-img" src="<?= e(upload_url($item['image_path'])) ?>" alt="<?= e($item['name']) ?>">
        <?php else: ?>
            <div class="menu-detail-img-fallback"><?= e(strtoupper(substr($item['name'], 0, 1))) ?></div>
        <?php endif; ?>
        <div class="menu-detail-body">
            <span class="eyebrow">From <?= e($item['restaurant_name']) ?> &middot; <?= e($item['location']) ?></span>
            <h1><?= e($item['name']) ?></h1>
            <span class="price-tag">৳ <?= number_format($item['price'], 2) ?></span>
            <?php if (!empty($item['description'])): ?>
                <p><?= nl2br(e($item['description'])) ?></p>
            <?php endif; ?>
        </div>
    </div>

    <div class="reviews-section" id="reviews-section" data-menu-id="<?= (int)$item['id'] ?>">
        <h2>Reviews</h2>

        <?php if (is_member()): ?>
            <form id="review-form" data-validate novalidate style="margin: 1rem 0 2rem;">
                <div class="form-group">
                    <label for="review-comment">Add your review</label>
                    <textarea id="review-comment" name="comment" required data-max="500" placeholder="What did you think?"></textarea>
                </div>
                <button class="btn" type="submit">Post review</button>
                <span class="field-error" id="review-error" style="display:none;"></span>
            </form>
        <?php elseif (!is_logged_in()): ?>
            <p style="color:var(--muted);margin-bottom:1.5rem;font-size:0.95rem;">
                <a href="<?= url('login') ?>">Log in</a> as a member to post a review.
            </p>
        <?php endif; ?>

        <ul class="review-list" id="review-list">
            <?php if (empty($reviews)): ?>
                <li class="no-items" id="no-reviews-msg">No reviews yet. Be the first!</li>
            <?php else: ?>
                <?php foreach ($reviews as $rv): ?>
                    <li class="review" data-review-id="<?= (int)$rv['id'] ?>">
                        <div class="avatar" style="background:<?= e(color_from_name($rv['author'])) ?>"><?= e(strtoupper(substr($rv['author'], 0, 1))) ?></div>
                        <div class="review-bubble">
                            <span class="name"><?= e($rv['author']) ?></span>
                            <span class="date"><?= nice_date($rv['created_at']) ?></span>
                            <div class="text"><?= nl2br(e($rv['comment'])) ?></div>
                            <?php if (is_logged_in() && ($rv['user_id'] == current_user_id() || is_admin())): ?>
                                <div class="actions">
                                    <?php if ($rv['user_id'] == current_user_id()): ?>
                                        <button type="button" class="del-review">Delete</button>
                                    <?php else: ?>
                                        <button type="button" class="del-review-admin">Delete (admin)</button>
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
<script src="<?= asset('js/reviews.js') ?>"></script>
