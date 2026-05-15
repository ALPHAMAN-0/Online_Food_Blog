<?php
// front controller - routes everything

require_once __DIR__ . '/config/helpers.php';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/config/session.php';

$route = $_GET['route'] ?? 'home';
$route = trim($route, '/');

// when running with php -S the built-in server serves /public/... files
// directly, but only if the file exists. this just makes sure of that.
if (preg_match('#^public/#', $route)) {
    $file = __DIR__ . '/' . $route;
    if (is_file($file)) {
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $types = [
            'css' => 'text/css', 'js' => 'application/javascript',
            'png' => 'image/png', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg',
            'gif' => 'image/gif', 'svg' => 'image/svg+xml',
        ];
        if (isset($types[$ext])) header('Content-Type: ' . $types[$ext]);
        readfile($file);
        exit;
    }
}

// route - using if/elseif so regex routes work properly
$m = [];

if ($route === '' || $route === 'home') {
    require __DIR__ . '/controllers/home/index.php';
}

// auth
elseif ($route === 'register') {
    require __DIR__ . '/controllers/auth/register.php';
}
elseif ($route === 'login') {
    require __DIR__ . '/controllers/auth/login.php';
}
elseif ($route === 'logout') {
    require __DIR__ . '/controllers/auth/logout.php';
}

// profile
elseif ($route === 'profile') {
    require __DIR__ . '/controllers/profile/show.php';
}
elseif ($route === 'profile/update') {
    require __DIR__ . '/controllers/profile/update.php';
}
elseif ($route === 'profile/password') {
    require __DIR__ . '/controllers/profile/password.php';
}

// public browse - restaurants and menu items
elseif ($route === 'restaurants') {
    require __DIR__ . '/controllers/restaurants/index.php';
}
elseif (preg_match('#^restaurants/(\d+)$#', $route, $m)) {
    $_GET['id'] = $m[1];
    require __DIR__ . '/controllers/restaurants/show.php';
}
elseif (preg_match('#^menu/(\d+)$#', $route, $m)) {
    $_GET['id'] = $m[1];
    require __DIR__ . '/controllers/menu/show.php';
}

// admin
elseif ($route === 'admin' || $route === 'admin/dashboard') {
    require __DIR__ . '/controllers/admin/dashboard.php';
}
elseif ($route === 'admin/restaurants') {
    require __DIR__ . '/controllers/admin/restaurants_list.php';
}
elseif ($route === 'admin/restaurants/new') {
    require __DIR__ . '/controllers/admin/restaurants_form.php';
}
elseif (preg_match('#^admin/restaurants/edit/(\d+)$#', $route, $m)) {
    $_GET['id'] = $m[1];
    require __DIR__ . '/controllers/admin/restaurants_form.php';
}
elseif (preg_match('#^admin/restaurants/delete/(\d+)$#', $route, $m)) {
    $_GET['id'] = $m[1];
    require __DIR__ . '/controllers/admin/restaurants_delete.php';
}
elseif (preg_match('#^admin/menu/list/(\d+)$#', $route, $m)) {
    $_GET['restaurant_id'] = $m[1];
    require __DIR__ . '/controllers/admin/menu_list.php';
}
elseif (preg_match('#^admin/menu/new/(\d+)$#', $route, $m)) {
    $_GET['restaurant_id'] = $m[1];
    require __DIR__ . '/controllers/admin/menu_form.php';
}
elseif (preg_match('#^admin/menu/edit/(\d+)$#', $route, $m)) {
    $_GET['id'] = $m[1];
    require __DIR__ . '/controllers/admin/menu_form.php';
}
elseif (preg_match('#^admin/menu/delete/(\d+)$#', $route, $m)) {
    $_GET['id'] = $m[1];
    require __DIR__ . '/controllers/admin/menu_delete.php';
}
elseif ($route === 'admin/members') {
    require __DIR__ . '/controllers/admin/members.php';
}
elseif (preg_match('#^admin/members/delete/(\d+)$#', $route, $m)) {
    $_GET['id'] = $m[1];
    require __DIR__ . '/controllers/admin/members_delete.php';
}

// food experience
elseif ($route === 'food-experience' || $route === 'food-experience/index') {
    require __DIR__ . '/controllers/foodexperience/index.php';
}
elseif ($route === 'food-experience/new') {
    require __DIR__ . '/controllers/foodexperience/create.php';
}
elseif (preg_match('#^food-experience/(\d+)$#', $route, $m)) {
    $_GET['id'] = $m[1];
    require __DIR__ . '/controllers/foodexperience/show.php';
}
elseif (preg_match('#^food-experience/edit/(\d+)$#', $route, $m)) {
    $_GET['id'] = $m[1];
    require __DIR__ . '/controllers/foodexperience/edit.php';
}
elseif (preg_match('#^food-experience/delete/(\d+)$#', $route, $m)) {
    $_GET['id'] = $m[1];
    require __DIR__ . '/controllers/foodexperience/delete.php';
}

// ajax / api
elseif ($route === 'api/search') {
    require __DIR__ . '/controllers/api/search.php';
}
elseif ($route === 'api/reviews/add') {
    require __DIR__ . '/controllers/api/reviews_add.php';
}
elseif (preg_match('#^api/reviews/(\d+)$#', $route, $m)) {
    $_GET['id'] = $m[1];
    require __DIR__ . '/controllers/api/reviews_delete.php';
}
elseif ($route === 'api/food-exp/comments/add') {
    require __DIR__ . '/controllers/api/foodexp_comment_add.php';
}
elseif (preg_match('#^api/food-exp/comments/(\d+)$#', $route, $m)) {
    $_GET['id'] = $m[1];
    require __DIR__ . '/controllers/api/foodexp_comment_delete.php';
}
elseif (preg_match('#^api/admin/reviews/(\d+)$#', $route, $m)) {
    $_GET['id'] = $m[1];
    require __DIR__ . '/controllers/api/admin_review_delete.php';
}
elseif (preg_match('#^api/admin/posts/(\d+)$#', $route, $m)) {
    $_GET['id'] = $m[1];
    require __DIR__ . '/controllers/api/admin_post_delete.php';
}
elseif (preg_match('#^api/admin/comments/(\d+)$#', $route, $m)) {
    $_GET['id'] = $m[1];
    require __DIR__ . '/controllers/api/admin_comment_delete.php';
}

else {
    http_response_code(404);
    $page_title = '404 Not Found';
    require __DIR__ . '/views/layouts/header.php';
    echo '<div class="container"><h1>Page not found</h1><p>Sorry, that page does not exist.</p><a class="btn" href="' . url() . '">Back home</a></div>';
    require __DIR__ . '/views/layouts/footer.php';
}
