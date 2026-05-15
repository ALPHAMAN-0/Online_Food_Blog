<h1><?= $editing ? 'Edit restaurant' : 'New restaurant' ?></h1>

<div class="form-card" style="max-width:680px;margin-top:1rem;">
    <form method="post" data-validate novalidate>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" required maxlength="150" value="<?= e($data['name']) ?>">
            <?php if (!empty($errors['name'])): ?><span class="field-error"><?= e($errors['name']) ?></span><?php endif; ?>
        </div>
        <div class="form-group">
            <label for="location">Location (city)</label>
            <input type="text" name="location" id="location" required value="<?= e($data['location']) ?>">
            <?php if (!empty($errors['location'])): ?><span class="field-error"><?= e($errors['location']) ?></span><?php endif; ?>
        </div>
        <div class="form-group">
            <label for="area">Area (neighborhood)</label>
            <input type="text" name="area" id="area" required value="<?= e($data['area']) ?>">
            <?php if (!empty($errors['area'])): ?><span class="field-error"><?= e($errors['area']) ?></span><?php endif; ?>
        </div>
        <div class="form-group">
            <label for="short_background">Short background</label>
            <textarea name="short_background" id="short_background"><?= e($data['short_background']) ?></textarea>
        </div>
        <div class="form-group">
            <label for="goals">Goals</label>
            <textarea name="goals" id="goals"><?= e($data['goals']) ?></textarea>
        </div>
        <button class="btn" type="submit"><?= $editing ? 'Save changes' : 'Create restaurant' ?></button>
        <a class="btn btn-ghost" href="<?= url('admin/restaurants') ?>">Cancel</a>
    </form>
</div>
