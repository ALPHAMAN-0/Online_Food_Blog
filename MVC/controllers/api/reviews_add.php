<?php
// AJAX: member posts a review on a menu item
require_once __DIR__ . '/../../models/Review.php';
require_once __DIR__ . '/../../models/MenuItem.php';

if (!is_member()) {
    json_response(['ok' => false, 'error' => 'Members only.'], 403);
}

$menu_item_id = (int)($_POST['menu_item_id'] ?? 0);
$comment      = trim($_POST['comment'] ?? '');

if ($comment === '') json_response(['ok' => false, 'error' => 'Comment can\'t be empty.'], 400);
if (strlen($comment) > 500) json_response(['ok' => false, 'error' => 'Too long (max 500).'], 400);

$mm = new MenuItem($pdo);
if (!$mm->find($menu_item_id)) {
    json_response(['ok' => false, 'error' => 'Menu item not found.'], 404);
}

$rvm = new Review($pdo);
$new_id = $rvm->create($menu_item_id, current_user_id(), $comment);

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
