<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

final class User
{
    public static function find(int $id): ?array
    {
        return DB::one('SELECT * FROM users WHERE id = ?', [$id]);
    }

    public static function findByEmail(string $email): ?array
    {
        return DB::one('SELECT * FROM users WHERE email = ?', [strtolower($email)]);
    }

    public static function all(): array
    {
        return DB::all('SELECT id, name, email, role, last_login, created_at FROM users ORDER BY name');
    }

    public static function create(string $name, string $email, string $password, string $role): int
    {
        return DB::insert('users', [
            'name'          => $name,
            'email'         => strtolower($email),
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'role'          => $role,
        ]);
    }

    public static function setPassword(int $id, string $password): void
    {
        DB::update('users', ['password_hash' => password_hash($password, PASSWORD_DEFAULT)], $id);
    }
}
