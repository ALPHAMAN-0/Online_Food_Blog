<?php
// AJAX: member deletes their own review
require_once __DIR__ . '/../../models/Review.php';

if (!is_logged_in()) json_response(['ok'=>false,'error'=>'Login required.'], 401);

$id = (int)($_GET['id'] ?? 0);
$rvm = new Review($pdo);
if (!$rvm->owned_by($id, current_user_id())) {
    json_response(['ok' => false, 'error' => 'You can only delete your own review.'], 403);
}
$rvm->delete($id);
json_response(['ok' => true]);
