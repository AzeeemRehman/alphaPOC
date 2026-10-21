<?php partial('partials/page-hero', [
    'heading' => $category ? $category['name'] : 'Blog & Shipping News',
    'sub' => 'Freight tips, industry updates and company news.',
    'crumbs' => $category ? [['Blog', '/blog']] : [],
]) ?>

<section class="section bg-slate-50">
    <div class="container-x grid gap-10 lg:grid-cols-4">
        <div class="lg:col-span-3">
            <?php if ($search): ?>
                <p class="mb-6 text-sm text-slate-600"><?= (int) $total ?> result<?= $total === 1 ? '' : 's' ?> for “<b><?= e($search) ?></b>” · <a href="<?= url('blog') ?>" class="text-brand-blue hover:underline">Clear</a></p>
            <?php endif; ?>

            <?php if (!$posts): ?>
                <div class="card p-10 text-center text-slate-600"><i class="fa-regular fa-newspaper text-4xl text-slate-300"></i><p class="mt-3">No posts yet. Please check back soon.</p></div>
            <?php else: ?>
                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    <?php foreach ($posts as $post): partial('partials/post-card', ['post' => $post]); endforeach; ?>
                </div>

                <?php if ($pages > 1):
                    $base = $category ? 'blog/category/' . $category['slug'] : 'blog';
                    $q = $search ? ['q' => $search] : [];
                ?>
                    <nav class="mt-10 flex flex-wrap justify-center gap-2" aria-label="Pagination">
                        <?php for ($i = 1; $i <= $pages; $i++): ?>
                            <a href="<?= url($base, $q + ['page' => $i]) ?>" class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-semibold <?= $i === $page ? 'bg-brand-blue text-white' : 'bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-50' ?>" <?= $i === $page ? 'aria-current="page"' : '' ?>><?= $i ?></a>
                        <?php endfor; ?>
                    </nav>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <aside class="space-y-6">
            <form action="<?= url('blog') ?>" method="get" class="card p-5" role="search">
                <label for="blog-q" class="form-label">Search the blog</label>
                <div class="flex gap-2">
                    <input id="blog-q" name="q" value="<?= e($search) ?>" maxlength="80" class="form-input" placeholder="Search…">
                    <button class="btn-blue px-4" aria-label="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
            <?php partial('blog/sidebar-categories', ['categories' => $categories, 'active' => $category['slug'] ?? null]) ?>
            <?php if ($recent): ?>
                <div class="card p-5">
                    <h2 class="mb-3 text-sm font-bold uppercase tracking-wide text-slate-500">Recent posts</h2>
                    <ul class="space-y-3 text-sm">
                        <?php foreach ($recent as $r): ?>
                            <li><a href="<?= url('blog/' . $r['slug']) ?>" class="font-medium hover:text-brand-blue"><?= e($r['title']) ?></a><span class="block text-xs text-slate-400"><?= e(format_date($r['published_at'])) ?></span></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </aside>
    </div>
</section>
