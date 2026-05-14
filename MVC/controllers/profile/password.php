<?php
// change password (requires current password)
require_login();
require_once __DIR__ . '/../../models/User.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('/profile');

$current = $_POST['current'] ?? '';
$new     = $_POST['new'] ?? '';
$confirm = $_POST['confirm'] ?? '';

if (strlen($new) < 8) {
    flash('flash_error', 'New password must be at least 8 characters.');
    redirect('/profile');
}
if ($new !== $confirm) {
    flash('flash_error', 'New passwords do not match.');
    redirect('/profile');
}

$um = new User($pdo);
$user = $um->find_by_id(current_user_id());
if (!$user || !password_verify($current, $user['password_hash'])) {
    flash('flash_error', 'Current password is wrong.');
    redirect('/profile');
}

$um->change_password($user['id'], $new);
flash('flash_success', 'Password changed.');
redirect('/profile');
