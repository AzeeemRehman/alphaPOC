<section class="bg-navy-900">
    <div class="container-x flex flex-col items-center justify-between gap-6 py-12 text-center md:flex-row md:text-left">
        <div>
            <h2 class="text-2xl font-extrabold text-white">Have a shipment to move?</h2>
            <p class="mt-1 text-slate-300">Get a quote from our team, usually within one working day.</p>
        </div>
        <div class="flex flex-wrap justify-center gap-3">
            <a href="<?= url($ctaPath ?? 'quote') ?>" class="btn-primary"><?= e($ctaLabel ?? 'Request a Quote') ?></a>
            <a href="<?= e(whatsapp_link()) ?>" target="_blank" rel="noopener" class="btn-outline"><i class="fa-brands fa-whatsapp"></i> WhatsApp Us</a>
        </div>
    </div>
</section>
