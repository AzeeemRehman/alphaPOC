<section class="relative overflow-hidden bg-navy-900 text-white">
    <div class="hero-pattern absolute inset-0"></div>
    <div class="container-x relative grid items-center gap-12 py-16 lg:grid-cols-2 lg:py-24">
        <div>
            <p class="eyebrow">Karachi • Pakistan</p>
            <h1 class="mt-3 text-4xl font-extrabold leading-tight text-white sm:text-5xl lg:text-6xl">Reliable freight forwarding to the <span class="text-brand-orange">world</span></h1>
            <p class="mt-6 max-w-xl text-lg text-slate-300">Sea freight, air cargo, customs clearance and warehousing handled by a dedicated team that treats your cargo like its own.</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="<?= url('quote') ?>" class="btn-primary">Get a Free Quote <i class="fa-solid fa-arrow-right"></i></a>
                <a href="<?= url('contact') ?>" class="btn-outline">Contact Our Team</a>
            </div>
        </div>

        <div class="card p-6 text-slate-700 shadow-xl">
            <h2 class="flex items-center gap-2 text-xl font-bold"><i class="fa-solid fa-location-crosshairs text-brand-orange"></i> Track Your Shipment</h2>
            <p class="mt-1 text-sm text-slate-500">Enter your tracking number for the latest status.</p>
            <form action="<?= url('tracking') ?>" method="get" class="mt-4 flex flex-col gap-3 sm:flex-row">
                <label for="home-track" class="sr-only">Tracking number</label>
                <input id="home-track" type="text" name="no" required placeholder="e.g. AGSL-100001" class="form-input flex-1" maxlength="40">
                <button type="submit" class="btn-blue">Track</button>
            </form>
            <hr class="my-5">
            <p class="text-sm text-slate-500">Need rates instead?</p>
            <a href="<?= url('quote') ?>" class="mt-1 inline-flex items-center gap-2 text-sm font-semibold text-brand-blue hover:underline">Request a quote <i class="fa-solid fa-arrow-right text-xs"></i></a>
        </div>
    </div>
</section>

<section class="border-b border-slate-200 bg-white">
    <div class="container-x grid grid-cols-2 gap-6 py-10 lg:grid-cols-4">
        <?php foreach ([['fa-globe', 'Worldwide Network', 'Shipping to destinations across the globe'], ['fa-shield-halved', 'Secure Handling', 'Careful handling and insured cargo options'], ['fa-clock', 'On-Time Delivery', 'Schedules we plan and follow through'], ['fa-headset', 'Dedicated Support', 'A real person to answer your questions']] as [$i, $t, $d]): ?>
            <div class="flex items-start gap-3">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-blue-light text-brand-blue"><i class="fa-solid <?= $i ?>"></i></span>
                <div><h3 class="text-sm font-bold"><?= $t ?></h3><p class="mt-0.5 text-xs text-slate-500"><?= $d ?></p></div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="section bg-slate-50">
    <div class="container-x">
        <div class="mx-auto max-w-2xl text-center">
            <p class="eyebrow">What we do</p>
            <h2 class="section-title">Complete freight solutions</h2>
            <p class="mt-3 text-slate-600">From the first booking to final delivery, one team covers every step of your supply chain.</p>
        </div>
        <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($services as $slug => $s): ?>
                <a href="<?= url('services/' . $slug) ?>" class="card group p-6 transition hover:-translate-y-1 hover:shadow-lg">
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-blue text-xl text-white transition group-hover:bg-brand-orange"><i class="fa-solid <?= e($s['icon']) ?>"></i></span>
                    <h3 class="mt-4 text-lg font-bold"><?= e($s['short']) ?></h3>
                    <p class="mt-2 text-sm text-slate-600"><?= e($s['summary']) ?></p>
                    <span class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-brand-blue">Learn more <i class="fa-solid fa-arrow-right text-xs"></i></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section bg-white">
    <div class="container-x grid items-center gap-12 lg:grid-cols-2">
        <div>
            <p class="eyebrow">Why choose us</p>
            <h2 class="section-title">A partner you can rely on</h2>
            <p class="mt-4 text-slate-600">We are based in the heart of Karachi's commercial district, close to the ports and the customs authorities. That means quicker follow-up and faster answers for your cargo.</p>
            <ul class="mt-6 space-y-4">
                <?php foreach ([['Clear communication', 'You always know where your cargo is and what happens next.'], ['Competitive rates', 'We negotiate with carriers so you get fair pricing.'], ['End-to-end service', 'Freight, clearance, storage and delivery under one roof.']] as [$t, $d]): ?>
                    <li class="flex gap-3"><i class="fa-solid fa-circle-check mt-1 text-brand-orange"></i><span><b class="text-navy-900"><?= $t ?>.</b> <?= $d ?></span></li>
                <?php endforeach; ?>
            </ul>
            <a href="<?= url('about') ?>" class="btn-blue mt-8">About Our Company</a>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <?php foreach ([['1', 'Request a quote'], ['2', 'Confirm booking'], ['3', 'We ship & clear'], ['4', 'Delivered']] as [$n, $t]): ?>
                <div class="card p-6 text-center">
                    <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-brand-orange text-lg font-extrabold text-white"><?= $n ?></span>
                    <p class="mt-3 text-sm font-semibold text-navy-900"><?= $t ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php if ($posts): ?>
<section class="section bg-slate-50">
    <div class="container-x">
        <div class="flex items-end justify-between">
            <div><p class="eyebrow">From the blog</p><h2 class="section-title">Latest news &amp; guides</h2></div>
            <a href="<?= url('blog') ?>" class="hidden text-sm font-semibold text-brand-blue hover:underline sm:block">View all posts →</a>
        </div>
        <div class="mt-10 grid gap-6 md:grid-cols-3">
            <?php foreach ($posts as $post): partial('partials/post-card', ['post' => $post]); endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="bg-brand-blue">
    <div class="container-x flex flex-col items-center justify-between gap-6 py-12 text-center md:flex-row md:text-left">
        <div>
            <h2 class="text-2xl font-extrabold text-white sm:text-3xl">Ready to ship with ALPHA?</h2>
            <p class="mt-1 text-blue-100">Tell us about your cargo and we will come back with a quote.</p>
        </div>
        <div class="flex flex-wrap justify-center gap-3">
            <a href="<?= url('quote') ?>" class="btn-primary">Request a Quote</a>
            <a href="<?= e(phone_href(setting('phone'))) ?>" class="btn-outline"><i class="fa-solid fa-phone"></i> <?= e(setting('phone')) ?></a>
        </div>
    </div>
</section>
