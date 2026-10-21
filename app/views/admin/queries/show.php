<?php
$rows = [
    'Type' => ucfirst($query['type']), 'Name' => $query['name'], 'Company' => $query['company'], 'Email' => $query['email'], 'Phone' => $query['phone'],
    'Service' => $query['service_type'], 'Origin' => $query['origin'], 'Destination' => $query['destination'], 'Commodity' => $query['commodity'],
    'Weight (kg)' => $query['weight_kg'], 'Volume (CBM)' => $query['volume_cbm'], 'Container' => $query['container_type'],
    'Incoterms' => $query['incoterms'], 'Ship date' => $query['ship_date'], 'Received' => format_date($query['created_at'], 'M j, Y g:i A'), 'IP address' => $query['ip_address'],
];
?>
<div class="mb-4"><a href="<?= url('admin/queries') ?>" class="text-sm text-brand-blue hover:underline">← Back to queries</a></div>
<div class="grid gap-6 lg:grid-cols-3">
    <div class="card p-6 lg:col-span-2">
        <h2 class="text-lg font-bold"><?= e($query['subject'] ?: 'Enquiry') ?></h2>
        <dl class="mt-4 grid gap-x-6 gap-y-3 text-sm sm:grid-cols-2">
            <?php foreach ($rows as $label => $val): if ((string) $val === '') continue; ?>
                <div><dt class="text-slate-500"><?= e($label) ?></dt><dd class="font-medium"><?= $label === 'Email' ? '<a class="text-brand-blue hover:underline" href="mailto:' . e($val) . '">' . e($val) . '</a>' : e($val) ?></dd></div>
            <?php endforeach; ?>
        </dl>
        <?php if ($query['message']): ?>
            <h3 class="mt-6 text-sm font-semibold text-slate-500">Message</h3>
            <p class="mt-1 whitespace-pre-line rounded-lg bg-slate-50 p-4 text-sm"><?= e($query['message']) ?></p>
        <?php endif; ?>
        <div class="mt-6 flex flex-wrap gap-3">
            <a href="mailto:<?= e($query['email']) ?>?subject=<?= rawurlencode('Re: ' . ($query['subject'] ?? 'Your enquiry')) ?>" class="btn-blue"><i class="fa-solid fa-reply"></i> Reply by email</a>
            <?php if ($query['phone']): ?><a href="https://wa.me/<?= e(preg_replace('/\D/', '', $query['phone'])) ?>" target="_blank" rel="noopener" class="btn bg-green-500 text-white hover:bg-green-600"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a><?php endif; ?>
        </div>
    </div>

    <div class="space-y-6">
        <form method="post" action="<?= url('admin/queries/' . $query['id']) ?>" class="card space-y-4 p-6">
            <?= csrf_field() ?>
            <h2 class="font-bold">Status &amp; notes</h2>
            <div><label class="form-label" for="status">Status</label>
                <select id="status" name="status" class="form-input"><?php foreach (\App\Models\Query::STATUSES as $s): ?><option value="<?= $s ?>" <?= $query['status'] === $s ? 'selected' : '' ?>><?= e(ucwords(str_replace('_', ' ', $s))) ?></option><?php endforeach; ?></select></div>
            <div><label class="form-label" for="admin_notes">Internal notes</label><textarea id="admin_notes" name="admin_notes" rows="5" class="form-input"><?= e($query['admin_notes']) ?></textarea></div>
            <button class="btn-blue w-full">Save</button>
        </form>
        <form method="post" action="<?= url('admin/queries/' . $query['id'] . '/delete') ?>" class="card p-6" data-confirm="Delete this query permanently?">
            <?= csrf_field() ?><button class="btn-danger w-full"><i class="fa-solid fa-trash"></i> Delete query</button>
        </form>
    </div>
</div>
