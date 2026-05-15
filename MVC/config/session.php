<?php
// session bootstrap + auth helpers

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// try to restore session from remember-me cookie
if (!isset($_SESSION['user_id']) && !empty($_COOKIE['remember_token'])) {
    require_once __DIR__ . '/db.php';
    $hashed = hash('sha256', $_COOKIE['remember_token']);
    $stmt = $pdo->prepare("SELECT id, name, role FROM users WHERE remember_token = ? LIMIT 1");
    $stmt->execute([$hashed]);
    $u = $stmt->fetch();
    if ($u) {
        $_SESSION['user_id'] = $u['id'];
        $_SESSION['name']    = $u['name'];
        $_SESSION['role']    = $u['role'];
    }
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function is_member() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'member';
}

function current_user_id() {
    return $_SESSION['user_id'] ?? null;
}

function require_login() {
    if (!is_logged_in()) {
        $_SESSION['flash_error'] = 'Please log in first.';
        redirect('/login');
    }
}

function require_admin() {
    require_login();
    if (!is_admin()) {
        http_response_code(403);
        die('Access denied. Admins only.');
    }
}

function require_member() {
    require_login();
    if (!is_member()) {
        http_response_code(403);
        die('Members only.');
    }
}
