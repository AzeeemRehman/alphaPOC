<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <?php foreach ([
        ['New queries', $newCount, 'fa-inbox', 'bg-orange-100 text-brand-orange', '/admin/queries?status=new'],
        ['Total queries', $queryTotal, 'fa-envelope-open-text', 'bg-blue-100 text-brand-blue', '/admin/queries'],
        ['Blog posts', $postCount . ' (' . $draftCount . ' drafts)', 'fa-newspaper', 'bg-green-100 text-green-700', '/admin/posts'],
        ['Shipments', $shipCount, 'fa-box', 'bg-slate-200 text-slate-700', '/admin/shipments'],
    ] as [$label, $val, $icon, $cls, $href]): ?>
        <a href="<?= url($href) ?>" class="card flex items-center gap-4 p-5 transition hover:shadow-md">
            <span class="flex h-12 w-12 items-center justify-center rounded-xl text-xl <?= $cls ?>"><i class="fa-solid <?= $icon ?>"></i></span>
            <div><p class="text-sm text-slate-500"><?= $label ?></p><p class="text-2xl font-extrabold text-navy-900"><?= e($val) ?></p></div>
        </a>
    <?php endforeach; ?>
</div>

<div class="mt-6 grid gap-6 lg:grid-cols-3">
    <div class="card overflow-hidden lg:col-span-2">
        <div class="flex items-center justify-between border-b border-slate-200 p-4"><h2 class="font-bold">Recent queries</h2><a href="<?= url('admin/queries') ?>" class="text-sm font-semibold text-brand-blue hover:underline">View all</a></div>
        <?php if (!$recent): ?><p class="p-6 text-sm text-slate-500">No queries yet.</p><?php else: ?>
            <div class="overflow-x-auto"><table class="table">
                <tbody>
                <?php foreach ($recent as $q): ?>
                    <tr>
                        <td><a href="<?= url('admin/queries/' . $q['id']) ?>" class="font-semibold hover:text-brand-blue"><?= e($q['name']) ?></a><span class="block text-xs text-slate-500"><?= e($q['subject']) ?></span></td>
                        <td><span class="badge bg-slate-100 text-slate-600"><?= e(ucfirst($q['type'])) ?></span></td>
                        <td><?= status_badge($q['status']) ?></td>
                        <td class="whitespace-nowrap text-xs text-slate-500"><?= e(format_date($q['created_at'])) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table></div>
        <?php endif; ?>
    </div>
    <div class="card p-5">
        <h2 class="font-bold">Quick actions</h2>
        <div class="mt-4 space-y-2">
            <a href="<?= url('admin/posts/create') ?>" class="btn-blue w-full"><i class="fa-solid fa-pen"></i> Write a blog post</a>
            <a href="<?= url('admin/shipments') ?>" class="btn-ghost w-full"><i class="fa-solid fa-box"></i> Add a shipment</a>
            <a href="<?= url('admin/queries/export') ?>" class="btn-ghost w-full"><i class="fa-solid fa-file-csv"></i> Export queries (CSV)</a>
        </div>
    </div>
</div>
