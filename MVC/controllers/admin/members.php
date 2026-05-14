<?php
// list all members (admin moderation)
require_admin();
require_once __DIR__ . '/../../models/User.php';

$um = new User($pdo);
$members = $um->list_members();

$page_title = 'Members';
require __DIR__ . '/../../views/layouts/admin_header.php';
require __DIR__ . '/../../views/admin/members.php';
require __DIR__ . '/../../views/layouts/admin_footer.php';
