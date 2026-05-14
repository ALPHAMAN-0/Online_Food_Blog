<?php
// list all restaurants for admin
require_admin();
require_once __DIR__ . '/../../models/Restaurant.php';

$rm = new Restaurant($pdo);
$restaurants = $rm->all();

$page_title = 'Manage Restaurants';
require __DIR__ . '/../../views/layouts/admin_header.php';
require __DIR__ . '/../../views/admin/restaurants_list.php';
require __DIR__ . '/../../views/layouts/admin_footer.php';
