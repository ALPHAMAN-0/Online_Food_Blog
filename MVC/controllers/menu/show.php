<?php
// menu item detail page (public view, member review form)
require_once __DIR__ . '/../../models/MenuItem.php';
require_once __DIR__ . '/../../models/Review.php';

$id = (int)($_GET['id'] ?? 0);
$mm = new MenuItem($pdo);
$item = $mm->find_with_restaurant($id);

if (!$item) {
    http_response_code(404);
    $page_title = 'Not found';
    require __DIR__ . '/../../views/layouts/header.php';
    echo '<div class="container"><h1>Item not found</h1><a class="btn" href="' . url('restaurants') . '">Back</a></div>';
    require __DIR__ . '/../../views/layouts/footer.php';
    return;
}

$rvm = new Review($pdo);
$reviews = $rvm->by_menu_item($id);

$page_title = $item['name'];
require __DIR__ . '/../../views/layouts/header.php';
require __DIR__ . '/../../views/menu/show.php';
require __DIR__ . '/../../views/layouts/footer.php';
