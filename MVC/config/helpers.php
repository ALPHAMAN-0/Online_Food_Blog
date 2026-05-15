<?php
// small helpers used across the app

// base url - auto-detected from the script location so the app works whether
// it's served at the document root (http://host/) or in a subfolder
// (http://host/Online_Food_Blog/MVC/)
if (!defined('BASE_URL')) {
    $base = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    define('BASE_URL', rtrim($base === '/' ? '' : $base, '/'));
}

// build a url to an app route, e.g. url('restaurants/5') -> /Online_Food_Blog/MVC/restaurants/5
function url($path = '') {
    return BASE_URL . '/' . ltrim($path, '/');
}

// build a url to a static asset under public/, e.g. asset('css/style.css')
function asset($path) {
    return BASE_URL . '/public/' . ltrim($path, '/');
}

// turn a stored upload path (which may start with / or public/) into a browser-safe url
function upload_url($stored) {
    if (!$stored) return '';
    // already absolute http(s) url - leave it
    if (preg_match('#^https?://#i', $stored)) return $stored;
    return BASE_URL . '/' . ltrim($stored, '/');
}

// escape for html output
function e($s) {
    return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}

// flash message - set or get
function flash($key, $val = null) {
    if ($val === null) {
        $msg = $_SESSION[$key] ?? null;
        unset($_SESSION[$key]);
        return $msg;
    }
    $_SESSION[$key] = $val;
}

function redirect($url) {
    // prefix BASE_URL for app-relative paths so callers can keep passing "/login" etc.
    if (isset($url[0]) && $url[0] === '/' && substr($url, 0, 2) !== '//') {
        $url = BASE_URL . $url;
    }
    header("Location: $url");
    exit;
}

// json response helper for ajax endpoints
function json_response($data, $code = 200) {
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

// upload an image file, returns relative path or false
function upload_image($file, $folder) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }
    // size cap 2MB
    if ($file['size'] > 2 * 1024 * 1024) {
        return ['error' => 'File too big. Max 2MB.'];
    }
    // mime check
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png'];
    if (!isset($allowed[$mime])) {
        return ['error' => 'Only JPEG/PNG allowed.'];
    }
    $ext = $allowed[$mime];
    $target_dir = __DIR__ . '/../public/uploads/' . $folder . '/';
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0775, true);
    }
    $filename = uniqid('img_', true) . '.' . $ext;
    $dest = $target_dir . $filename;
    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        return ['error' => 'Failed to save upload.'];
    }
    // return path that will work from web root
    return '/public/uploads/' . $folder . '/' . $filename;
}

// little colour from a name (for avatar bubbles)
function color_from_name($name) {
    $hash = crc32($name);
    $hue = $hash % 360;
    return "hsl($hue, 55%, 60%)";
}

// short date format
function nice_date($ts) {
    return date('M j, Y g:i a', strtotime($ts));
}
