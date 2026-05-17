<?php
require_once __DIR__ . '/../../models/Restaurant.php';
$rm = new Restaurant($pdo);
$restaurants = $rm->all();
$featured = array_slice($restaurants, 0, 6);
$page_title = 'Home';
require __DIR__ . '/../../views/layouts/header.php';
require __DIR__ . '/../../views/home/index.php';
require __DIR__ . '/../../views/layouts/footer.php';
