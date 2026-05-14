<?php
// browse all restaurants (public)
require_once __DIR__ . '/../../models/Restaurant.php';

$rm = new Restaurant($pdo);
$q   = trim($_GET['q'] ?? '');
$loc = trim($_GET['location'] ?? '');
$ar  = trim($_GET['area'] ?? '');
$restaurants = $rm->search($q, $loc, $ar);

$page_title = 'Restaurants';
require __DIR__ . '/../../views/layouts/header.php';
require __DIR__ . '/../../views/restaurants/index.php';
require __DIR__ . '/../../views/layouts/footer.php';
