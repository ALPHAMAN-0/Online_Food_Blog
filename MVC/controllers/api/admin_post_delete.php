<?php
// AJAX: admin deletes any food experience post
require_once __DIR__ . '/../../models/FoodPost.php';

if (!is_admin()) json_response(['ok'=>false,'error'=>'Admins only.'], 403);

$id = (int)($_GET['id'] ?? 0);
$fpm = new FoodPost($pdo);
if (!$fpm->find($id)) json_response(['ok'=>false,'error'=>'Not found.'], 404);
$fpm->delete($id);
json_response(['ok' => true]);
