<?php
// create / edit a restaurant
require_admin();
require_once __DIR__ . '/../../models/Restaurant.php';

$rm = new Restaurant($pdo);
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$editing = $id > 0;
$errors = [];

$data = ['name'=>'', 'location'=>'', 'area'=>'', 'short_background'=>'', 'goals'=>''];

if ($editing) {
    $r = $rm->find($id);
    if (!$r) { http_response_code(404); die('Not found'); }
    $data = $r;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['name']             = trim($_POST['name'] ?? '');
    $data['location']         = trim($_POST['location'] ?? '');
    $data['area']             = trim($_POST['area'] ?? '');
    $data['short_background'] = trim($_POST['short_background'] ?? '');
    $data['goals']            = trim($_POST['goals'] ?? '');

    if ($data['name'] === '')     $errors['name']     = 'Name is required.';
    if ($data['location'] === '') $errors['location'] = 'Location is required.';
    if ($data['area'] === '')     $errors['area']     = 'Area is required.';
    if (strlen($data['name']) > 150) $errors['name'] = 'Name too long.';

    if (empty($errors)) {
        if ($editing) {
            $rm->update($id, $data['name'], $data['location'], $data['area'], $data['short_background'], $data['goals']);
            flash('flash_success', 'Restaurant updated.');
        } else {
            $rm->create($data['name'], $data['location'], $data['area'], $data['short_background'], $data['goals']);
            flash('flash_success', 'Restaurant added.');
        }
        redirect('/admin/restaurants');
    }
}

$page_title = $editing ? 'Edit Restaurant' : 'New Restaurant';
require __DIR__ . '/../../views/layouts/admin_header.php';
require __DIR__ . '/../../views/admin/restaurants_form.php';
require __DIR__ . '/../../views/layouts/admin_footer.php';
