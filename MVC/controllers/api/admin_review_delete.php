<?php
// AJAX: admin deletes any review
require_once __DIR__ . '/../../models/Review.php';

if (!is_admin()) json_response(['ok'=>false,'error'=>'Admins only.'], 403);

$id = (int)($_GET['id'] ?? 0);
$rvm = new Review($pdo);
if (!$rvm->find($id)) json_response(['ok'=>false,'error'=>'Not found.'], 404);
$rvm->delete($id);
json_response(['ok' => true]);
