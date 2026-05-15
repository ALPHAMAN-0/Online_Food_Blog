<div class="page-head">
    <h1>Members</h1>
    <p style="color:var(--muted);">All registered members. Deleting also removes their reviews, posts and comments.</p>
</div>

<?php if (empty($members)): ?>
    <p class="no-items">No members yet.</p>
<?php else: ?>
<table class="data-table">
    <thead>
        <tr><th></th><th>Name</th><th>Email</th><th>Joined</th><th>Actions</th></tr>
    </thead>
    <tbody>
    <?php foreach ($members as $u): ?>
        <tr>
            <td>
                <?php if (!empty($u['profile_picture'])): ?>
                    <img src="<?= e(upload_url($u['profile_picture'])) ?>" style="width:44px;height:44px;border-radius:50%;object-fit:cover;">
                <?php else: ?>
                    <div class="avatar" style="background:<?= e(color_from_name($u['name'])) ?>"><?= e(strtoupper(substr($u['name'], 0, 1))) ?></div>
                <?php endif; ?>
            </td>
            <td><?= e($u['name']) ?></td>
            <td><?= e($u['email']) ?></td>
            <td><?= nice_date($u['created_at']) ?></td>
            <td class="row-actions">
                <a class="btn btn-small btn-danger" href="<?= url('admin/members/delete/' . (int)$u['id']) ?>" data-confirm="Delete this member? Their reviews and posts will also be removed.">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
