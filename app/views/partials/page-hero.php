<section class="page-hero">
    <div class="hero-pattern absolute inset-0"></div>
    <div class="container-x relative">
        <nav aria-label="Breadcrumb" class="mb-4 text-xs text-slate-300">
            <a href="<?= url('/') ?>" class="hover:text-white">Home</a>
            <?php foreach (($crumbs ?? []) as [$crumbLabel, $crumbPath]): ?>
                <span class="mx-2">/</span><a href="<?= url($crumbPath) ?>" class="hover:text-white"><?= e($crumbLabel) ?></a>
            <?php endforeach; ?>
            <span class="mx-2">/</span><span class="text-white"><?= e($heading) ?></span>
        </nav>
        <h1><?= e($heading) ?></h1>
        <?php if (!empty($sub)): ?><p class="mt-3 max-w-2xl text-lg text-slate-300"><?= e($sub) ?></p><?php endif; ?>
    </div>
</section>
