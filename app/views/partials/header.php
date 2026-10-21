<?php
use App\Data\Services;
$services = Services::all();
$nav = [
    ['/', 'Home', false],
    ['/about', 'About Us', false],
    ['/services', 'Services', true],
    ['/tracking', 'Tracking', false],
    ['/blog', 'Blog', true],
    ['/contact', 'Contact', false],
];
?>
<div class="hidden bg-navy-900 text-xs text-slate-300 md:block">
    <div class="container-x flex items-center justify-between py-2">
        <div class="flex items-center gap-6">
            <a href="<?= e(phone_href(setting('phone'))) ?>" class="hover:text-white"><i class="fa-solid fa-phone mr-2 text-brand-orange"></i><?= e(setting('phone')) ?></a>
            <a href="<?= e(phone_href(setting('mobile'))) ?>" class="hover:text-white"><i class="fa-solid fa-mobile-screen mr-2 text-brand-orange"></i><?= e(setting('mobile')) ?></a>
            <a href="mailto:<?= e(setting('email')) ?>" class="hover:text-white"><i class="fa-solid fa-envelope mr-2 text-brand-orange"></i><?= e(setting('email')) ?></a>
        </div>
        <div class="flex items-center gap-4">
            <span><i class="fa-regular fa-clock mr-2 text-brand-orange"></i><?= e(setting('hours')) ?></span>
            <?php foreach (['facebook' => 'fa-facebook-f', 'linkedin' => 'fa-linkedin-in', 'instagram' => 'fa-instagram'] as $k => $icon): ?>
                <?php if (setting($k) !== ''): ?>
                    <a href="<?= e(setting($k)) ?>" target="_blank" rel="noopener" aria-label="<?= e(ucfirst($k)) ?>" class="hover:text-white"><i class="fa-brands <?= $icon ?>"></i></a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<header class="sticky top-0 z-40 bg-white shadow-sm">
    <div class="container-x flex items-center justify-between py-2">
        <a href="<?= url('/') ?>" class="flex items-center" aria-label="<?= e(setting('company_name')) ?> home">
            <img src="<?= asset('assets/img/logo-mark.png') ?>" alt="" class="h-12 w-auto" width="64" height="48">
            <span class="ml-3 leading-tight">
                <span class="block text-xl font-extrabold tracking-tight text-brand-blue">ALPHA <span class="font-bold text-navy-800">GLOBAL SHIPPING</span></span>
                <span class="block text-[10px] font-semibold uppercase tracking-[0.2em] text-brand-orange">Reliable • Efficient • Worldwide</span>
            </span>
        </a>

        <nav class="hidden items-center gap-1 lg:flex" aria-label="Main">
            <?php foreach ($nav as [$path, $label, $prefix]): ?>
                <?php if ($label === 'Services'): ?>
                    <div class="group relative">
                        <a href="<?= url($path) ?>" class="nav-link <?= is_active($path, true) ? 'active' : '' ?>"><?= $label ?> <i class="fa-solid fa-chevron-down ml-1 text-[10px]"></i></a>
                        <div class="invisible absolute left-0 top-full w-72 rounded-xl border border-slate-200 bg-white p-2 opacity-0 shadow-xl transition group-hover:visible group-hover:opacity-100 group-focus-within:visible group-focus-within:opacity-100">
                            <?php foreach ($services as $slug => $s): ?>
                                <a href="<?= url('services/' . $slug) ?>" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-brand-blue-light hover:text-brand-blue">
                                    <i class="fa-solid <?= e($s['icon']) ?> w-5 text-brand-orange"></i><?= e($s['short']) ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= url($path) ?>" class="nav-link <?= ($path === '/' ? is_active('/') : is_active($path, $prefix)) ? 'active' : '' ?>"><?= $label ?></a>
                <?php endif; ?>
            <?php endforeach; ?>
            <a href="<?= url('quote') ?>" class="btn-primary ml-3">Get a Quote</a>
        </nav>

        <button type="button" id="menu-toggle" class="rounded-lg p-2 text-navy-800 lg:hidden" aria-label="Open menu" aria-expanded="false" aria-controls="mobile-menu">
            <i class="fa-solid fa-bars text-2xl"></i>
        </button>
    </div>

    <div id="mobile-menu" class="hidden border-t border-slate-200 bg-white lg:hidden">
        <div class="container-x space-y-1 py-3">
            <?php foreach ($nav as [$path, $label, $prefix]): ?>
                <a href="<?= url($path) ?>" class="block rounded-lg px-3 py-2 text-sm font-medium <?= ($path === '/' ? is_active('/') : is_active($path, $prefix)) ? 'bg-brand-blue-light text-brand-blue' : 'text-slate-700' ?>"><?= $label ?></a>
            <?php endforeach; ?>
            <a href="<?= url('quote') ?>" class="btn-primary mt-2 w-full">Get a Quote</a>
        </div>
    </div>
</header>
