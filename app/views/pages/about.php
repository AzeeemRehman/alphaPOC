<?php partial('partials/page-hero', ['heading' => 'About Us', 'sub' => 'Reliable. Efficient. Worldwide.']) ?>

<section class="section bg-white">
    <div class="container-x grid items-center gap-12 lg:grid-cols-2">
        <div>
            <p class="eyebrow">Who we are</p>
            <h2 class="section-title">Your freight partner in Karachi</h2>
            <p class="mt-4 text-slate-600"><?= e(setting('company_name')) ?> is a freight forwarding and logistics company based in Karachi, Pakistan. We help importers and exporters move cargo by sea, air and land, and we look after the customs clearance, storage and delivery that go with it.</p>
            <p class="mt-4 text-slate-600">Our approach is simple: give honest advice, quote clearly, communicate often and deliver what we promise. Whether you ship occasionally or every week, you get the same attention to detail.</p>
            <dl class="mt-8 grid grid-cols-3 gap-4 text-center">
                <?php foreach ([['Sea', 'FCL & LCL'], ['Air', 'Express & charter'], ['Land', 'Nationwide']] as [$a, $b]): ?>
                    <div class="rounded-xl bg-brand-blue-light p-4"><dt class="text-2xl font-extrabold text-brand-blue"><?= $a ?></dt><dd class="text-xs text-slate-600"><?= $b ?></dd></div>
                <?php endforeach; ?>
            </dl>
        </div>
        <div class="rounded-2xl bg-slate-50 p-8 text-center">
            <img src="<?= asset('assets/img/logo-full.png') ?>" alt="<?= e(setting('company_name')) ?> logo" class="mx-auto w-full max-w-md" loading="lazy" width="849" height="420">
        </div>
    </div>
</section>

<section class="section bg-slate-50">
    <div class="container-x grid gap-6 md:grid-cols-2">
        <div class="card border-t-4 border-t-brand-orange p-8">
            <i class="fa-solid fa-bullseye text-3xl text-brand-orange"></i>
            <h2 class="mt-4 text-xl font-bold">Our Mission</h2>
            <p class="mt-2 text-slate-600">To move our customers' cargo safely, on time and at a fair price, backed by clear communication at every step.</p>
        </div>
        <div class="card border-t-4 border-t-brand-blue p-8">
            <i class="fa-solid fa-eye text-3xl text-brand-blue"></i>
            <h2 class="mt-4 text-xl font-bold">Our Vision</h2>
            <p class="mt-2 text-slate-600">To be the freight forwarder that Pakistani businesses trust first for reliable access to world markets.</p>
        </div>
    </div>
</section>

<section class="section bg-white">
    <div class="container-x">
        <div class="mx-auto max-w-2xl text-center"><p class="eyebrow">Our values</p><h2 class="section-title">What we stand for</h2></div>
        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <?php foreach ([['fa-handshake', 'Integrity', 'Honest advice and transparent charges.'], ['fa-gauge-high', 'Efficiency', 'Quick responses and smooth processes.'], ['fa-shield-halved', 'Care', 'Every shipment handled as if it were ours.'], ['fa-earth-asia', 'Reach', 'Global connections for local businesses.']] as [$i, $t, $d]): ?>
                <div class="card p-6 text-center">
                    <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-brand-blue-light text-xl text-brand-blue"><i class="fa-solid <?= $i ?>"></i></span>
                    <h3 class="mt-4 font-bold"><?= $t ?></h3>
                    <p class="mt-1 text-sm text-slate-600"><?= $d ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php partial('partials/cta') ?>
