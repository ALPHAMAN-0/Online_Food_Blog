<?php
// create or edit a menu item (with image upload)
require_admin();
require_once __DIR__ . '/../../models/Restaurant.php';
require_once __DIR__ . '/../../models/MenuItem.php';

$mm = new MenuItem($pdo);
$rm = new Restaurant($pdo);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$editing = $id > 0;
$errors = [];
$data = ['restaurant_id'=>0, 'name'=>'', 'description'=>'', 'price'=>'', 'image_path'=>null];

if ($editing) {
    $it = $mm->find($id);
    if (!$it) { http_response_code(404); die('Not found'); }
    $data = $it;
    $data['restaurant_id'] = (int)$it['restaurant_id'];
} else {
    $data['restaurant_id'] = (int)($_GET['restaurant_id'] ?? 0);
}

$restaurant = $rm->find($data['restaurant_id']);
if (!$restaurant) { http_response_code(404); die('Restaurant not found'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['name']        = trim($_POST['name'] ?? '');
    $data['description'] = trim($_POST['description'] ?? '');
    $price_raw           = $_POST['price'] ?? '';
    $data['price']       = $price_raw;

    if ($data['name'] === '') $errors['name'] = 'Name is required.';
    if (!is_numeric($price_raw) || (float)$price_raw <= 0) $errors['price'] = 'Price must be greater than 0.';

    $new_image_path = null;
    if (!empty($_FILES['image']['name'])) {
        $res = upload_image($_FILES['image'], 'menu');
        if (is_array($res) && isset($res['error'])) {
            $errors['image'] = $res['error'];
        } else {
            $new_image_path = $res;
        }
    }

    if (empty($errors)) {
        if ($editing) {
            $mm->update($id, $data['name'], $data['description'], (float)$price_raw, $new_image_path);
            flash('flash_success', 'Menu item updated.');
        } else {
            $mm->create($data['restaurant_id'], $data['name'], $data['description'], (float)$price_raw, $new_image_path);
            flash('flash_success', 'Menu item added.');
        }
        redirect('/admin/menu/list/' . (int)$data['restaurant_id']);
    }
}

$page_title = $editing ? 'Edit Menu Item' : 'New Menu Item';
require __DIR__ . '/../../views/layouts/admin_header.php';
require __DIR__ . '/../../views/admin/menu_form.php';
require __DIR__ . '/../../views/layouts/admin_footer.php';
