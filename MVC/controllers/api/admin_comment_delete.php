<?php
// AJAX: admin deletes any food experience comment
require_once __DIR__ . '/../../models/FoodComment.php';

if (!is_admin()) json_response(['ok'=>false,'error'=>'Admins only.'], 403);

$id = (int)($_GET['id'] ?? 0);
$cmm = new FoodComment($pdo);
if (!$cmm->find($id)) json_response(['ok'=>false,'error'=>'Not found.'], 404);
$cmm->delete($id);
json_response(['ok' => true]);
