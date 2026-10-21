<?php
declare(strict_types=1);

namespace App\Core;

use App\Models\User;

final class Auth
{
    private const MAX_ATTEMPTS = 5;
    private const LOCKOUT_MINUTES = 15;

    private static ?array $user = null;

    public static function user(): ?array
    {
        if (self::$user === null && !empty($_SESSION['user_id'])) {
            self::$user = User::find((int) $_SESSION['user_id']);
        }
        return self::$user;
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function isLockedOut(string $email): bool
    {
        $count = (int) DB::value(
            'SELECT COUNT(*) FROM login_attempts WHERE (ip_address = ? OR email = ?)
             AND attempted_at > (NOW() - INTERVAL ' . self::LOCKOUT_MINUTES . ' MINUTE)',
            [client_ip(), $email]
        );
        return $count >= self::MAX_ATTEMPTS;
    }

    public static function attempt(string $email, string $password): bool
    {
        $user = User::findByEmail($email);
        if (!$user || !password_verify($password, $user['password_hash'])) {
            DB::insert('login_attempts', ['ip_address' => client_ip(), 'email' => $email]);
            return false;
        }

        if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
            DB::update('users', ['password_hash' => password_hash($password, PASSWORD_DEFAULT)], (int) $user['id']);
        }

        DB::exec('DELETE FROM login_attempts WHERE email = ? OR ip_address = ?', [$email, client_ip()]);
        DB::exec('UPDATE users SET last_login = NOW() WHERE id = ?', [$user['id']]);

        Session::regenerate();
        $_SESSION['user_id'] = (int) $user['id'];
        self::$user = $user;
        return true;
    }

    public static function logout(): void
    {
        $_SESSION = [];
        Session::regenerate();
        self::$user = null;
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            flash('error', 'Please sign in to continue.');
            redirect('/admin/login');
        }
    }

    public static function requireRole(string $role): void
    {
        self::requireLogin();
        if ((self::user()['role'] ?? '') !== $role) {
            abort(403);
        }
    }
}
