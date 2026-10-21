<?php use App\Data\Services; ?>
<footer class="bg-navy-900 text-slate-300">
    <div class="container-x grid gap-10 py-14 md:grid-cols-2 lg:grid-cols-4">
        <div>
            <img src="<?= asset('assets/img/logo-full.png') ?>" alt="<?= e(setting('company_name')) ?>" class="mb-4 w-56 rounded-lg bg-white p-2" loading="lazy" width="224" height="111">
            <p class="text-sm leading-relaxed text-slate-400">Your trusted freight forwarding partner in Karachi, moving cargo reliably and efficiently to destinations worldwide.</p>
        </div>
        <div>
            <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-white">Quick Links</h3>
            <ul class="space-y-2 text-sm">
                <?php foreach ([['/', 'Home'], ['/about', 'About Us'], ['/services', 'Services'], ['/tracking', 'Track Shipment'], ['/quote', 'Request a Quote'], ['/blog', 'Blog'], ['/contact', 'Contact Us']] as [$p, $l]): ?>
                    <li><a href="<?= url($p) ?>" class="hover:text-brand-orange"><?= $l ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div>
            <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-white">Our Services</h3>
            <ul class="space-y-2 text-sm">
                <?php foreach (Services::all() as $slug => $s): ?>
                    <li><a href="<?= url('services/' . $slug) ?>" class="hover:text-brand-orange"><?= e($s['short']) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div>
            <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-white">Contact</h3>
            <ul class="space-y-3 text-sm">
                <li class="flex gap-3"><i class="fa-solid fa-location-dot mt-1 text-brand-orange"></i><span><?= e(setting('address')) ?></span></li>
                <li class="flex gap-3"><i class="fa-solid fa-phone mt-1 text-brand-orange"></i><a href="<?= e(phone_href(setting('phone'))) ?>" class="hover:text-white">Tel: <?= e(setting('phone')) ?></a></li>
                <li class="flex gap-3"><i class="fa-solid fa-mobile-screen mt-1 text-brand-orange"></i><a href="<?= e(phone_href(setting('mobile'))) ?>" class="hover:text-white">Cell: <?= e(setting('mobile')) ?></a></li>
                <li class="flex gap-3"><i class="fa-solid fa-envelope mt-1 text-brand-orange"></i><a href="mailto:<?= e(setting('email')) ?>" class="hover:text-white"><?= e(setting('email')) ?></a></li>
            </ul>
        </div>
    </div>
    <div class="border-t border-white/10">
        <div class="container-x flex flex-col items-center justify-between gap-2 py-5 text-xs text-slate-400 sm:flex-row">
            <p>&copy; <?= date('Y') ?> <?= e(setting('company_name')) ?>. All rights reserved.</p>
            <p class="space-x-4">
                <a href="<?= url('privacy-policy') ?>" class="hover:text-white">Privacy Policy</a>
                <a href="<?= url('terms') ?>" class="hover:text-white">Terms &amp; Conditions</a>
            </p>
        </div>
    </div>
</footer>
