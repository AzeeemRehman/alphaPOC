<?php partial('partials/page-hero', ['heading' => 'Request a Freight Quote', 'sub' => 'Give us the details of your cargo and we will send you rates.']) ?>

<section class="section bg-slate-50">
    <div class="container-x grid gap-10 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <div class="card p-6 sm:p-8">
                <?php partial('partials/flash') ?>
                <form method="post" action="<?= url('quote') ?>" data-once novalidate>
                    <?= csrf_field() ?>
                    <?= \App\Core\Spam::honeypotField() ?>

                    <h2 class="text-lg font-bold">Your details</h2>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <?php partial('partials/field', ['name' => 'name', 'label' => 'Full name', 'required' => true]) ?>
                        <?php partial('partials/field', ['name' => 'company', 'label' => 'Company']) ?>
                        <?php partial('partials/field', ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true]) ?>
                        <?php partial('partials/field', ['name' => 'phone', 'label' => 'Phone / WhatsApp', 'type' => 'tel', 'required' => true]) ?>
                    </div>

                    <h2 class="mt-8 text-lg font-bold">Shipment details</h2>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <?php partial('partials/field', ['name' => 'service_type', 'label' => 'Service', 'type' => 'select', 'options' => \App\Data\Services::formOptions(), 'required' => true, 'placeholder' => 'Select a service', 'value' => old('service_type', $preset), 'wrapClass' => 'sm:col-span-2']) ?>
                        <?php partial('partials/field', ['name' => 'origin', 'label' => 'Origin (city / port)', 'required' => true, 'placeholder' => 'e.g. Karachi']) ?>
                        <?php partial('partials/field', ['name' => 'destination', 'label' => 'Destination (city / port)', 'required' => true, 'placeholder' => 'e.g. Dubai']) ?>
                        <?php partial('partials/field', ['name' => 'commodity', 'label' => 'Commodity / cargo description', 'required' => true, 'wrapClass' => 'sm:col-span-2']) ?>
                        <?php partial('partials/field', ['name' => 'weight_kg', 'label' => 'Weight (kg)', 'type' => 'number', 'attrs' => 'min="0" step="any"']) ?>
                        <?php partial('partials/field', ['name' => 'volume_cbm', 'label' => 'Volume (CBM)', 'type' => 'number', 'attrs' => 'min="0" step="any"']) ?>
                        <?php partial('partials/field', ['name' => 'container_type', 'label' => 'Container type', 'type' => 'select', 'options' => ['20ft', '40ft', '40ft HC', 'Not applicable'], 'placeholder' => 'Select']) ?>
                        <?php partial('partials/field', ['name' => 'incoterms', 'label' => 'Incoterms', 'type' => 'select', 'options' => ['EXW', 'FOB', 'CIF', 'CFR', 'DAP', 'DDP'], 'placeholder' => 'Select']) ?>
                        <?php partial('partials/field', ['name' => 'ship_date', 'label' => 'Expected ship date', 'type' => 'date']) ?>
                        <?php partial('partials/field', ['name' => 'message', 'label' => 'Additional notes', 'type' => 'textarea', 'rows' => 4, 'wrapClass' => 'sm:col-span-2']) ?>
                    </div>

                    <div class="mt-4"><?= \App\Core\Spam::turnstileWidget() ?></div>
                    <button type="submit" class="btn-primary mt-6 w-full sm:w-auto"><i class="fa-solid fa-paper-plane"></i> Submit quote request</button>
                </form>
            </div>
        </div>

        <aside class="space-y-6">
            <div class="card p-6">
                <h2 class="text-lg font-bold">Prefer to talk?</h2>
                <p class="mt-1 text-sm text-slate-600">Call or WhatsApp our team directly.</p>
                <a href="<?= e(phone_href(setting('phone'))) ?>" class="btn-blue mt-4 w-full"><i class="fa-solid fa-phone"></i> <?= e(setting('phone')) ?></a>
                <a href="<?= e(whatsapp_link()) ?>" target="_blank" rel="noopener" class="btn mt-3 w-full bg-green-500 text-white hover:bg-green-600"><i class="fa-brands fa-whatsapp text-lg"></i> <?= e(setting('mobile')) ?></a>
            </div>
            <div class="card p-6 text-sm text-slate-600">
                <h2 class="mb-3 text-lg font-bold text-navy-900">What happens next?</h2>
                <ol class="list-decimal space-y-2 pl-5">
                    <li>We review your request.</li>
                    <li>We contact you with rates and transit times.</li>
                    <li>You confirm and we book your shipment.</li>
                </ol>
            </div>
        </aside>
    </div>
</section>
