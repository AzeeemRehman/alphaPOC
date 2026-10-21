<?php partial('partials/page-hero', ['heading' => 'Track Your Shipment', 'sub' => 'Enter your tracking number to see the latest status.']) ?>

<section class="section bg-slate-50">
    <div class="container-x max-w-3xl">
        <form action="<?= url('tracking') ?>" method="get" class="card flex flex-col gap-3 p-6 sm:flex-row">
            <label for="no" class="sr-only">Tracking number</label>
            <input id="no" name="no" value="<?= e($no) ?>" required maxlength="40" placeholder="Tracking number, e.g. AGSL-100001" class="form-input flex-1">
            <button type="submit" class="btn-blue"><i class="fa-solid fa-magnifying-glass"></i> Track</button>
        </form>

        <?php if ($searched && !$shipment): ?>
            <div class="card mt-6 p-6 text-center">
                <i class="fa-solid fa-circle-question text-3xl text-slate-400"></i>
                <h2 class="mt-3 text-lg font-bold">No shipment found</h2>
                <p class="mt-1 text-sm text-slate-600">Please check the tracking number and try again, or <a href="<?= url('contact') ?>" class="font-semibold text-brand-blue hover:underline">contact us</a>.</p>
            </div>
        <?php elseif ($shipment): ?>
            <div class="card mt-6 overflow-hidden">
                <div class="flex flex-wrap items-center justify-between gap-3 bg-navy-900 p-6 text-white">
                    <div><p class="text-xs uppercase tracking-wider text-slate-400">Tracking number</p><p class="font-mono text-xl font-bold"><?= e($shipment['tracking_no']) ?></p></div>
                    <span class="badge bg-brand-orange px-3 py-1 text-sm text-white"><?= e($shipment['current_status']) ?></span>
                </div>
                <dl class="grid gap-4 border-b border-slate-200 p-6 text-sm sm:grid-cols-4">
                    <div><dt class="text-slate-500">Mode</dt><dd class="font-semibold"><?= e($shipment['mode']) ?></dd></div>
                    <div><dt class="text-slate-500">From</dt><dd class="font-semibold"><?= e($shipment['origin']) ?></dd></div>
                    <div><dt class="text-slate-500">To</dt><dd class="font-semibold"><?= e($shipment['destination']) ?></dd></div>
                    <div><dt class="text-slate-500">ETA</dt><dd class="font-semibold"><?= $shipment['eta'] ? e(format_date($shipment['eta'])) : '—' ?></dd></div>
                </dl>
                <ol class="p-6">
                    <?php foreach ($events as $i => $ev): ?>
                        <li class="relative flex gap-4 pb-6 last:pb-0">
                            <?php if ($i < count($events) - 1): ?><span class="absolute left-[11px] top-6 h-full w-0.5 bg-slate-200"></span><?php endif; ?>
                            <span class="relative z-10 mt-1 flex h-6 w-6 shrink-0 items-center justify-center rounded-full <?= $i === 0 ? 'bg-brand-orange' : 'bg-brand-blue' ?> text-[10px] text-white"><i class="fa-solid fa-check"></i></span>
                            <div>
                                <p class="font-semibold text-navy-900"><?= e($ev['status']) ?></p>
                                <p class="text-xs text-slate-500"><?= e(format_date($ev['event_time'], 'M j, Y · g:i A')) ?><?= $ev['location'] ? ' · ' . e($ev['location']) : '' ?></p>
                                <?php if ($ev['note']): ?><p class="mt-1 text-sm text-slate-600"><?= e($ev['note']) ?></p><?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        <?php endif; ?>
    </div>
</section>
