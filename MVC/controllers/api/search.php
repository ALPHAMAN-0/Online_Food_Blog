<?php
// AJAX search - returns restaurants + menu items matching the query
require_once __DIR__ . '/../../models/Restaurant.php';
require_once __DIR__ . '/../../models/MenuItem.php';

$q   = trim($_GET['q'] ?? '');
$loc = trim($_GET['location'] ?? '');
$ar  = trim($_GET['area'] ?? '');

$rm = new Restaurant($pdo);
$mm = new MenuItem($pdo);

$restaurants = $rm->search($q, $loc, $ar);
$items = $q !== '' ? $mm->search($q) : [];

json_response([
    'restaurants' => $restaurants,
    'items'       => $items,
]);
