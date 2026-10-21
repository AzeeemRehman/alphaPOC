<?php
$fields = [
    ['company_name', 'Company name', 'text'], ['tagline', 'Tagline', 'text'], ['phone', 'Telephone', 'text'], ['mobile', 'Mobile', 'text'],
    ['whatsapp', 'WhatsApp number (digits, with country code)', 'text'], ['email', 'Public email', 'email'], ['notify_email', 'Send form notifications to', 'email'],
    ['hours', 'Office hours', 'text'], ['facebook', 'Facebook URL', 'url'], ['linkedin', 'LinkedIn URL', 'url'], ['instagram', 'Instagram URL', 'url'],
];
?>
<form method="post" action="<?= url('admin/settings') ?>" class="card max-w-3xl space-y-4 p-6">
    <?= csrf_field() ?>
    <p class="text-sm text-slate-500">These details appear in the header, footer, contact page and emails across the website.</p>
    <div class="grid gap-4 sm:grid-cols-2">
        <?php foreach ($fields as [$k, $label, $type]): ?>
            <?php partial('partials/field', ['name' => $k, 'label' => $label, 'type' => $type, 'value' => old($k, $values[$k] ?? '')]) ?>
        <?php endforeach; ?>
        <?php partial('partials/field', ['name' => 'address', 'label' => 'Address', 'type' => 'textarea', 'rows' => 2, 'value' => old('address', $values['address']), 'wrapClass' => 'sm:col-span-2']) ?>
        <?php partial('partials/field', ['name' => 'map_embed', 'label' => 'Google Maps embed URL', 'type' => 'url', 'value' => old('map_embed', $values['map_embed']), 'wrapClass' => 'sm:col-span-2']) ?>
    </div>
    <button class="btn-blue">Save settings</button>
</form>
