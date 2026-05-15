<section class="hero">
    <div class="hero-inner">
        <span class="eyebrow">Foodly &mdash; est. 2026</span>
        <h1>Where every plate has a story.</h1>
        <p>A curated journal of restaurants, dishes and the people who love them. Browse, review, and share food worth remembering.</p>
        <div>
            <?php if (!is_logged_in()): ?>
                <a class="btn" href="<?= url('register') ?>">Become a member</a>
                <a class="btn btn-ghost" style="margin-left:0.6rem;" href="<?= url('restaurants') ?>">Browse restaurants</a>
            <?php else: ?>
                <a class="btn" href="<?= url('restaurants') ?>">Browse restaurants</a>
                <a class="btn btn-ghost" style="margin-left:0.6rem;" href="<?= url('food-experience') ?>">Food Experience</a>
            <?php endif; ?>
        </div>
    </div>
</section>

<div class="container">
    <!-- visual gallery row of curated dishes -->
    <span class="eyebrow">A taste of what's inside</span>
    <h2 style="margin-bottom:1.4rem;">Featured dishes</h2>
    <div class="gallery-row">
        <a href="<?= url('restaurants') ?>"><img src="https://images.unsplash.com/photo-1545247181-516773cae754?auto=format&fit=crop&w=700&q=80" alt="Beef bhuna"></a>
        <a href="<?= url('restaurants') ?>"><img src="https://images.unsplash.com/photo-1455619452474-d2be8b1e70cd?auto=format&fit=crop&w=700&q=80" alt="Prawn curry"></a>
        <a href="<?= url('restaurants') ?>"><img src="https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?auto=format&fit=crop&w=700&q=80" alt="Kebab"></a>
        <a href="<?= url('restaurants') ?>"><img src="https://images.unsplash.com/photo-1488477181946-6428a0291777?auto=format&fit=crop&w=700&q=80" alt="Sticky rice"></a>
    </div>

    <hr class="divider">

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
        <div>
            <span class="eyebrow">Editor's picks</span>
            <h2 id="results-title">Featured restaurants</h2>
        </div>
        <a href="<?= url('restaurants') ?>">View all &rarr;</a>
    </div>

    <div class="cards" id="hp-results">
        <?php if (empty($featured)): ?>
            <p class="no-items">No restaurants yet. Check back soon!</p>
        <?php else: ?>
            <?php foreach ($featured as $r): ?>
                <a class="card" href="<?= url('restaurants/' . (int)$r['id']) ?>">
                    <div class="card-img-wrap">
                        <div class="card-img-fallback"><?= e(strtoupper(substr($r['name'], 0, 1))) ?></div>
                    </div>
                    <div class="card-body">
                        <p class="card-meta"><?= e($r['location']) ?> &middot; <?= e($r['area']) ?></p>
                        <h3 class="card-title"><?= e($r['name']) ?></h3>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div id="hp-results-items" class="cards" style="margin-top:2rem;"></div>
</div>

<script src="<?= asset('js/search.js') ?>"></script>
