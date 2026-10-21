<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

final class Category
{
    public static function all(): array
    {
        return DB::all('SELECT * FROM categories ORDER BY name');
    }

    public static function withCounts(): array
    {
        return DB::all(
            "SELECT c.*, COUNT(p.id) AS post_count
             FROM categories c
             LEFT JOIN posts p ON p.category_id = c.id AND p.status = 'published' AND p.published_at <= NOW()
             GROUP BY c.id ORDER BY c.name"
        );
    }

    public static function findBySlug(string $slug): ?array
    {
        return DB::one('SELECT * FROM categories WHERE slug = ?', [$slug]);
    }

    public static function create(string $name): int
    {
        $base = slugify($name);
        $slug = $base;
        $i = 2;
        while (DB::value('SELECT id FROM categories WHERE slug = ?', [$slug])) {
            $slug = $base . '-' . $i++;
        }
        return DB::insert('categories', ['name' => $name, 'slug' => $slug]);
    }

    public static function delete(int $id): void
    {
        DB::exec('DELETE FROM categories WHERE id = ?', [$id]);
    }
}
