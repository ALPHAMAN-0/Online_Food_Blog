<?php
// food experience listing (public view)
require_once __DIR__ . '/../../models/FoodPost.php';

$fpm = new FoodPost($pdo);
$posts = $fpm->all_with_author();

$page_title = 'Food Experience';
require __DIR__ . '/../../views/layouts/header.php';
require __DIR__ . '/../../views/foodexperience/index.php';
require __DIR__ . '/../../views/layouts/footer.php';
