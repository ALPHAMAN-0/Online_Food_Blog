<?php
// single food experience post + comments
require_once __DIR__ . '/../../models/FoodPost.php';
require_once __DIR__ . '/../../models/FoodComment.php';

$id = (int)($_GET['id'] ?? 0);
$fpm = new FoodPost($pdo);
$cmm = new FoodComment($pdo);

$post = $fpm->find_with_author($id);
if (!$post) {
    http_response_code(404);
    $page_title = 'Not found';
    require __DIR__ . '/../../views/layouts/header.php';
    echo '<div class="container"><h1>Post not found</h1><a class="btn" href="' . url('food-experience') . '">Back</a></div>';
    require __DIR__ . '/../../views/layouts/footer.php';
    return;
}
$comments = $cmm->by_post($id);

$page_title = $post['title'];
require __DIR__ . '/../../views/layouts/header.php';
require __DIR__ . '/../../views/foodexperience/show.php';
require __DIR__ . '/../../views/layouts/footer.php';
