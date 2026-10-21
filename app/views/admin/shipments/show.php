<div class="mb-4"><a href="<?= url('admin/shipments') ?>" class="text-sm text-brand-blue hover:underline">← Back to shipments</a></div>
<div class="grid gap-6 lg:grid-cols-3">
    <div class="space-y-6 lg:col-span-2">
        <div class="card p-6">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h2 class="font-mono text-xl font-bold"><?= e($shipment['tracking_no']) ?></h2>
                <span class="badge bg-brand-orange px-3 py-1 text-white"><?= e($shipment['current_status']) ?></span>
            </div>
            <dl class="mt-4 grid gap-4 text-sm sm:grid-cols-4">
                <div><dt class="text-slate-500">Customer</dt><dd class="font-semibold"><?= e($shipment['customer_name'] ?: '—') ?></dd></div>
                <div><dt class="text-slate-500">Route</dt><dd class="font-semibold"><?= e($shipment['origin']) ?> → <?= e($shipment['destination']) ?></dd></div>
                <div><dt class="text-slate-500">Mode</dt><dd class="font-semibold"><?= e($shipment['mode']) ?></dd></div>
                <div><dt class="text-slate-500">ETA</dt><dd class="font-semibold"><?= $shipment['eta'] ? e(format_date($shipment['eta'])) : '—' ?></dd></div>
            </dl>
            <p class="mt-4 text-xs text-slate-500">Public link: <a class="text-brand-blue hover:underline" target="_blank" href="<?= url('tracking', ['no' => $shipment['tracking_no']]) ?>"><?= e(absolute_url('tracking?no=' . $shipment['tracking_no'])) ?></a></p>
        </div>

        <div class="card p-6">
            <h2 class="mb-4 font-bold">History</h2>
            <ol class="space-y-4 text-sm">
                <?php foreach ($events as $ev): ?>
                    <li class="border-l-2 border-brand-blue pl-4"><b><?= e($ev['status']) ?></b>
                        <span class="block text-xs text-slate-500"><?= e(format_date($ev['event_time'], 'M j, Y g:i A')) ?><?= $ev['location'] ? ' · ' . e($ev['location']) : '' ?></span>
                        <?php if ($ev['note']): ?><span class="text-slate-600"><?= e($ev['note']) ?></span><?php endif; ?></li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>

    <div class="space-y-6">
        <form method="post" action="<?= url('admin/shipments/' . $shipment['id'] . '/events') ?>" class="card space-y-4 p-6">
            <?= csrf_field() ?>
            <h2 class="font-bold">Add status update</h2>
            <?php partial('partials/field', ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => \App\Models\Shipment::STATUSES, 'required' => true, 'placeholder' => 'Select status']) ?>
            <?php partial('partials/field', ['name' => 'location', 'label' => 'Location']) ?>
            <?php partial('partials/field', ['name' => 'event_time', 'label' => 'Date & time (default: now)', 'type' => 'datetime-local']) ?>
            <?php partial('partials/field', ['name' => 'note', 'label' => 'Note (visible to customer)', 'type' => 'textarea', 'rows' => 2]) ?>
            <button class="btn-blue w-full">Add update</button>
        </form>
        <form method="post" action="<?= url('admin/shipments/' . $shipment['id'] . '/delete') ?>" class="card p-6" data-confirm="Delete this shipment and its history?">
            <?= csrf_field() ?><button class="btn-danger w-full"><i class="fa-solid fa-trash"></i> Delete shipment</button>
        </form>
    </div>
</div>
