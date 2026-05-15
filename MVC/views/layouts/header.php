<?php
// shared header partial. expects $page_title optionally set
$title = isset($page_title) ? $page_title . ' - Foodly' : 'Foodly - Online Food Blog';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <script>window.BASE_URL = <?= json_encode(BASE_URL) ?>;</script>
</head>
<body>

<nav class="navbar">
    <div class="nav-inner">
        <a class="brand" href="<?= url() ?>">Foodly<span class="dot">.</span></a>
        <ul class="nav-links">
            <li><a href="<?= url('restaurants') ?>">Restaurants</a></li>
            <li><a href="<?= url('food-experience') ?>">Food Experience</a></li>
            <?php if (is_admin()): ?>
                <li><a href="<?= url('admin/dashboard') ?>">Admin</a></li>
            <?php endif; ?>
            <?php if (is_logged_in()): ?>
                <li><a href="<?= url('profile') ?>"><?= e($_SESSION['name']) ?></a></li>
                <li><a href="<?= url('logout') ?>">Logout</a></li>
            <?php else: ?>
                <li><a href="<?= url('login') ?>">Login</a></li>
                <li><a href="<?= url('register') ?>" class="btn btn-small">Join</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<?php
$err = flash('flash_error');
$ok  = flash('flash_success');
?>
<?php if ($err || $ok): ?>
<div class="container" style="padding-top:1.5rem;padding-bottom:0;">
    <?php if ($err): ?><div class="flash flash-error"><?= e($err) ?></div><?php endif; ?>
    <?php if ($ok): ?><div class="flash flash-success"><?= e($ok) ?></div><?php endif; ?>
</div>
<?php endif; ?>
