<?php $editing = !empty($editing); ?>
<div class="container narrow">
    <div class="form-card">
        <h1><?= $editing ? 'Edit your post' : 'Share your food experience' ?></h1>
        <p style="color:var(--muted);margin-bottom:1.5rem;">Tell people what you ate, where, and how it made you feel.</p>

        <form method="post" data-validate novalidate>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" required maxlength="200" value="<?= e($data['title']) ?>">
                <?php if (!empty($errors['title'])): ?><span class="field-error"><?= e($errors['title']) ?></span><?php endif; ?>
            </div>
            <div class="form-group">
                <label for="post_type">Type</label>
                <select name="post_type" id="post_type">
                    <option value="food"       <?= $data['post_type']==='food'?'selected':'' ?>>Food only</option>
                    <option value="restaurant" <?= $data['post_type']==='restaurant'?'selected':'' ?>>Restaurant only</option>
                    <option value="both"       <?= $data['post_type']==='both'?'selected':'' ?>>Both</option>
                </select>
            </div>
            <div class="form-group">
                <label for="restaurant_id">Link to a restaurant (optional)</label>
                <select name="restaurant_id" id="restaurant_id">
                    <option value="">-- none --</option>
                    <?php foreach ($restaurants as $r): ?>
                        <option value="<?= (int)$r['id'] ?>" <?= ((string)$data['restaurant_id'])===((string)$r['id'])?'selected':'' ?>><?= e($r['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="menu_item_id">Link to a food item (optional)</label>
                <select name="menu_item_id" id="menu_item_id">
                    <option value="">-- none --</option>
                    <?php foreach ($all_items as $it): ?>
                        <option value="<?= (int)$it['id'] ?>" <?= ((string)$data['menu_item_id'])===((string)$it['id'])?'selected':'' ?>><?= e($it['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="content">Your story</label>
                <textarea name="content" id="content" required style="min-height:200px;"><?= e($data['content']) ?></textarea>
                <?php if (!empty($errors['content'])): ?><span class="field-error"><?= e($errors['content']) ?></span><?php endif; ?>
            </div>
            <button class="btn" type="submit"><?= $editing ? 'Save changes' : 'Publish' ?></button>
            <a class="btn btn-ghost" href="<?= url('food-experience') ?>">Cancel</a>
        </form>
    </div>
</div>
