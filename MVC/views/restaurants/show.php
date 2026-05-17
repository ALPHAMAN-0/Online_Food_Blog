<?php
// pick a hero image from the first menu item, fallback to a generic interior shot
$hero_img = 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?auto=format&fit=crop&w=1600&q=80';
foreach ($items as $it) {
    if (!empty($it['image_path'])) { $hero_img = upload_url($it['image_path']); break; }
}
?>
<div class="container">
    <div class="rest-hero" style="background-image: linear-gradient(rgba(20,18,15,0.55), rgba(20,18,15,0.75)), url('<?= e($hero_img) ?>'); background-size: cover; background-position: center;">
        <div class="rest-hero-inner">
            <span class="eyebrow" style="color:var(--gold-light);">Restaurant</span>
            <h1><?= e($restaurant['name']) ?></h1>
            <p class="rest-location"><?= e($restaurant['location']) ?> &middot; <?= e($restaurant['area']) ?></p>
        </div>
    </div>

    <?php if (!empty($restaurant['short_background']) || !empty($restaurant['goals'])): ?>
    <div class="rest-info-grid">
        <?php if (!empty($restaurant['short_background'])): ?>
            <div>
                <h3>Background</h3>
                <p><?= nl2br(e($restaurant['short_background'])) ?></p>
            </div>
        <?php endif; ?>
        <?php if (!empty($restaurant['goals'])): ?>
            <div>
                <h3>What we stand for</h3>
                <p><?= nl2br(e($restaurant['goals'])) ?></p>
            </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <div class="page-head">
        <div>
            <span class="eyebrow">The menu</span>
            <h2>Featured dishes</h2>
        </div>
        <?php if (is_admin()): ?>
            <a href="<?= url('admin/menu/new/' . (int)$restaurant['id']) ?>" class="btn btn-small">+ Add dish</a>
        <?php endif; ?>
    </div>

    <div class="cards">
        <?php if (empty($items)): ?>
            <p class="no-items">No menu items yet.</p>
        <?php else: ?>
            <?php foreach ($items as $it): ?>
                <a class="card" href="<?= url('menu/' . (int)$it['id']) ?>">
                    <div class="card-img-wrap">
                        <?php if (!empty($it['image_path'])): ?>
                            <img class="card-img" src="<?= e(upload_url($it['image_path'])) ?>" alt="<?= e($it['name']) ?>">
                        <?php else: ?>
                            <div class="card-img-fallback"><?= e(strtoupper(substr($it['name'], 0, 1))) ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title"><?= e($it['name']) ?></h3>
                        <p class="card-meta"><?= e(mb_strimwidth($it['description'] ?? '', 0, 80, '...')) ?></p>
                        <span class="card-price">৳ <?= number_format($it['price'], 2) ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="reviews-section" id="restaurant-reviews-section" data-restaurant-id="<?= (int)$restaurant['id'] ?>">
        <h2>What people are saying</h2>

        <?php if (is_member()): ?>
            <form id="rest-review-form" data-validate novalidate style="margin: 1rem 0 2rem;">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="rest-review-comment">Add your review</label>
                    <textarea id="rest-review-comment" name="comment" required data-max="500" placeholder="Share your experience with this restaurant..."></textarea>
                </div>
                <button class="btn" type="submit">Post review</button>
                <span class="field-error" id="rest-review-error" style="display:none;"></span>
            </form>
        <?php elseif (!is_logged_in()): ?>
            <p style="color:var(--muted);margin-bottom:1.5rem;font-size:0.95rem;">
                <a href="<?= url('login') ?>">Log in</a> as a member to post a review.
            </p>
        <?php endif; ?>

        <ul class="review-list" id="rest-review-list">
            <?php if (empty($rest_reviews)): ?>
                <li class="no-items" id="no-rest-reviews-msg">No reviews yet. Be the first!</li>
            <?php else: ?>
                <?php foreach ($rest_reviews as $rv): ?>
                    <li class="review" data-review-id="<?= (int)$rv['id'] ?>">
                        <div class="avatar" style="background:<?= e(color_from_name($rv['author'])) ?>"><?= e(strtoupper(substr($rv['author'], 0, 1))) ?></div>
                        <div class="review-bubble">
                            <span class="name"><?= e($rv['author']) ?></span>
                            <span class="date"><?= nice_date($rv['created_at']) ?></span>
                            <div class="text"><?= nl2br(e($rv['comment'])) ?></div>
                            <?php if (is_logged_in() && ($rv['user_id'] == current_user_id() || is_admin())): ?>
                                <div class="actions">
                                    <?php if ($rv['user_id'] == current_user_id()): ?>
                                        <button type="button" class="del-rest-review">Delete</button>
                                    <?php else: ?>
                                        <button type="button" class="del-rest-review-admin">Delete (admin)</button>
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
<script src="<?= asset('js/restaurant_reviews.js') ?>"></script>
