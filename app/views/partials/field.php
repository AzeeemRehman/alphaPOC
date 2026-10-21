<?php
/**
 * Reusable form field.
 * @var string $name  @var string $label  @var string $type  @var bool $required
 * @var ?array $options  @var mixed $value  @var ?string $placeholder  @var ?int $rows
 */
$type = $type ?? 'text';
$required = $required ?? false;
$val = $value ?? old($name);
$err = error($name);
$id = 'f_' . $name;
$cls = 'form-input' . ($err ? ' border-red-500' : '');
?>
<div class="<?= e($wrapClass ?? '') ?>">
    <label for="<?= e($id) ?>" class="form-label"><?= e($label) ?><?= $required ? ' <span class="text-red-500">*</span>' : '' ?></label>
    <?php if ($type === 'textarea'): ?>
        <textarea id="<?= e($id) ?>" name="<?= e($name) ?>" rows="<?= (int) ($rows ?? 4) ?>" class="<?= $cls ?>" placeholder="<?= e($placeholder ?? '') ?>" <?= $required ? 'required' : '' ?>><?= e($val) ?></textarea>
    <?php elseif ($type === 'select'): ?>
        <select id="<?= e($id) ?>" name="<?= e($name) ?>" class="<?= $cls ?>" <?= $required ? 'required' : '' ?>>
            <option value=""><?= e($placeholder ?? 'Select…') ?></option>
            <?php foreach ($options as $o): ?>
                <option value="<?= e($o) ?>" <?= (string) $val === (string) $o ? 'selected' : '' ?>><?= e($o) ?></option>
            <?php endforeach; ?>
        </select>
    <?php else: ?>
        <input id="<?= e($id) ?>" type="<?= e($type) ?>" name="<?= e($name) ?>" value="<?= e($val) ?>" class="<?= $cls ?>"
               placeholder="<?= e($placeholder ?? '') ?>" <?= $required ? 'required' : '' ?> <?= isset($attrs) ? $attrs : '' ?>>
    <?php endif; ?>
    <?php if ($err): ?><p class="form-error"><?= e($err) ?></p><?php endif; ?>
</div>
