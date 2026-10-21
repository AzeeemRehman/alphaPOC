<article class="card flex flex-col overflow-hidden transition hover:shadow-lg">
    <a href="<?= url('blog/' . $post['slug']) ?>" class="block aspect-[16/9] bg-brand-blue-light" tabindex="-1" aria-hidden="true">
        <?php if ($post['featured_image']): ?>
            <img src="<?= e(upload_url($post['featured_image'])) ?>" alt="" class="h-full w-full object-cover" loading="lazy">
        <?php else: ?>
            <span class="flex h-full w-full items-center justify-center text-5xl text-brand-blue/30"><i class="fa-solid fa-ship"></i></span>
        <?php endif; ?>
    </a>
    <div class="flex flex-1 flex-col p-5">
        <div class="flex items-center gap-3 text-xs text-slate-500">
            <?php if ($post['category_name']): ?><span class="font-semibold uppercase tracking-wide text-brand-orange"><?= e($post['category_name']) ?></span><?php endif; ?>
            <time datetime="<?= e(substr((string) $post['published_at'], 0, 10)) ?>"><?= e(format_date($post['published_at'])) ?></time>
        </div>
        <h3 class="mt-2 text-lg font-bold leading-snug"><a href="<?= url('blog/' . $post['slug']) ?>" class="hover:text-brand-blue"><?= e($post['title']) ?></a></h3>
        <p class="mt-2 flex-1 text-sm text-slate-600"><?= e($post['excerpt'] ?: excerpt($post['content'], 140)) ?></p>
        <a href="<?= url('blog/' . $post['slug']) ?>" class="mt-4 text-sm font-semibold text-brand-blue hover:underline">Read more →</a>
    </div>
</article>
