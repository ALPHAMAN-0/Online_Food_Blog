<section class="hero">
    <h1>Discover food that tells a story.</h1>
    <p>Foodly brings together restaurants, dishes, and the people who love them. Browse, review, and share your own food experiences.</p>
    <?php if (!is_logged_in()): ?>
        <a class="btn" href="/register">Get started &mdash; it's free</a>
        <a class="btn btn-ghost" style="margin-left:0.6rem;background:transparent;color:white;border-color:white;" href="/restaurants">Browse restaurants</a>
    <?php else: ?>
        <a class="btn" href="/restaurants">Browse restaurants</a>
        <a class="btn btn-ghost" style="margin-left:0.6rem;background:transparent;color:white;border-color:white;" href="/food-experience">Food Experience</a>
    <?php endif; ?>
</section>

<div class="container">
    <div class="search-row">
        <div class="form-group">
            <label for="hp-q">Search</label>
            <input type="search" id="hp-q" placeholder="Restaurant or food name...">
        </div>
        <div class="form-group">
            <label for="hp-loc">Location</label>
            <input type="text" id="hp-loc" placeholder="e.g. Dhaka">
        </div>
        <div class="form-group">
            <label for="hp-area">Area</label>
            <input type="text" id="hp-area" placeholder="e.g. Dhanmondi">
        </div>
        <button class="btn" id="hp-go" type="button">Search</button>
    </div>

    <div class="page-head">
        <h2 id="results-title">Featured restaurants</h2>
        <a href="/restaurants">View all</a>
    </div>

    <div class="cards" id="hp-results">
        <?php if (empty($featured)): ?>
            <p class="no-items">No restaurants yet. Check back soon!</p>
        <?php else: ?>
            <?php foreach ($featured as $r): ?>
                <a class="card" href="/restaurants/<?= (int)$r['id'] ?>">
                    <div class="card-img-fallback"><?= e(strtoupper(substr($r['name'], 0, 1))) ?></div>
                    <div class="card-body">
                        <h3 class="card-title"><?= e($r['name']) ?></h3>
                        <p class="card-meta"><?= e($r['location']) ?> &middot; <?= e($r['area']) ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div id="hp-results-items" class="cards" style="margin-top:1.5rem;"></div>
</div>

<script src="/public/js/search.js"></script>
