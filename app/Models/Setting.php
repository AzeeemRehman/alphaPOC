<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

final class Setting
{
    public const DEFAULTS = [
        'company_name' => 'ALPHA Global Shipping & Logistics',
        'tagline'      => 'Reliable • Efficient • Worldwide',
        'address'      => 'Suit # 21, 2nd Floor, State Life Insurance Building No. 7, G. Allana Road, Near Merewether Tower, Karachi – Pakistan',
        'phone'        => '021-32316744-5',
        'mobile'       => '+92 333 2209385',
        'whatsapp'     => '923332209385',
        'email'        => 'info@alphagsl.com',
        'notify_email' => 'info@alphagsl.com',
        'hours'        => 'Mon – Sat: 9:00 AM – 6:00 PM',
        'facebook'     => '',
        'linkedin'     => '',
        'instagram'    => '',
        'map_embed'    => 'https://www.google.com/maps?q=Merewether+Tower+Karachi&output=embed',
    ];

    private static ?array $cache = null;

    private static function load(): array
    {
        if (self::$cache === null) {
            self::$cache = self::DEFAULTS;
            try {
                foreach (DB::all('SELECT `key`, `value` FROM settings') as $row) {
                    self::$cache[$row['key']] = $row['value'];
                }
            } catch (\Throwable) {
                // Database not ready yet: fall back to defaults.
            }
        }
        return self::$cache;
    }

    public static function get(string $key, string $default = ''): string
    {
        $all = self::load();
        return (string) ($all[$key] ?? $default);
    }

    public static function all(): array
    {
        return self::load();
    }

    public static function save(array $values): void
    {
        foreach ($values as $key => $value) {
            if (!array_key_exists($key, self::DEFAULTS)) {
                continue;
            }
            DB::exec(
                'INSERT INTO settings (`key`, `value`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)',
                [$key, (string) $value]
            );
        }
        self::$cache = null;
    }
}
