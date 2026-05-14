<?php
// update name / email / photo
require_login();
require_once __DIR__ . '/../../models/User.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('/profile');

$name  = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    flash('flash_error', 'Please provide a valid name and email.');
    redirect('/profile');
}

$um = new User($pdo);

// check email not used by someone else
$other = $um->find_by_email($email);
if ($other && $other['id'] != current_user_id()) {
    flash('flash_error', 'That email is already in use.');
    redirect('/profile');
}

// optional photo
$picture_path = null;
if (!empty($_FILES['picture']['name'])) {
    $res = upload_image($_FILES['picture'], 'profiles');
    if (is_array($res) && isset($res['error'])) {
        flash('flash_error', $res['error']);
        redirect('/profile');
    }
    $picture_path = $res;
}

$um->update_profile(current_user_id(), $name, $email, $picture_path);
$_SESSION['name'] = $name; // keep navbar in sync
flash('flash_success', 'Profile updated.');
redirect('/profile');
