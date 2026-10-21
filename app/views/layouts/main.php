<?php
/** @var string $content */
$siteName = setting('company_name');
$pageTitle = isset($title) && $title !== '' ? $title . ' | ' . $siteName : $siteName . ' | Karachi, Pakistan';
$desc = $metaDesc ?? 'ALPHA Global Shipping & Logistics: reliable, efficient, worldwide freight forwarding from Karachi, Pakistan.';
$canonical = absolute_url(ltrim(current_path(), '/'));
$og = $ogImage ?? absolute_url('assets/img/og-image.png');
$schema = [
    '@context' => 'https://schema.org',
    '@type' => 'LocalBusiness',
    'name' => $siteName,
    'url' => absolute_url('/'),
    'logo' => absolute_url('assets/img/logo-mark.png'),
    'image' => absolute_url('assets/img/og-image.png'),
    'telephone' => setting('phone'),
    'email' => setting('email'),
    'address' => ['@type' => 'PostalAddress', 'streetAddress' => 'Suit # 21, 2nd Floor, State Life Insurance Building No. 7, G. Allana Road', 'addressLocality' => 'Karachi', 'addressCountry' => 'PK'],
    'openingHours' => 'Mo-Sa 09:00-18:00',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($desc) ?>">
    <link rel="canonical" href="<?= e($canonical) ?>">
    <meta property="og:type" content="<?= e($ogType ?? 'website') ?>">
    <meta property="og:site_name" content="<?= e($siteName) ?>">
    <meta property="og:title" content="<?= e($pageTitle) ?>">
    <meta property="og:description" content="<?= e($desc) ?>">
    <meta property="og:url" content="<?= e($canonical) ?>">
    <meta property="og:image" content="<?= e($og) ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="theme-color" content="#0B192C">
    <link rel="icon" type="image/png" href="<?= asset('assets/img/favicon.png') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="<?= asset('assets/css/app.css') ?>">
    <script type="application/ld+json"><?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>
    <?= $head ?? '' ?>
</head>
<body class="min-h-screen flex flex-col">
<a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:bg-white focus:p-3">Skip to content</a>

<?php partial('partials/header') ?>

<main id="main" class="flex-1">
    <?= $content ?>
</main>

<?php partial('partials/footer') ?>

<a href="<?= e(whatsapp_link('Hello ALPHA Global Shipping, I would like to enquire about your services.')) ?>" target="_blank" rel="noopener"
   class="fixed bottom-5 right-5 z-40 flex h-14 w-14 items-center justify-center rounded-full bg-green-500 text-3xl text-white shadow-lg transition hover:bg-green-600"
   aria-label="Chat on WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>

<script src="<?= asset('assets/js/app.js') ?>" defer></script>
</body>
</html>
