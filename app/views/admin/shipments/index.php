<div class="grid gap-6 lg:grid-cols-3">
    <div class="card overflow-hidden lg:col-span-2">
        <?php if (!$shipments): ?><p class="p-8 text-center text-sm text-slate-500">No shipments yet. Add one using the form.</p><?php else: ?>
        <div class="overflow-x-auto"><table class="table">
            <thead><tr><th>Tracking #</th><th>Route</th><th>Mode</th><th>Status</th><th>ETA</th></tr></thead>
            <tbody>
            <?php foreach ($shipments as $s): ?>
                <tr>
                    <td><a href="<?= url('admin/shipments/' . $s['id']) ?>" class="font-mono font-semibold hover:text-brand-blue"><?= e($s['tracking_no']) ?></a><span class="block text-xs text-slate-500"><?= e($s['customer_name']) ?></span></td>
                    <td><?= e($s['origin']) ?> → <?= e($s['destination']) ?></td>
                    <td><?= e($s['mode']) ?></td>
                    <td><span class="badge bg-blue-100 text-blue-700"><?= e($s['current_status']) ?></span></td>
                    <td class="whitespace-nowrap text-xs"><?= $s['eta'] ? e(format_date($s['eta'])) : '—' ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table></div>
        <?php endif; ?>
    </div>
    <form method="post" action="<?= url('admin/shipments') ?>" class="card h-fit space-y-4 p-6">
        <?= csrf_field() ?>
        <h2 class="font-bold">Add shipment</h2>
        <?php partial('partials/field', ['name' => 'tracking_no', 'label' => 'Tracking number', 'required' => true, 'placeholder' => 'AGSL-100001']) ?>
        <?php partial('partials/field', ['name' => 'customer_name', 'label' => 'Customer']) ?>
        <?php partial('partials/field', ['name' => 'origin', 'label' => 'Origin', 'required' => true]) ?>
        <?php partial('partials/field', ['name' => 'destination', 'label' => 'Destination', 'required' => true]) ?>
        <?php partial('partials/field', ['name' => 'mode', 'label' => 'Mode', 'type' => 'select', 'options' => ['Ocean', 'Air', 'Land'], 'required' => true, 'placeholder' => 'Select']) ?>
        <?php partial('partials/field', ['name' => 'eta', 'label' => 'ETA', 'type' => 'date']) ?>
        <button class="btn-blue w-full">Create shipment</button>
    </form>
</div>
