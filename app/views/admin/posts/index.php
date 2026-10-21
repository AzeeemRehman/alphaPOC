<div class="mb-4 flex justify-end"><a href="<?= url('admin/posts/create') ?>" class="btn-blue"><i class="fa-solid fa-plus"></i> New post</a></div>
<div class="card overflow-hidden">
    <?php if (!$posts): ?><p class="p-8 text-center text-sm text-slate-500">No posts yet. Write your first one!</p><?php else: ?>
    <div class="overflow-x-auto"><table class="table">
        <thead><tr><th>Title</th><th>Category</th><th>Status</th><th>Published</th><th class="text-right">Actions</th></tr></thead>
        <tbody>
        <?php foreach ($posts as $p): ?>
            <tr>
                <td class="max-w-xs"><a href="<?= url('admin/posts/' . $p['id'] . '/edit') ?>" class="font-semibold hover:text-brand-blue"><?= e($p['title']) ?></a><span class="block text-xs text-slate-400">/blog/<?= e($p['slug']) ?></span></td>
                <td><?= e($p['category_name'] ?? '—') ?></td>
                <td><?= status_badge($p['status']) ?></td>
                <td class="whitespace-nowrap text-xs"><?= $p['published_at'] ? e(format_date($p['published_at'])) : '—' ?></td>
                <td class="whitespace-nowrap text-right">
                    <?php if ($p['status'] === 'published'): ?><a href="<?= url('blog/' . $p['slug']) ?>" target="_blank" class="btn-ghost btn-sm">View</a><?php endif; ?>
                    <a href="<?= url('admin/posts/' . $p['id'] . '/edit') ?>" class="btn-ghost btn-sm">Edit</a>
                    <form method="post" action="<?= url('admin/posts/' . $p['id'] . '/delete') ?>" class="inline" data-confirm="Delete this post permanently?">
                        <?= csrf_field() ?><button class="btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table></div>
    <?php endif; ?>
</div>
