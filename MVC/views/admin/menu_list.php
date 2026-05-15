<div class="page-head">
    <div>
        <h1>Menu items</h1>
        <p style="color:var(--muted);">for <strong><?= e($restaurant['name']) ?></strong></p>
    </div>
    <div>
        <a class="btn" href="<?= url('admin/menu/new/' . (int)$restaurant['id']) ?>">+ Add item</a>
        <a class="btn btn-ghost" href="<?= url('admin/restaurants') ?>">&larr; Restaurants</a>
    </div>
</div>

<?php if (empty($items)): ?>
    <p class="no-items">No menu items yet.</p>
<?php else: ?>
<table class="data-table">
    <thead>
        <tr><th>Image</th><th>Name</th><th>Price</th><th>Created</th><th>Actions</th></tr>
    </thead>
    <tbody>
    <?php foreach ($items as $it): ?>
        <tr>
            <td>
                <?php if (!empty($it['image_path'])): ?>
                    <img src="<?= e(upload_url($it['image_path'])) ?>" alt="" style="width:60px;height:60px;object-fit:cover;border-radius:8px;">
                <?php else: ?>
                    <div style="width:60px;height:60px;background:var(--line);border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--gold-dark);font-weight:700;">?</div>
                <?php endif; ?>
            </td>
            <td><?= e($it['name']) ?></td>
            <td>৳ <?= number_format($it['price'], 2) ?></td>
            <td><?= nice_date($it['created_at']) ?></td>
            <td class="row-actions">
                <a class="btn btn-small btn-ghost" href="<?= url('menu/' . (int)$it['id']) ?>">View</a>
                <a class="btn btn-small btn-ghost" href="<?= url('admin/menu/edit/' . (int)$it['id']) ?>">Edit</a>
                <a class="btn btn-small btn-danger" href="<?= url('admin/menu/delete/' . (int)$it['id']) ?>" data-confirm="Delete this menu item?">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
