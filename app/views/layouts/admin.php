<?php
$user = auth_user();
$links = [
    ['/admin', 'Dashboard', 'fa-gauge', false],
    ['/admin/queries', 'Queries & Quotes', 'fa-inbox', true],
    ['/admin/posts', 'Blog Posts', 'fa-newspaper', true],
    ['/admin/categories', 'Categories', 'fa-tags', true],
    ['/admin/shipments', 'Shipments', 'fa-box', true],
];
if (($user['role'] ?? '') === 'admin') {
    $links[] = ['/admin/settings', 'Site Settings', 'fa-gear', true];
}
$links[] = ['/admin/account', 'My Account', 'fa-user', true];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title><?= e(($title ?? 'Admin') . ' | Admin') ?></title>
    <link rel="icon" type="image/png" href="<?= asset('assets/img/favicon.png') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="<?= asset('assets/css/app.css') ?>">
    <?= $head ?? '' ?>
</head>
<body class="bg-slate-100 lg:flex">
    <aside class="bg-navy-900 text-white lg:fixed lg:inset-y-0 lg:w-64 lg:flex lg:flex-col">
        <div class="flex items-center justify-between gap-3 border-b border-white/10 p-4">
            <a href="<?= url('/admin') ?>" class="flex items-center gap-3">
                <img src="<?= asset('assets/img/logo-mark.png') ?>" alt="" class="h-9 w-auto rounded bg-white p-1">
                <span class="text-sm font-bold leading-tight">ALPHA GSL<span class="block text-xs font-normal text-slate-400">Admin Panel</span></span>
            </a>
            <button type="button" id="menu-toggle" class="p-2 lg:hidden" aria-label="Menu" aria-controls="admin-nav"><i class="fa-solid fa-bars"></i></button>
        </div>
        <nav id="mobile-menu" class="hidden flex-1 space-y-1 p-3 lg:!block" aria-label="Admin">
            <?php foreach ($links as [$path, $label, $icon, $prefix]): ?>
                <a href="<?= url($path) ?>" class="admin-link <?= is_active($path, $prefix) ? 'active' : '' ?>"><i class="fa-solid <?= $icon ?> w-5 text-center"></i><?= $label ?></a>
            <?php endforeach; ?>
            <a href="<?= url('/') ?>" target="_blank" class="admin-link mt-4"><i class="fa-solid fa-arrow-up-right-from-square w-5 text-center"></i>View website</a>
            <form method="post" action="<?= url('admin/logout') ?>" class="mt-1">
                <?= csrf_field() ?>
                <button class="admin-link w-full"><i class="fa-solid fa-right-from-bracket w-5 text-center"></i>Sign out</button>
            </form>
            <p class="px-3 pt-4 text-xs text-slate-500">Signed in as<br><span class="text-slate-300"><?= e($user['name'] ?? '') ?></span></p>
        </nav>
    </aside>

    <div class="min-h-screen flex-1 lg:ml-64">
        <header class="border-b border-slate-200 bg-white px-6 py-4">
            <h1 class="text-xl font-extrabold"><?= e($title ?? 'Admin') ?></h1>
        </header>
        <main class="p-4 sm:p-6">
            <?php partial('partials/flash') ?>
            <?= $content ?>
        </main>
    </div>
    <script src="<?= asset('assets/js/app.js') ?>" defer></script>
</body>
</html>
