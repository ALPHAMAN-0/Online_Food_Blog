<?php
// admin layout - same top navbar but adds a side rail
require __DIR__ . '/header.php';
$current = $_GET['route'] ?? '';
?>
<div class="admin-wrap">
    <aside class="admin-side">
        <h3>Admin Panel</h3>
        <ul>
            <li><a href="<?= url('admin/dashboard') ?>" class="<?= $current === 'admin/dashboard' || $current === 'admin' ? 'active' : '' ?>">Dashboard</a></li>
            <li><a href="<?= url('admin/restaurants') ?>" class="<?= strpos($current, 'admin/restaurants') === 0 ? 'active' : '' ?>">Restaurants</a></li>
            <li><a href="<?= url('admin/members') ?>" class="<?= strpos($current, 'admin/members') === 0 ? 'active' : '' ?>">Members</a></li>
            <li><a href="<?= url('food-experience') ?>">Food Experience</a></li>
        </ul>
    </aside>
    <main class="admin-body">
