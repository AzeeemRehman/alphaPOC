<?php
$articleSchema = [
    '@context' => 'https://schema.org', '@type' => 'Article', 'headline' => $post['title'],
    'datePublished' => date('c', strtotime($post['published_at'])), 'dateModified' => date('c', strtotime($post['updated_at'])),
    'author' => ['@type' => 'Organization', 'name' => setting('company_name')],
    'publisher' => ['@type' => 'Organization', 'name' => setting('company_name'), 'logo' => ['@type' => 'ImageObject', 'url' => absolute_url('assets/img/logo-mark.png')]],
    'mainEntityOfPage' => absolute_url('blog/' . $post['slug']),
];
if ($post['featured_image']) {
    $articleSchema['image'] = absolute_url('uploads/blog/' . $post['featured_image']);
}
$shareUrl = absolute_url('blog/' . $post['slug']);
?>
<script type="application/ld+json"><?= json_encode($articleSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>

<?php partial('partials/page-hero', ['heading' => $post['title'], 'crumbs' => [['Blog', '/blog']]]) ?>

<section class="section bg-white">
    <div class="container-x grid gap-10 lg:grid-cols-4">
        <article class="lg:col-span-3">
            <div class="mb-6 flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-slate-500">
                <?php if ($post['category_name']): ?><a href="<?= url('blog/category/' . $post['category_slug']) ?>" class="badge bg-brand-blue-light text-brand-blue"><?= e($post['category_name']) ?></a><?php endif; ?>
                <span><i class="fa-regular fa-calendar mr-1"></i><?= e(format_date($post['published_at'])) ?></span>
                <span><i class="fa-regular fa-clock mr-1"></i><?= reading_time($post['content']) ?> min read</span>
            </div>
            <?php if ($post['featured_image']): ?>
                <img src="<?= e(upload_url($post['featured_image'])) ?>" alt="" class="mb-8 w-full rounded-2xl object-cover">
            <?php endif; ?>

            <div class="prose prose-slate max-w-none prose-headings:font-extrabold prose-a:text-brand-blue prose-img:rounded-xl">
                <?= $post['content'] /* sanitised on save by App\Core\Html::clean() */ ?>
            </div>

            <div class="mt-10 flex flex-wrap items-center gap-3 border-t border-slate-200 pt-6 text-sm">
                <span class="font-semibold">Share:</span>
                <a class="btn-ghost btn-sm" target="_blank" rel="noopener" href="https://wa.me/?text=<?= rawurlencode($post['title'] . ' ' . $shareUrl) ?>"><i class="fa-brands fa-whatsapp text-green-500"></i> WhatsApp</a>
                <a class="btn-ghost btn-sm" target="_blank" rel="noopener" href="https://www.linkedin.com/sharing/share-offsite/?url=<?= rawurlencode($shareUrl) ?>"><i class="fa-brands fa-linkedin text-blue-700"></i> LinkedIn</a>
                <a class="btn-ghost btn-sm" target="_blank" rel="noopener" href="https://www.facebook.com/sharer/sharer.php?u=<?= rawurlencode($shareUrl) ?>"><i class="fa-brands fa-facebook text-blue-600"></i> Facebook</a>
            </div>

            <?php if ($related): ?>
                <h2 class="mb-6 mt-14 text-2xl font-extrabold">Related posts</h2>
                <div class="grid gap-6 md:grid-cols-3">
                    <?php foreach ($related as $p): partial('partials/post-card', ['post' => $p]); endforeach; ?>
                </div>
            <?php endif; ?>
        </article>

        <aside class="space-y-6">
            <?php partial('blog/sidebar-categories', ['categories' => $categories, 'active' => $post['category_slug']]) ?>
            <div class="card border-t-4 border-t-brand-orange p-5">
                <h2 class="font-bold">Need a freight quote?</h2>
                <p class="mt-1 text-sm text-slate-600">Our team will get back to you with rates.</p>
                <a href="<?= url('quote') ?>" class="btn-primary mt-4 w-full">Request a Quote</a>
            </div>
        </aside>
    </div>
</section>
