<?php partial('partials/page-hero', ['heading' => 'Terms & Conditions']) ?>
<section class="section bg-white">
    <div class="container-x max-w-3xl">
        <div class="prose prose-slate max-w-none">
            <p><em>Last updated: <?= date('F j, Y') ?>. This is a general template for the website. Your actual freight service terms (liability, standard trading conditions) should be reviewed by your legal adviser.</em></p>
            <h2>Use of this website</h2>
            <p>The information on this website is provided for general information. Quotes, transit times and availability are estimates and are confirmed only in writing by <?= e(setting('company_name')) ?>.</p>
            <h2>Quotes and services</h2>
            <p>Services are provided subject to our written quotation and our standard trading conditions, which are available on request.</p>
            <h2>Tracking information</h2>
            <p>Shipment status shown online is for guidance and may be updated as information is received from carriers and agents.</p>
            <h2>Limitation</h2>
            <p>We make reasonable efforts to keep this website accurate and available, but do not guarantee it is free of errors or interruptions.</p>
            <h2>Contact</h2>
            <p>Questions about these terms can be sent to <a href="mailto:<?= e(setting('email')) ?>"><?= e(setting('email')) ?></a>.</p>
        </div>
    </div>
</section>
