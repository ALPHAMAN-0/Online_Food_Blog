<?php
// profile page (gated)
require_login();
require_once __DIR__ . '/../../models/User.php';

$um = new User($pdo);
$user = $um->find_by_id(current_user_id());
if (!$user) { redirect('/logout'); }

$page_title = 'My Profile';
require __DIR__ . '/../../views/layouts/header.php';
require __DIR__ . '/../../views/profile/show.php';
require __DIR__ . '/../../views/layouts/footer.php';
