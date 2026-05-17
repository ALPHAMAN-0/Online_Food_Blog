<?php
// AJAX: member posts a review on a restaurant
require_once __DIR__ . '/../../models/RestaurantReview.php';
require_once __DIR__ . '/../../models/Restaurant.php';

csrf_check();

if (!is_member()) {
    json_response(['ok' => false, 'error' => 'Members only.'], 403);
}

$restaurant_id = (int)($_POST['restaurant_id'] ?? 0);
$comment       = trim($_POST['comment'] ?? '');

if ($comment === '') json_response(['ok' => false, 'error' => 'Comment can\'t be empty.'], 400);
if (strlen($comment) > 500) json_response(['ok' => false, 'error' => 'Too long (max 500).'], 400);

$rm = new Restaurant($pdo);
if (!$rm->find($restaurant_id)) {
    json_response(['ok' => false, 'error' => 'Restaurant not found.'], 404);
}

$rrm = new RestaurantReview($pdo);
$new_id = $rrm->create($restaurant_id, current_user_id(), $comment);

json_response([
    'ok' => true,
    'review' => [
        'id'         => (int)$new_id,
        'user_id'    => (int)current_user_id(),
        'author'     => $_SESSION['name'],
        'comment'    => $comment,
        'created_at' => date('Y-m-d H:i:s'),
    ],
]);
