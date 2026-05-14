<?php
// AJAX: add a comment to a food experience post
require_once __DIR__ . '/../../models/FoodPost.php';
require_once __DIR__ . '/../../models/FoodComment.php';

if (!is_logged_in()) json_response(['ok'=>false,'error'=>'Login required.'], 401);
if (is_admin() === false && is_member() === false) json_response(['ok'=>false,'error'=>'Members and admins only.'], 403);

$post_id = (int)($_POST['post_id'] ?? 0);
$comment = trim($_POST['comment'] ?? '');

if ($comment === '') json_response(['ok'=>false,'error'=>'Empty comment.'], 400);
if (strlen($comment) > 500) json_response(['ok'=>false,'error'=>'Too long (max 500).'], 400);

$fpm = new FoodPost($pdo);
if (!$fpm->find($post_id)) json_response(['ok'=>false,'error'=>'Post not found.'], 404);

$cmm = new FoodComment($pdo);
$new_id = $cmm->create($post_id, current_user_id(), $comment);

json_response([
    'ok' => true,
    'comment' => [
        'id'         => (int)$new_id,
        'user_id'    => (int)current_user_id(),
        'author'     => $_SESSION['name'],
        'comment'    => $comment,
        'created_at' => date('Y-m-d H:i:s'),
    ],
]);
