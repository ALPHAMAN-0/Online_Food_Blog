<?php
// admin dashboard - shows summary counts
require_admin();
require_once __DIR__ . '/../../models/Restaurant.php';
require_once __DIR__ . '/../../models/MenuItem.php';
require_once __DIR__ . '/../../models/Review.php';
require_once __DIR__ . '/../../models/FoodPost.php';

$rm  = new Restaurant($pdo);
$mm  = new MenuItem($pdo);
$rvm = new Review($pdo);
$fpm = new FoodPost($pdo);

$counts = [
    'restaurants' => $rm->count_all(),
    'menu_items'  => $mm->count_all(),
    'reviews'     => $rvm->count_all(),
    'fe_posts'    => $fpm->count_all(),
];

$page_title = 'Admin Dashboard';
require __DIR__ . '/../../views/layouts/admin_header.php';
require __DIR__ . '/../../views/admin/dashboard.php';
require __DIR__ . '/../../views/layouts/admin_footer.php';
