<?php
// single restaurant page (public) - shows info + menu items
require_once __DIR__ . '/../../models/Restaurant.php';
require_once __DIR__ . '/../../models/MenuItem.php';

$id = (int)($_GET['id'] ?? 0);
$rm = new Restaurant($pdo);
$mm = new MenuItem($pdo);
$restaurant = $rm->find($id);
if (!$restaurant) {
    http_response_code(404);
    $page_title = 'Not found';
    require __DIR__ . '/../../views/layouts/header.php';
    echo '<div class="container"><h1>Restaurant not found</h1><a class="btn" href="' . url('restaurants') . '">Back</a></div>';
    require __DIR__ . '/../../views/layouts/footer.php';
    return;
}
$items = $mm->by_restaurant($id);

$page_title = $restaurant['name'];
require __DIR__ . '/../../views/layouts/header.php';
require __DIR__ . '/../../views/restaurants/show.php';
require __DIR__ . '/../../views/layouts/footer.php';
