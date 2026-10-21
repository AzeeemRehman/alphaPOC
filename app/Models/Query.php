<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

final class Query
{
    public const STATUSES = ['new', 'in_progress', 'closed'];

    public static function create(array $data): int
    {
        return DB::insert('queries', $data);
    }

    public static function filtered(?string $type, ?string $status, ?string $search = null): array
    {
        $where = ['1=1'];
        $params = [];
        if ($type && in_array($type, ['contact', 'quote'], true)) {
            $where[] = 'type = ?';
            $params[] = $type;
        }
        if ($status && in_array($status, self::STATUSES, true)) {
            $where[] = 'status = ?';
            $params[] = $status;
        }
        if ($search) {
            $where[] = '(name LIKE ? OR email LIKE ? OR subject LIKE ? OR company LIKE ?)';
            $like = '%' . addcslashes($search, '%_\\') . '%';
            array_push($params, $like, $like, $like, $like);
        }
        return DB::all('SELECT * FROM queries WHERE ' . implode(' AND ', $where) . ' ORDER BY created_at DESC LIMIT 500', $params);
    }

    public static function find(int $id): ?array
    {
        return DB::one('SELECT * FROM queries WHERE id = ?', [$id]);
    }

    public static function count(?string $status = null): int
    {
        return $status
            ? (int) DB::value('SELECT COUNT(*) FROM queries WHERE status = ?', [$status])
            : (int) DB::value('SELECT COUNT(*) FROM queries');
    }

    public static function recent(int $limit = 5): array
    {
        return DB::all('SELECT * FROM queries ORDER BY created_at DESC LIMIT ' . max(1, $limit));
    }

    public static function delete(int $id): void
    {
        DB::exec('DELETE FROM queries WHERE id = ?', [$id]);
    }
}
