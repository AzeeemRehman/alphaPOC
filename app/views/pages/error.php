<section class="section bg-slate-50">
    <div class="container-x max-w-xl text-center">
        <p class="text-7xl font-extrabold text-brand-blue"><?= (int) $status ?></p>
        <h1 class="mt-4 text-2xl font-extrabold"><?= e($title ?? 'Something went wrong') ?></h1>
        <p class="mt-2 text-slate-600">
            <?= match ((int) $status) {
                404 => 'Sorry, we could not find the page you were looking for.',
                419 => 'Your session expired. Please go back, refresh the page and try again.',
                403 => 'You do not have permission to view this page.',
                default => 'Please try again in a moment or contact us if the problem continues.',
            } ?>
        </p>
        <div class="mt-8 flex flex-wrap justify-center gap-3">
            <a href="<?= url('/') ?>" class="btn-blue">Back to Home</a>
            <a href="<?= url('contact') ?>" class="btn-ghost">Contact Us</a>
        </div>
    </div>
</section>
