<div class="card p-5">
    <h2 class="mb-3 text-sm font-bold uppercase tracking-wide text-slate-500">Categories</h2>
    <ul class="space-y-1 text-sm">
        <?php foreach ($categories as $c): ?>
            <li><a href="<?= url('blog/category/' . $c['slug']) ?>" class="flex items-center justify-between rounded-lg px-2 py-1.5 hover:bg-brand-blue-light <?= ($active ?? null) === $c['slug'] ? 'bg-brand-blue-light font-semibold text-brand-blue' : '' ?>"><?= e($c['name']) ?><span class="text-xs text-slate-400"><?= (int) $c['post_count'] ?></span></a></li>
        <?php endforeach; ?>
        <?php if (!$categories): ?><li class="text-slate-400">No categories yet.</li><?php endif; ?>
    </ul>
</div>
