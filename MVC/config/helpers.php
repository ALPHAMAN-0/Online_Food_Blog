<?php
// small helpers used across the app

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
