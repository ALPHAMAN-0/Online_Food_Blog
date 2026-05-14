<?php
// admin deletes a member - schema cascade handles their reviews/posts/comments
require_admin();
require_once __DIR__ . '/../../models/User.php';

$id = (int)($_GET['id'] ?? 0);
$um = new User($pdo);
$ok = $um->delete_user($id);
if ($ok) {
    flash('flash_success', 'Member removed.');
} else {
    flash('flash_error', 'Could not delete that user (admins are not removable here).');
}
redirect('/admin/members');
