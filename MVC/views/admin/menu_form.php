<h1><?= $editing ? 'Edit menu item' : 'New menu item' ?></h1>
<p style="color:var(--muted);">for <strong><?= e($restaurant['name']) ?></strong></p>

<div class="form-card" style="max-width:680px;margin-top:1rem;">
    <form method="post" enctype="multipart/form-data" data-validate novalidate>
        <div class="form-group">
            <label for="name">Item name</label>
            <input type="text" name="name" id="name" required maxlength="150" value="<?= e($data['name']) ?>">
            <?php if (!empty($errors['name'])): ?><span class="field-error"><?= e($errors['name']) ?></span><?php endif; ?>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description"><?= e($data['description']) ?></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price (taka)</label>
            <input type="number" step="0.01" min="0.01" name="price" id="price" required value="<?= e($data['price']) ?>">
            <?php if (!empty($errors['price'])): ?><span class="field-error"><?= e($errors['price']) ?></span><?php endif; ?>
        </div>
        <div class="form-group">
            <label for="image">Image (JPEG/PNG, max 2MB)</label>
            <input type="file" name="image" id="image" accept="image/jpeg,image/png">
            <?php if (!empty($errors['image'])): ?><span class="field-error"><?= e($errors['image']) ?></span><?php endif; ?>
            <?php if ($editing && !empty($data['image_path'])): ?>
                <p style="margin-top:0.5rem;color:var(--muted);font-size:0.9rem;">Current:</p>
                <img src="<?= e(upload_url($data['image_path'])) ?>" style="max-width:120px;border-radius:8px;margin-top:0.4rem;">
            <?php endif; ?>
        </div>
        <button class="btn" type="submit"><?= $editing ? 'Save changes' : 'Add item' ?></button>
        <a class="btn btn-ghost" href="<?= url('admin/menu/list/' . (int)$data['restaurant_id']) ?>">Cancel</a>
    </form>
</div>
