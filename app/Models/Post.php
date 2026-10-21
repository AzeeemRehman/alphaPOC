<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

final class Post
{
    private const SELECT = 'SELECT p.*, c.name AS category_name, c.slug AS category_slug, u.name AS author_name
        FROM posts p
        LEFT JOIN categories c ON c.id = p.category_id
        LEFT JOIN users u ON u.id = p.author_id';

    private const LIVE = "p.status = 'published' AND p.published_at <= NOW()";

    public static function published(int $page, int $perPage, ?string $categorySlug = null, ?string $search = null): array
    {
        [$where, $params] = self::filters($categorySlug, $search);
        $offset = max(0, ($page - 1) * $perPage);
        return DB::all(
            self::SELECT . " WHERE $where ORDER BY p.published_at DESC LIMIT $perPage OFFSET $offset",
            $params
        );
    }

    public static function countPublished(?string $categorySlug = null, ?string $search = null): int
    {
        [$where, $params] = self::filters($categorySlug, $search);
        return (int) DB::value(
            "SELECT COUNT(*) FROM posts p LEFT JOIN categories c ON c.id = p.category_id WHERE $where",
            $params
        );
    }

    private static function filters(?string $categorySlug, ?string $search): array
    {
        $where = self::LIVE;
        $params = [];
        if ($categorySlug) {
            $where .= ' AND c.slug = ?';
            $params[] = $categorySlug;
        }
        if ($search) {
            $where .= ' AND (p.title LIKE ? OR p.excerpt LIKE ? OR p.content LIKE ?)';
            $like = '%' . addcslashes($search, '%_\\') . '%';
            array_push($params, $like, $like, $like);
        }
        return [$where, $params];
    }

    public static function latest(int $limit = 3, ?int $excludeId = null): array
    {
        $limit = max(1, $limit);
        $sql = self::SELECT . ' WHERE ' . self::LIVE;
        $params = [];
        if ($excludeId) {
            $sql .= ' AND p.id <> ?';
            $params[] = $excludeId;
        }
        return DB::all($sql . " ORDER BY p.published_at DESC LIMIT $limit", $params);
    }

    public static function related(array $post, int $limit = 3): array
    {
        if (!$post['category_id']) {
            return self::latest($limit, (int) $post['id']);
        }
        return DB::all(
            self::SELECT . ' WHERE ' . self::LIVE . " AND p.category_id = ? AND p.id <> ? ORDER BY p.published_at DESC LIMIT $limit",
            [$post['category_id'], $post['id']]
        );
    }

    public static function findPublishedBySlug(string $slug): ?array
    {
        return DB::one(self::SELECT . ' WHERE ' . self::LIVE . ' AND p.slug = ?', [$slug]);
    }

    public static function find(int $id): ?array
    {
        return DB::one(self::SELECT . ' WHERE p.id = ?', [$id]);
    }

    public static function allForAdmin(): array
    {
        return DB::all(self::SELECT . ' ORDER BY p.created_at DESC');
    }

    public static function allPublishedForSitemap(): array
    {
        return DB::all("SELECT slug, updated_at FROM posts p WHERE " . self::LIVE . ' ORDER BY published_at DESC');
    }

    public static function uniqueSlug(string $base, ?int $ignoreId = null): string
    {
        $slug = $base;
        $i = 2;
        while (DB::value('SELECT id FROM posts WHERE slug = ? AND id <> ?', [$slug, $ignoreId ?? 0])) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    public static function count(?string $status = null): int
    {
        return $status
            ? (int) DB::value('SELECT COUNT(*) FROM posts WHERE status = ?', [$status])
            : (int) DB::value('SELECT COUNT(*) FROM posts');
    }

    public static function delete(int $id): void
    {
        DB::exec('DELETE FROM posts WHERE id = ?', [$id]);
    }
}
