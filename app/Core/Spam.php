<?php
declare(strict_types=1);

namespace App\Core;

/** Honeypot + time-trap + per-IP rate limit + optional Cloudflare Turnstile. */
final class Spam
{
    public static function honeypotField(): string
    {
        return '<div style="position:absolute;left:-9999px;" aria-hidden="true">'
            . '<label>Leave this empty<input type="text" name="website_url" tabindex="-1" autocomplete="off"></label>'
            . '<input type="hidden" name="_ts" value="' . time() . '"></div>';
    }

    public static function turnstileWidget(): string
    {
        $key = config('turnstile.site_key');
        if ($key === '') {
            return '';
        }
        return '<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>'
            . '<div class="cf-turnstile" data-sitekey="' . e($key) . '"></div>';
    }

    /** Returns an error message, or null if the submission looks legitimate. */
    public static function check(): ?string
    {
        if (!empty($_POST['website_url'])) {
            return 'Submission rejected.';
        }
        $elapsed = time() - (int) ($_POST['_ts'] ?? 0);
        if ($elapsed < 3) {
            return 'That was too fast. Please wait a moment and submit again.';
        }

        $count = (int) DB::value(
            'SELECT COUNT(*) FROM queries WHERE ip_address = ? AND created_at > (NOW() - INTERVAL 1 HOUR)',
            [client_ip()]
        );
        if ($count >= config('forms.max_per_hour')) {
            return 'You have sent several requests recently. Please call us on ' . setting('phone') . ' or try again later.';
        }

        $secret = config('turnstile.secret_key');
        if ($secret !== '') {
            $token = $_POST['cf-turnstile-response'] ?? '';
            $ctx = stream_context_create(['http' => [
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => http_build_query(['secret' => $secret, 'response' => $token, 'remoteip' => client_ip()]),
                'timeout' => 8,
            ]]);
            $res = @file_get_contents('https://challenges.cloudflare.com/turnstile/v0/siteverify', false, $ctx);
            $ok = $res && (json_decode($res, true)['success'] ?? false);
            if (!$ok) {
                return 'Spam check failed. Please try again.';
            }
        }
        return null;
    }
}
