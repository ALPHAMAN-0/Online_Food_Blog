<?php
// AJAX: admin deletes any restaurant review
require_once __DIR__ . '/../../models/RestaurantReview.php';

csrf_check();

if (!is_admin()) json_response(['ok'=>false,'error'=>'Admins only.'], 403);

$id = (int)($_GET['id'] ?? 0);
$rrm = new RestaurantReview($pdo);
if (!$rrm->find($id)) json_response(['ok'=>false,'error'=>'Not found.'], 404);
$rrm->delete($id);
json_response(['ok' => true]);
