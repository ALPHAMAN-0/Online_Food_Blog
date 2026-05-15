<div class="page-head">
    <h1>Restaurants</h1>
    <a class="btn" href="<?= url('admin/restaurants/new') ?>">+ Add restaurant</a>
</div>

<?php if (empty($restaurants)): ?>
    <p class="no-items">No restaurants yet.</p>
<?php else: ?>
<table class="data-table">
    <thead>
        <tr><th>Name</th><th>Location</th><th>Area</th><th>Created</th><th>Actions</th></tr>
    </thead>
    <tbody>
    <?php foreach ($restaurants as $r): ?>
        <tr>
            <td><strong><?= e($r['name']) ?></strong></td>
            <td><?= e($r['location']) ?></td>
            <td><?= e($r['area']) ?></td>
            <td><?= nice_date($r['created_at']) ?></td>
            <td class="row-actions">
                <a class="btn btn-small btn-ghost" href="<?= url('admin/menu/list/' . (int)$r['id']) ?>">Menu</a>
                <a class="btn btn-small btn-ghost" href="<?= url('admin/restaurants/edit/' . (int)$r['id']) ?>">Edit</a>
                <a class="btn btn-small btn-danger" href="<?= url('admin/restaurants/delete/' . (int)$r['id']) ?>" data-confirm="Delete this restaurant and all its menu items?">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
