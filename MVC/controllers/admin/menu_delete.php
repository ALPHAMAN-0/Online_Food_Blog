<?php
require_admin();
require_once __DIR__ . '/../../models/MenuItem.php';

$id = (int)($_GET['id'] ?? 0);
$mm = new MenuItem($pdo);
$item = $mm->find($id);
$back = '/admin/restaurants';
if ($item) {
    $back = '/admin/menu/list/' . (int)$item['restaurant_id'];
    $mm->delete($id);
    flash('flash_success', 'Menu item deleted.');
} else {
    flash('flash_error', 'Item not found.');
}
redirect($back);
