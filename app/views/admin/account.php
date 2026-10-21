<div class="grid gap-6 lg:grid-cols-2">
    <form method="post" action="<?= url('admin/account') ?>" class="card space-y-4 p-6">
        <?= csrf_field() ?>
        <h2 class="font-bold">Change password</h2>
        <p class="text-sm text-slate-500">Signed in as <b><?= e($user['email']) ?></b></p>
        <?php partial('partials/field', ['name' => 'current_password', 'label' => 'Current password', 'type' => 'password', 'required' => true]) ?>
        <?php partial('partials/field', ['name' => 'password', 'label' => 'New password (min 10 characters)', 'type' => 'password', 'required' => true]) ?>
        <?php partial('partials/field', ['name' => 'password_confirmation', 'label' => 'Confirm new password', 'type' => 'password', 'required' => true]) ?>
        <button class="btn-blue">Update password</button>
    </form>

    <?php if ($user['role'] === 'admin'): ?>
    <form method="post" action="<?= url('admin/users') ?>" class="card space-y-4 p-6">
        <?= csrf_field() ?>
        <h2 class="font-bold">Add a user</h2>
        <?php partial('partials/field', ['name' => 'name', 'label' => 'Name', 'required' => true]) ?>
        <?php partial('partials/field', ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true]) ?>
        <?php partial('partials/field', ['name' => 'role', 'label' => 'Role', 'type' => 'select', 'options' => ['editor', 'admin'], 'required' => true, 'placeholder' => 'Select role']) ?>
        <?php partial('partials/field', ['name' => 'password', 'label' => 'Temporary password (min 10 characters)', 'type' => 'password', 'required' => true]) ?>
        <p class="text-xs text-slate-500">Editors can manage posts, queries and shipments. Admins can also change site settings and add users.</p>
        <button class="btn-blue">Create user</button>
    </form>
    <?php endif; ?>
</div>
