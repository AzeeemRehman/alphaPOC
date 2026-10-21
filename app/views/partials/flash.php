<?php
$styles = [
    'success' => ['border-green-200 bg-green-50 text-green-800', 'fa-circle-check', 'status'],
    'error'   => ['border-red-200 bg-red-50 text-red-800', 'fa-circle-exclamation', 'alert'],
];
?>
<?php foreach ($styles as $type => [$cls, $icon, $role]): ?>
    <?php if ($msg = flash($type)): ?>
        <div class="mb-6 flex items-start gap-3 rounded-lg border p-4 text-sm <?= $cls ?>" role="<?= $role ?>">
            <i class="fa-solid <?= $icon ?> mt-0.5"></i>
            <span><?= e($msg) ?></span>
        </div>
    <?php endif; ?>
<?php endforeach; ?>
<?php if ($formError = error('_form')): ?>
    <div class="mb-6 flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800" role="alert">
        <i class="fa-solid fa-circle-exclamation mt-0.5"></i><span><?= e($formError) ?></span>
    </div>
<?php endif; ?>
