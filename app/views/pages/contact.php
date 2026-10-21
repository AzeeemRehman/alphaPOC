<?php partial('partials/page-hero', ['heading' => 'Contact Us', 'sub' => 'Questions about a shipment or a rate? Our team is happy to help.']) ?>

<section class="section bg-white">
    <div class="container-x grid gap-10 lg:grid-cols-5">
        <div class="space-y-6 lg:col-span-2">
            <div class="card p-6">
                <h2 class="text-xl font-bold"><?= e(setting('company_name')) ?></h2>
                <ul class="mt-5 space-y-5 text-sm">
                    <li class="flex gap-4"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-blue-light text-brand-blue"><i class="fa-solid fa-location-dot"></i></span><div><b class="block text-navy-900">Office address</b><address class="not-italic text-slate-600"><?= e(setting('address')) ?></address></div></li>
                    <li class="flex gap-4"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-blue-light text-brand-blue"><i class="fa-solid fa-phone"></i></span><div><b class="block text-navy-900">Telephone</b><a href="<?= e(phone_href(setting('phone'))) ?>" class="text-slate-600 hover:text-brand-blue"><?= e(setting('phone')) ?></a></div></li>
                    <li class="flex gap-4"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-blue-light text-brand-blue"><i class="fa-solid fa-mobile-screen"></i></span><div><b class="block text-navy-900">Mobile / WhatsApp</b><a href="<?= e(phone_href(setting('mobile'))) ?>" class="text-slate-600 hover:text-brand-blue"><?= e(setting('mobile')) ?></a></div></li>
                    <li class="flex gap-4"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-blue-light text-brand-blue"><i class="fa-solid fa-envelope"></i></span><div><b class="block text-navy-900">Email</b><a href="mailto:<?= e(setting('email')) ?>" class="text-slate-600 hover:text-brand-blue"><?= e(setting('email')) ?></a></div></li>
                    <li class="flex gap-4"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-blue-light text-brand-blue"><i class="fa-regular fa-clock"></i></span><div><b class="block text-navy-900">Office hours</b><span class="text-slate-600"><?= e(setting('hours')) ?></span></div></li>
                </ul>
                <a href="<?= e(whatsapp_link()) ?>" target="_blank" rel="noopener" class="btn mt-6 w-full bg-green-500 text-white hover:bg-green-600"><i class="fa-brands fa-whatsapp text-lg"></i> Chat on WhatsApp</a>
            </div>
        </div>

        <div class="lg:col-span-3">
            <div class="card p-6 sm:p-8">
                <h2 class="text-2xl font-extrabold">Send us a message</h2>
                <p class="mb-6 mt-1 text-sm text-slate-500">Fields marked <span class="text-red-500">*</span> are required.</p>
                <?php partial('partials/flash') ?>
                <form method="post" action="<?= url('contact') ?>" class="grid gap-4 sm:grid-cols-2" data-once novalidate>
                    <?= csrf_field() ?>
                    <?= \App\Core\Spam::honeypotField() ?>
                    <?php partial('partials/field', ['name' => 'name', 'label' => 'Full name', 'required' => true, 'placeholder' => 'Your name']) ?>
                    <?php partial('partials/field', ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true, 'placeholder' => 'you@company.com']) ?>
                    <?php partial('partials/field', ['name' => 'phone', 'label' => 'Phone / WhatsApp', 'type' => 'tel', 'required' => true, 'placeholder' => '+92 300 0000000']) ?>
                    <?php partial('partials/field', ['name' => 'company', 'label' => 'Company', 'placeholder' => 'Optional']) ?>
                    <?php partial('partials/field', ['name' => 'subject', 'label' => 'Subject', 'required' => true, 'placeholder' => 'e.g. Container rate enquiry', 'wrapClass' => 'sm:col-span-2']) ?>
                    <?php partial('partials/field', ['name' => 'message', 'label' => 'Message', 'type' => 'textarea', 'rows' => 6, 'required' => true, 'placeholder' => 'Tell us about your shipment or question…', 'wrapClass' => 'sm:col-span-2']) ?>
                    <div class="sm:col-span-2"><?= \App\Core\Spam::turnstileWidget() ?></div>
                    <div class="sm:col-span-2"><button type="submit" class="btn-primary w-full sm:w-auto"><i class="fa-solid fa-paper-plane"></i> Send message</button></div>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="bg-slate-100">
    <iframe title="Map showing our office near Merewether Tower, Karachi" src="<?= e(setting('map_embed')) ?>" class="h-96 w-full border-0" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</section>
