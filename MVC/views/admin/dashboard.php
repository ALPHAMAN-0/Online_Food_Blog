<h1>Dashboard</h1>
<p style="color:var(--muted);margin-bottom:1.5rem;">A quick overview of everything in the system.</p>

<div class="tiles">
    <div class="tile">
        <div class="label">Restaurants</div>
        <div class="value"><?= $counts['restaurants'] ?></div>
    </div>
    <div class="tile">
        <div class="label">Menu items</div>
        <div class="value"><?= $counts['menu_items'] ?></div>
    </div>
    <div class="tile">
        <div class="label">Reviews</div>
        <div class="value"><?= $counts['reviews'] ?></div>
    </div>
    <div class="tile">
        <div class="label">Food experience posts</div>
        <div class="value"><?= $counts['fe_posts'] ?></div>
    </div>
</div>

<div style="display:flex;gap:1rem;flex-wrap:wrap;">
    <a class="btn" href="<?= url('admin/restaurants') ?>">Manage restaurants</a>
    <a class="btn btn-ghost" href="<?= url('admin/members') ?>">Manage members</a>
    <a class="btn btn-ghost" href="<?= url('admin/restaurants/new') ?>">+ New restaurant</a>
</div>
