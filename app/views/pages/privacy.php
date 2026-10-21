<?php partial('partials/page-hero', ['heading' => 'Privacy Policy']) ?>
<section class="section bg-white">
    <div class="container-x max-w-3xl">
        <div class="prose prose-slate max-w-none">
            <p><em>Last updated: <?= date('F j, Y') ?>. This is a general template. Please have it reviewed by your legal adviser before launch.</em></p>
            <h2>Information we collect</h2>
            <p>When you use our contact or quote forms we collect the details you provide: your name, email, phone number, company and information about your shipment. We also record your IP address to help prevent spam.</p>
            <h2>How we use it</h2>
            <p>We use your information only to respond to your enquiry, prepare quotes, provide our services and keep records. We do not sell your information.</p>
            <h2>Sharing</h2>
            <p>We share information with carriers, customs authorities and partners only where needed to move your cargo, or where the law requires it.</p>
            <h2>Retention and security</h2>
            <p>We keep enquiry records for as long as needed for business and legal purposes and take reasonable steps to protect them.</p>
            <h2>Your choices</h2>
            <p>To access, correct or delete your information, email <a href="mailto:<?= e(setting('email')) ?>"><?= e(setting('email')) ?></a>.</p>
            <h2>Contact</h2>
            <p><?= e(setting('company_name')) ?>, <?= e(setting('address')) ?>. Tel: <?= e(setting('phone')) ?>.</p>
        </div>
    </div>
</section>
