<?php
// edit own post
require_login();
require_once __DIR__ . '/../../models/FoodPost.php';
require_once __DIR__ . '/../../models/Restaurant.php';
require_once __DIR__ . '/../../models/MenuItem.php';

$id = (int)($_GET['id'] ?? 0);
$fpm = new FoodPost($pdo);
$post = $fpm->find($id);
if (!$post) { http_response_code(404); die('Not found'); }

// only the author can edit
if ($post['user_id'] != current_user_id()) {
    flash('flash_error', 'You can only edit your own posts.');
    redirect('/food-experience');
}

$errors = [];
$data = [
    'title' => $post['title'],
    'content' => $post['content'],
    'post_type' => $post['post_type'],
    'restaurant_id' => $post['restaurant_id'] ?? '',
    'menu_item_id'  => $post['menu_item_id']  ?? '',
];

$rm = new Restaurant($pdo);

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

    if (empty($errors)) {
        $fpm->update($id, $data['title'], $data['content'], $data['post_type'], $rest_id, $menu_id);
        flash('flash_success', 'Post updated.');
        redirect('/food-experience/' . $id);
    }
}

$restaurants = $rm->all();
$all_items = $pdo->query("SELECT id, name, restaurant_id FROM menu_items ORDER BY name")->fetchAll();
$editing = true;

$page_title = 'Edit Post';
require __DIR__ . '/../../views/layouts/header.php';
require __DIR__ . '/../../views/foodexperience/form.php';
require __DIR__ . '/../../views/layouts/footer.php';
