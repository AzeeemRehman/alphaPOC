<div class="grid gap-6 lg:grid-cols-3">
    <div class="card overflow-hidden lg:col-span-2">
        <table class="table">
            <thead><tr><th>Name</th><th>Slug</th><th>Published posts</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($categories as $c): ?>
                <tr>
                    <td class="font-semibold"><?= e($c['name']) ?></td>
                    <td class="text-slate-500"><?= e($c['slug']) ?></td>
                    <td><?= (int) $c['post_count'] ?></td>
                    <td class="text-right">
                        <form method="post" action="<?= url('admin/categories/' . $c['id'] . '/delete') ?>" data-confirm="Delete this category? Posts will become uncategorised.">
                            <?= csrf_field() ?><button class="btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$categories): ?><tr><td colspan="4" class="p-6 text-center text-slate-500">No categories yet.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
    <form method="post" action="<?= url('admin/categories') ?>" class="card h-fit space-y-4 p-6">
        <?= csrf_field() ?>
        <h2 class="font-bold">Add category</h2>
        <?php partial('partials/field', ['name' => 'name', 'label' => 'Name', 'required' => true]) ?>
        <button class="btn-blue w-full">Add category</button>
    </form>
</div>
