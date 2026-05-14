<?php
// register form + handler
require_once __DIR__ . '/../../models/User.php';

$errors = [];
$old = ['name' => '', 'email' => '', 'role' => 'member'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pw    = $_POST['password'] ?? '';
    $pw2   = $_POST['password_confirm'] ?? '';
    $role  = $_POST['role'] ?? 'member';

    $old['name']  = $name;
    $old['email'] = $email;
    $old['role']  = $role;

    // server-side validation
    if ($name === '')  $errors['name']  = 'Name is required.';
    if ($email === '') $errors['email'] = 'Email is required.';
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Invalid email format.';
    if (strlen($pw) < 8) $errors['password'] = 'Password must be at least 8 characters.';
    if ($pw !== $pw2) $errors['password_confirm'] = 'Passwords do not match.';
    if (!in_array($role, ['admin', 'member'], true)) $errors['role'] = 'Pick a valid role.';

    if (empty($errors)) {
        $um = new User($pdo);
        if ($um->find_by_email($email)) {
            $errors['email'] = 'That email is already registered.';
        } else {
            $um->register($name, $email, $pw, $role);
            flash('flash_success', 'Account created. Please log in.');
            redirect('/login');
        }
    }
}

$page_title = 'Register';
require __DIR__ . '/../../views/layouts/header.php';
require __DIR__ . '/../../views/auth/register.php';
require __DIR__ . '/../../views/layouts/footer.php';
