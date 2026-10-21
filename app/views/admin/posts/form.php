<?php
$head = '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">';
$p = $post;
$v = fn(string $k, $default = '') => old($k, $p[$k] ?? $default);
$action = $p ? url('admin/posts/' . $p['id']) : url('admin/posts');
$pub = $v('published_at');
$pubInput = $pub ? date('Y-m-d\TH:i', strtotime((string) $pub)) : '';
?>
<?= $head ?>
<form method="post" action="<?= $action ?>" enctype="multipart/form-data" id="post-form" class="grid gap-6 lg:grid-cols-3" novalidate>
    <?= csrf_field() ?>
    <div class="space-y-6 lg:col-span-2">
        <div class="card space-y-4 p-6">
            <?php partial('partials/field', ['name' => 'title', 'label' => 'Title', 'required' => true, 'value' => $v('title')]) ?>
            <?php partial('partials/field', ['name' => 'slug', 'label' => 'URL slug (auto-generated if empty)', 'value' => $v('slug'), 'placeholder' => 'my-post-title']) ?>
            <?php partial('partials/field', ['name' => 'excerpt', 'label' => 'Short summary (shown on blog list)', 'type' => 'textarea', 'rows' => 2, 'value' => $v('excerpt')]) ?>
            <div>
                <label class="form-label">Content <span class="text-red-500">*</span></label>
                <div class="bg-white"><div id="editor"><?= $v('content') /* sanitised on save */ ?></div></div>
                <input type="hidden" name="content" id="content">
                <?php if ($err = error('content')): ?><p class="form-error"><?= e($err) ?></p><?php endif; ?>
            </div>
        </div>

        <div class="card space-y-4 p-6">
            <h2 class="font-bold">SEO</h2>
            <?php partial('partials/field', ['name' => 'meta_title', 'label' => 'Meta title (max 70)', 'value' => $v('meta_title')]) ?>
            <?php partial('partials/field', ['name' => 'meta_description', 'label' => 'Meta description (max 170)', 'type' => 'textarea', 'rows' => 2, 'value' => $v('meta_description')]) ?>
        </div>
    </div>

    <div class="space-y-6">
        <div class="card space-y-4 p-6">
            <h2 class="font-bold">Publish</h2>
            <?php partial('partials/field', ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['draft', 'published'], 'value' => $v('status', 'draft'), 'placeholder' => 'Select']) ?>
            <?php partial('partials/field', ['name' => 'published_at', 'label' => 'Publish date (optional, can be future)', 'type' => 'datetime-local', 'value' => $pubInput]) ?>
            <div>
                <label for="f_category_id" class="form-label">Category</label>
                <select id="f_category_id" name="category_id" class="form-input">
                    <option value="">Uncategorised</option>
                    <?php foreach ($categories as $c): ?>
                        <option value="<?= (int) $c['id'] ?>" <?= (string) $v('category_id') === (string) $c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <p class="mt-1 text-xs text-slate-500"><a href="<?= url('admin/categories') ?>" class="text-brand-blue hover:underline">Manage categories</a></p>
            </div>
            <button type="submit" class="btn-blue w-full"><i class="fa-solid fa-floppy-disk"></i> Save post</button>
        </div>

        <div class="card space-y-3 p-6">
            <h2 class="font-bold">Featured image</h2>
            <?php if ($p && $p['featured_image']): ?>
                <img src="<?= e(upload_url($p['featured_image'])) ?>" alt="" class="w-full rounded-lg">
                <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="remove_image" value="1" class="rounded"> Remove current image</label>
            <?php endif; ?>
            <input type="file" name="featured_image" accept="image/jpeg,image/png,image/webp" class="block w-full text-sm">
            <p class="text-xs text-slate-500">JPG, PNG or WebP, up to 2 MB.</p>
            <?php if ($err = error('featured_image')): ?><p class="form-error"><?= e($err) ?></p><?php endif; ?>
        </div>
    </div>
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
(function () {
  var quill = new Quill('#editor', {
    theme: 'snow',
    placeholder: 'Write your post…',
    modules: { toolbar: [[{ header: [2, 3, 4, false] }], ['bold', 'italic', 'underline'], [{ list: 'ordered' }, { list: 'bullet' }], ['blockquote', 'link', 'image'], ['clean']] }
  });
  document.getElementById('post-form').addEventListener('submit', function () {
    document.getElementById('content').value = quill.root.innerHTML;
  });
})();
</script>
