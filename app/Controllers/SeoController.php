<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Data\Services;
use App\Models\Post;

final class SeoController
{
    public function sitemap(): void
    {
        header('Content-Type: application/xml; charset=UTF-8');
        $urls = [['/', 1.0], ['/about', 0.7], ['/services', 0.9], ['/tracking', 0.5], ['/quote', 0.9], ['/blog', 0.8], ['/contact', 0.8], ['/privacy-policy', 0.2], ['/terms', 0.2]];
        foreach (array_keys(Services::all()) as $slug) {
            $urls[] = ['/services/' . $slug, 0.8];
        }

        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as [$path, $priority]) {
            echo '  <url><loc>' . e(absolute_url($path)) . '</loc><priority>' . $priority . "</priority></url>\n";
        }
        try {
            foreach (Post::allPublishedForSitemap() as $p) {
                echo '  <url><loc>' . e(absolute_url('blog/' . $p['slug'])) . '</loc><lastmod>' . date('Y-m-d', strtotime($p['updated_at'])) . "</lastmod><priority>0.6</priority></url>\n";
            }
        } catch (\Throwable) {
        }
        echo '</urlset>';
    }

    public function robots(): void
    {
        header('Content-Type: text/plain; charset=UTF-8');
        echo "User-agent: *\nDisallow: /admin\nDisallow: /uploads/tmp\n\nSitemap: " . absolute_url('sitemap.xml') . "\n";
    }
}
