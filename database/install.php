<?php
declare(strict_types=1);

/**
 * One-time installer.  Usage:  php database/install.php [--sample]
 * Creates the database and tables, and creates the first admin user.
 * With --sample it also adds categories, example blog posts and a demo shipment.
 */
if (PHP_SAPI !== 'cli') {
    exit('Run this script from the command line.');
}

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Core\DB;
use App\Models\Category;
use App\Models\Shipment;
use App\Models\User;

$c = config('db');
try {
    $pdo = new PDO("mysql:host={$c['host']};port={$c['port']};charset=utf8mb4", $c['username'], $c['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    fwrite(STDERR, "Cannot connect to MySQL: {$e->getMessage()}\nCheck DB_* values in .env and that MySQL is running.\n");
    exit(1);
}

$db = preg_replace('/[^A-Za-z0-9_]/', '', $c['database']);
$pdo->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
$pdo->exec("USE `$db`");

$sql = preg_replace('/^\s*--.*$/m', '', (string) file_get_contents(__DIR__ . '/schema.sql'));
foreach (array_filter(array_map('trim', explode(';', $sql))) as $stmt) {
    if (stripos($stmt, 'CREATE DATABASE') === 0 || stripos($stmt, 'USE ') === 0) {
        continue;
    }
    $pdo->exec($stmt);
}
echo "✔ Tables created in database '$db'\n";

// ---- Admin user ----
$adminEmail = getenv('ADMIN_EMAIL') ?: 'admin@alphagsl.com';
if (!User::findByEmail($adminEmail)) {
    $password = getenv('ADMIN_PASSWORD') ?: bin2hex(random_bytes(6)) . 'Aa1!';
    User::create('Administrator', $adminEmail, $password, 'admin');
    echo "✔ Admin user created\n   Email:    $adminEmail\n   Password: $password\n   (Change it after first login: Admin → My Account)\n";
} else {
    echo "• Admin user $adminEmail already exists, left unchanged\n";
}

if (in_array('--sample', $argv, true)) {
    foreach (['Shipping News', 'Freight Guides', 'Customs & Compliance', 'Company News'] as $name) {
        if (!Category::findBySlug(slugify($name))) {
            Category::create($name);
        }
    }

    $admin = User::findByEmail($adminEmail);
    $posts = [
        ['5 Documents You Need Before Shipping a Container from Karachi', 'freight-guides',
         'A short checklist of the paperwork that keeps your container moving through port without delays.',
         '<p>Whether you are exporting textiles or importing machinery, missing paperwork is one of the most common causes of delay at the port. Here are the key documents to have ready.</p><h2>1. Commercial invoice</h2><p>States the buyer, seller, goods and value. Customs uses it to assess duties.</p><h2>2. Packing list</h2><p>Details what is in each package, with weights and dimensions.</p><h2>3. Bill of Lading</h2><p>The contract of carriage and receipt for your cargo, issued by the shipping line.</p><h2>4. Certificate of Origin</h2><p>Proves where goods were made and can unlock reduced duties.</p><h2>5. Required licences and certificates</h2><p>Some goods need extra permits. Ask your forwarder early.</p><p>Not sure what your cargo needs? <a href="/contact">Contact our team</a> and we will help.</p>'],
        ['FCL or LCL: Which Is Right for Your Shipment?', 'freight-guides',
         'Understand the difference between full container and shared container shipping and when each makes sense.',
         '<p>Choosing between Full Container Load (FCL) and Less than Container Load (LCL) affects cost, speed and risk.</p><h2>FCL</h2><p>You use the whole container. It is usually faster and safer because your cargo is not handled alongside others.</p><h2>LCL</h2><p>Your goods share a container. You pay only for the space you use, which suits smaller volumes.</p><h2>Rule of thumb</h2><p>As volume grows, FCL often becomes more economical. Ask us for both quotes to compare.</p>'],
        ['Welcome to the New ALPHA Global Shipping Website', 'company-news',
         'Our new website makes it easier to request quotes, track shipments and stay informed.',
         '<p>We are pleased to launch our new website. You can now request a freight quote online, track your shipment, and read tips and news on our blog.</p><p>If you have any questions, our team in Karachi is ready to help.</p>'],
    ];
    foreach ($posts as [$title, $cat, $excerpt, $content]) {
        $slug = slugify($title);
        if (DB::value('SELECT id FROM posts WHERE slug = ?', [$slug])) {
            continue;
        }
        DB::insert('posts', [
            'title' => $title, 'slug' => $slug, 'excerpt' => $excerpt, 'content' => $content,
            'category_id' => Category::findBySlug($cat)['id'] ?? null, 'author_id' => $admin['id'] ?? null,
            'status' => 'published', 'published_at' => date('Y-m-d H:i:s', strtotime('-' . rand(1, 20) . ' days')),
        ]);
    }

    if (!Shipment::findByTracking('AGSL-100001')) {
        $id = DB::insert('shipments', [
            'tracking_no' => 'AGSL-100001', 'customer_name' => 'Demo Customer', 'origin' => 'Karachi, Pakistan',
            'destination' => 'Jebel Ali, UAE', 'mode' => 'Ocean', 'eta' => date('Y-m-d', strtotime('+6 days')),
        ]);
        Shipment::addEvent($id, 'Booking Confirmed', 'Karachi', 'Booking received', date('Y-m-d H:i:s', strtotime('-4 days')));
        Shipment::addEvent($id, 'Cargo Received', 'Karachi Port', null, date('Y-m-d H:i:s', strtotime('-3 days')));
        Shipment::addEvent($id, 'In Transit', 'Arabian Sea', 'Vessel departed on schedule', date('Y-m-d H:i:s', strtotime('-1 day')));
    }
    echo "✔ Sample categories, posts and demo shipment (AGSL-100001) added. Delete them from the admin panel before launch.\n";
}
echo "Done.\n";
