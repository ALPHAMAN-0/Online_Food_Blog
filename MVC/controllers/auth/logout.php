<?php
// destroy session + remove remember cookie/token

require_once __DIR__ . '/../../models/User.php';

if (is_logged_in()) {
    $um = new User($pdo);
    $um->clear_remember_token(current_user_id());
}

// nuke cookie if present
if (isset($_COOKIE['remember_token'])) {
    setcookie('remember_token', '', time() - 3600, '/');
}

$_SESSION = [];
session_destroy();

// start fresh session just so flash works on next page
session_start();
flash('flash_success', 'You have been logged out.');
redirect('/');
