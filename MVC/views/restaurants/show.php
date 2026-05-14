<div class="container">
    <div class="rest-header">
        <h1><?= e($restaurant['name']) ?></h1>
        <p class="rest-location"><?= e($restaurant['location']) ?> &middot; <?= e($restaurant['area']) ?></p>
        <?php if (!empty($restaurant['short_background'])): ?>
            <div class="rest-section">
                <h3>Background</h3>
                <p><?= nl2br(e($restaurant['short_background'])) ?></p>
            </div>
        <?php endif; ?>
        <?php if (!empty($restaurant['goals'])): ?>
            <div class="rest-section">
                <h3>Our goals</h3>
                <p><?= nl2br(e($restaurant['goals'])) ?></p>
            </div>
        <?php endif; ?>
    </div>

    <div class="page-head">
        <h2>Menu items</h2>
        <?php if (is_admin()): ?>
            <a href="/admin/menu/new/<?= (int)$restaurant['id'] ?>" class="btn btn-small">Add menu item</a>
        <?php endif; ?>
    </div>

    <div class="cards">
        <?php if (empty($items)): ?>
            <p class="no-items">No menu items yet.</p>
        <?php else: ?>
            <?php foreach ($items as $it): ?>
                <a class="card" href="/menu/<?= (int)$it['id'] ?>">
                    <?php if (!empty($it['image_path'])): ?>
                        <img class="card-img" src="<?= e($it['image_path']) ?>" alt="<?= e($it['name']) ?>">
                    <?php else: ?>
                        <div class="card-img-fallback"><?= e(strtoupper(substr($it['name'], 0, 1))) ?></div>
                    <?php endif; ?>
                    <div class="card-body">
                        <h3 class="card-title"><?= e($it['name']) ?></h3>
                        <p class="card-meta"><?= e(mb_strimwidth($it['description'] ?? '', 0, 80, '...')) ?></p>
                        <span class="card-price">৳ <?= number_format($it['price'], 2) ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
