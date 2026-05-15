<div class="container">
    <div class="page-head">
        <div>
            <span class="eyebrow">The directory</span>
            <h1>Restaurants</h1>
        </div>
    </div>

    <div class="search-row">
        <div class="form-group">
            <label for="hp-q">Search</label>
            <input type="search" id="hp-q" value="<?= e($q) ?>" placeholder="Restaurant or food name...">
        </div>
        <div class="form-group">
            <label for="hp-loc">Location</label>
            <input type="text" id="hp-loc" value="<?= e($loc) ?>" placeholder="e.g. Dhaka">
        </div>
        <div class="form-group">
            <label for="hp-area">Area</label>
            <input type="text" id="hp-area" value="<?= e($ar) ?>" placeholder="e.g. Dhanmondi">
        </div>
        <button class="btn" id="hp-go" type="button">Search</button>
    </div>

    <div class="cards" id="hp-results">
        <?php if (empty($restaurants)): ?>
            <p class="no-items">No restaurants match your search.</p>
        <?php else: ?>
            <?php foreach ($restaurants as $r): ?>
                <a class="card" href="<?= url('restaurants/' . (int)$r['id']) ?>">
                    <div class="card-img-wrap">
                        <div class="card-img-fallback"><?= e(strtoupper(substr($r['name'], 0, 1))) ?></div>
                    </div>
                    <div class="card-body">
                        <p class="card-meta"><?= e($r['location']) ?> &middot; <?= e($r['area']) ?></p>
                        <h3 class="card-title"><?= e($r['name']) ?></h3>
                        <?php if (!empty($r['short_background'])): ?>
                            <p style="margin-top:0.5rem;color:var(--muted);font-size:0.94rem;">
                                <?= e(mb_strimwidth($r['short_background'], 0, 110, '...')) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div id="hp-results-items" class="cards" style="margin-top:2rem;"></div>
</div>

<script src="<?= asset('js/search.js') ?>"></script>
