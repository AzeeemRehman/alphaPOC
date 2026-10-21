<form method="get" class="card mb-4 flex flex-wrap items-end gap-3 p-4">
    <div><label class="form-label" for="q">Search</label><input id="q" name="q" value="<?= e($search) ?>" class="form-input" placeholder="Name, email, subject…"></div>
    <div><label class="form-label" for="type">Type</label>
        <select id="type" name="type" class="form-input"><option value="">All</option><option value="contact" <?= $type === 'contact' ? 'selected' : '' ?>>Contact</option><option value="quote" <?= $type === 'quote' ? 'selected' : '' ?>>Quote</option></select></div>
    <div><label class="form-label" for="status">Status</label>
        <select id="status" name="status" class="form-input"><option value="">All</option><?php foreach (\App\Models\Query::STATUSES as $s): ?><option value="<?= $s ?>" <?= $status === $s ? 'selected' : '' ?>><?= e(ucwords(str_replace('_', ' ', $s))) ?></option><?php endforeach; ?></select></div>
    <button class="btn-blue">Filter</button>
    <a href="<?= url('admin/queries/export', array_filter(['type' => $type, 'status' => $status])) ?>" class="btn-ghost ml-auto"><i class="fa-solid fa-file-csv"></i> Export CSV</a>
</form>

<div class="card overflow-hidden">
    <?php if (!$queries): ?><p class="p-8 text-center text-sm text-slate-500">No queries found.</p><?php else: ?>
    <div class="overflow-x-auto"><table class="table">
        <thead><tr><th>#</th><th>From</th><th>Subject</th><th>Type</th><th>Status</th><th>Received</th></tr></thead>
        <tbody>
        <?php foreach ($queries as $q): ?>
            <tr class="<?= $q['status'] === 'new' ? 'bg-orange-50/50' : '' ?>">
                <td class="text-slate-400"><?= (int) $q['id'] ?></td>
                <td><a href="<?= url('admin/queries/' . $q['id']) ?>" class="font-semibold hover:text-brand-blue"><?= e($q['name']) ?></a><span class="block text-xs text-slate-500"><?= e($q['email']) ?></span></td>
                <td class="max-w-xs truncate"><?= e($q['subject']) ?></td>
                <td><span class="badge bg-slate-100 text-slate-600"><?= e(ucfirst($q['type'])) ?></span></td>
                <td><?= status_badge($q['status']) ?></td>
                <td class="whitespace-nowrap text-xs text-slate-500"><?= e(format_date($q['created_at'], 'M j, Y g:i A')) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table></div>
    <?php endif; ?>
</div>
