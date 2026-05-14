<?php
// AJAX: author deletes own food-experience comment
require_once __DIR__ . '/../../models/FoodComment.php';

if (!is_logged_in()) json_response(['ok'=>false,'error'=>'Login required.'], 401);

$id = (int)($_GET['id'] ?? 0);
$cmm = new FoodComment($pdo);
if (!$cmm->owned_by($id, current_user_id())) {
    json_response(['ok'=>false,'error'=>'You can only delete your own comment.'], 403);
}
$cmm->delete($id);
json_response(['ok' => true]);
