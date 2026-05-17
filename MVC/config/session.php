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

// CSRF helpers
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field() {
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') . '">';
}

function csrf_check() {
    $sent = $_POST['csrf_token'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $sent)) {
        $is_api = strpos($_SERVER['REQUEST_URI'] ?? '', '/api/') !== false
               || strpos($_GET['route'] ?? '', 'api/') === 0;
        if ($is_api) {
            json_response(['ok' => false, 'error' => 'CSRF token mismatch.'], 419);
        }
        http_response_code(419);
        die('CSRF token mismatch. Please go back and try again.');
    }
}
