<?php
// delete a restaurant (cascade removes its menu items)
require_admin();
require_once __DIR__ . '/../../models/Restaurant.php';

$id = (int)($_GET['id'] ?? 0);
$rm = new Restaurant($pdo);
$rm->delete($id);
flash('flash_success', 'Restaurant deleted.');
redirect('/admin/restaurants');
