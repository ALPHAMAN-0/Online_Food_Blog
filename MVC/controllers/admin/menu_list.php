<?php
// list menu items for a given restaurant
require_admin();
require_once __DIR__ . '/../../models/Restaurant.php';
require_once __DIR__ . '/../../models/MenuItem.php';

$restaurant_id = (int)($_GET['restaurant_id'] ?? 0);
$rm = new Restaurant($pdo);
$mm = new MenuItem($pdo);

$restaurant = $rm->find($restaurant_id);
if (!$restaurant) { http_response_code(404); die('Restaurant not found'); }
$items = $mm->by_restaurant($restaurant_id);

$page_title = 'Menu - ' . $restaurant['name'];
require __DIR__ . '/../../views/layouts/admin_header.php';
require __DIR__ . '/../../views/admin/menu_list.php';
require __DIR__ . '/../../views/layouts/admin_footer.php';
