<?php
// author deletes their own post (non-ajax fallback)
require_login();
require_once __DIR__ . '/../../models/FoodPost.php';

$id = (int)($_GET['id'] ?? 0);
$fpm = new FoodPost($pdo);

if (!$fpm->owned_by($id, current_user_id())) {
    flash('flash_error', 'You can only delete your own posts.');
    redirect('/food-experience');
}
$fpm->delete($id);
flash('flash_success', 'Post deleted.');
redirect('/food-experience');
