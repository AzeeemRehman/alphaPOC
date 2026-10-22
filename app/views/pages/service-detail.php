<?php partial('partials/page-hero', [
    'heading' => $service['title'], 'sub' => $service['summary'], 'crumbs' => [['Services', '/services']],
]) ?>

<section class="section bg-white">
    <div class="container-x grid gap-12 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <p class="text-lg leading-relaxed text-slate-600"><?= e($service['intro']) ?></p>

            <?php foreach ($service['sections'] ?? [] as [$h, $p]): ?>
                <h2 class="mt-10 text-2xl font-extrabold"><?= e($h) ?></h2>
                <p class="mt-3 leading-relaxed text-slate-600"><?= e($p) ?></p>
            <?php endforeach; ?>

            <?php if (!empty($service['highlights'])): ?>
                <h2 class="mt-12 text-2xl font-extrabold">Special services</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-3">
                    <?php foreach ($service['highlights'] as [$t, $d]): ?>
                        <div class="card border-t-4 border-t-brand-blue p-5">
                            <h3 class="font-bold"><?= e($t) ?></h3>
                            <p class="mt-2 text-sm text-slate-600"><?= e($d) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($service['capabilities'])): ?>
                <h2 class="mt-12 text-2xl font-extrabold">Our capabilities</h2>
                <ul class="mt-4 grid gap-3 sm:grid-cols-3">
                    <?php foreach ($service['capabilities'] as $c): ?>
                        <li class="flex gap-3 rounded-lg bg-slate-50 p-3 text-sm"><i class="fa-solid fa-star mt-0.5 text-brand-blue"></i><span><?= e($c) ?></span></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <h2 class="mt-12 text-2xl font-extrabold"><?= !empty($service['highlights']) ? 'Our solutions' : "What's included" ?></h2>
            <ul class="mt-4 grid gap-3 sm:grid-cols-2">
                <?php foreach ($service['features'] as $f): ?>
                    <li class="flex gap-3 rounded-lg bg-slate-50 p-3 text-sm"><i class="fa-solid fa-circle-check mt-0.5 text-brand-orange"></i><span><?= e($f) ?></span></li>
                <?php endforeach; ?>
            </ul>

            <h2 class="mt-12 text-2xl font-extrabold">How it works</h2>
            <ol class="mt-6 space-y-5">
                <?php foreach ($service['steps'] as $i => [$t, $d]): ?>
                    <li class="flex gap-4">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-blue font-bold text-white"><?= $i + 1 ?></span>
                        <div><h3 class="font-bold"><?= e($t) ?></h3><p class="text-sm text-slate-600"><?= e($d) ?></p></div>
                    </li>
                <?php endforeach; ?>
            </ol>

            <?php if (!empty($service['faq'])): ?>
                <h2 class="mt-12 text-2xl font-extrabold">Frequently asked questions</h2>
                <div class="mt-4 space-y-3">
                    <?php foreach ($service['faq'] as [$q, $a]): ?>
                        <details class="card group p-4">
                            <summary class="flex cursor-pointer list-none items-center justify-between font-semibold text-navy-900"><?= e($q) ?><i class="fa-solid fa-plus text-xs text-brand-orange group-open:hidden"></i><i class="fa-solid fa-minus hidden text-xs text-brand-orange group-open:block"></i></summary>
                            <p class="mt-3 text-sm text-slate-600"><?= e($a) ?></p>
                        </details>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <aside class="space-y-6">
            <div class="card sticky top-28 border-t-4 border-t-brand-orange p-6">
                <h2 class="text-lg font-bold">Need a quote?</h2>
                <p class="mt-1 text-sm text-slate-600">Tell us about your cargo and we will get back to you.</p>
                <a href="<?= url('quote', ['service' => $service['form']]) ?>" class="btn-primary mt-4 w-full">Request a Quote</a>
                <a href="<?= e(phone_href(setting('phone'))) ?>" class="btn-ghost mt-3 w-full"><i class="fa-solid fa-phone text-brand-blue"></i> <?= e(setting('phone')) ?></a>

                <h3 class="mb-3 mt-8 text-sm font-bold uppercase tracking-wide text-slate-500">Other services</h3>
                <ul class="space-y-1">
                    <?php foreach ($others as $oSlug => $o): ?>
                        <li><a href="<?= url('services/' . $oSlug) ?>" class="flex items-center gap-3 rounded-lg px-2 py-2 text-sm hover:bg-brand-blue-light hover:text-brand-blue"><i class="fa-solid <?= e($o['icon']) ?> w-5 text-brand-orange"></i><?= e($o['short']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </aside>
    </div>
</section>
