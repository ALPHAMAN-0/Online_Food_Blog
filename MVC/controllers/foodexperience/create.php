<?php
// create a new food experience post
require_login();
require_once __DIR__ . '/../../models/FoodPost.php';
require_once __DIR__ . '/../../models/Restaurant.php';
require_once __DIR__ . '/../../models/MenuItem.php';

if (!is_member() && !is_admin()) {
    flash('flash_error', 'Members and admins only.');
    redirect('/food-experience');
}

$fpm = new FoodPost($pdo);
$rm  = new Restaurant($pdo);

$errors = [];
$data = ['title' => '', 'content' => '', 'post_type' => 'food', 'restaurant_id' => '', 'menu_item_id' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['title']         = trim($_POST['title'] ?? '');
    $data['content']       = trim($_POST['content'] ?? '');
    $data['post_type']     = $_POST['post_type'] ?? 'food';
    $data['restaurant_id'] = trim($_POST['restaurant_id'] ?? '');
    $data['menu_item_id']  = trim($_POST['menu_item_id'] ?? '');

    if ($data['title'] === '')   $errors['title']   = 'Title is required.';
    if ($data['content'] === '') $errors['content'] = 'Content is required.';
    if (!in_array($data['post_type'], ['restaurant','food','both'], true)) $errors['post_type'] = 'Invalid type.';

    $rest_id = $data['restaurant_id'] !== '' ? (int)$data['restaurant_id'] : null;
    $menu_id = $data['menu_item_id']  !== '' ? (int)$data['menu_item_id']  : null;

    if ($rest_id && !$rm->find($rest_id)) $errors['restaurant_id'] = 'Restaurant not found.';
    if ($menu_id) {
        $mm = new MenuItem($pdo);
        if (!$mm->find($menu_id)) $errors['menu_item_id'] = 'Menu item not found.';
    }

    if (empty($errors)) {
        $new_id = $fpm->create(current_user_id(), $data['title'], $data['content'], $data['post_type'], $rest_id, $menu_id);
        flash('flash_success', 'Your experience is published.');
        redirect('/food-experience/' . (int)$new_id);
    }
}

$restaurants = $rm->all();
$mm = new MenuItem($pdo);
// all menu items for dropdown (small lists in this project)
$all_items = $pdo->query("SELECT id, name, restaurant_id FROM menu_items ORDER BY name")->fetchAll();

$page_title = 'New Food Experience';
require __DIR__ . '/../../views/layouts/header.php';
require __DIR__ . '/../../views/foodexperience/form.php';
require __DIR__ . '/../../views/layouts/footer.php';
