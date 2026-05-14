<?php
// login handler
require_once __DIR__ . '/../../models/User.php';

$errors = [];
$old = ['email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pw    = $_POST['password'] ?? '';
    $remember = !empty($_POST['remember']);
    $old['email'] = $email;

    if ($email === '' || $pw === '') {
        $errors['_'] = 'Please enter your email and password.';
    } else {
        $um = new User($pdo);
        $user = $um->find_by_email($email);
        if ($user && password_verify($pw, $user['password_hash'])) {
            // good - log them in
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name']    = $user['name'];
            $_SESSION['role']    = $user['role'];

            if ($remember) {
                // random token, store hashed version, send raw to cookie
                $raw = bin2hex(random_bytes(32));
                $um->set_remember_token($user['id'], $raw);
                setcookie('remember_token', $raw, time() + (60 * 60 * 24 * 30), '/', '', false, true);
            }
            flash('flash_success', 'Welcome back, ' . $user['name'] . '!');
            redirect($user['role'] === 'admin' ? '/admin/dashboard' : '/');
        } else {
            $errors['_'] = 'Invalid email or password.';
        }
    }
}

$page_title = 'Login';
require __DIR__ . '/../../views/layouts/header.php';
require __DIR__ . '/../../views/auth/login.php';
require __DIR__ . '/../../views/layouts/footer.php';
