<?php
// AJAX: member deletes their own restaurant review
require_once __DIR__ . '/../../models/RestaurantReview.php';

csrf_check();

if (!is_logged_in()) json_response(['ok'=>false,'error'=>'Login required.'], 401);

$id = (int)($_GET['id'] ?? 0);
$rrm = new RestaurantReview($pdo);
if (!$rrm->owned_by($id, current_user_id())) {
    json_response(['ok' => false, 'error' => 'You can only delete your own review.'], 403);
}
$rrm->delete($id);
json_response(['ok' => true]);
