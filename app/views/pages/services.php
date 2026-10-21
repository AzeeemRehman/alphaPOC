<?php partial('partials/page-hero', ['heading' => 'Our Services', 'sub' => 'Everything your cargo needs, from booking to delivery.']) ?>

<section class="section bg-slate-50">
    <div class="container-x grid gap-6 md:grid-cols-2">
        <?php foreach ($services as $slug => $s): ?>
            <article class="card flex gap-5 p-6 transition hover:shadow-lg">
                <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-brand-blue text-2xl text-white"><i class="fa-solid <?= e($s['icon']) ?>"></i></span>
                <div>
                    <h2 class="text-xl font-bold"><a href="<?= url('services/' . $slug) ?>" class="hover:text-brand-blue"><?= e($s['title']) ?></a></h2>
                    <p class="mt-2 text-sm text-slate-600"><?= e($s['summary']) ?></p>
                    <div class="mt-4 flex flex-wrap gap-4 text-sm font-semibold">
                        <a href="<?= url('services/' . $slug) ?>" class="text-brand-blue hover:underline">Details →</a>
                        <a href="<?= url('quote', ['service' => $s['form']]) ?>" class="text-brand-orange hover:underline">Get a quote</a>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<?php partial('partials/cta') ?>
