<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Small dependency-free mailer.
 * Drivers: log (dev, writes storage/logs/mail.log), mail (PHP mail()), smtp (SSL/TLS/plain AUTH LOGIN).
 */
final class Mailer
{
    public static function send(string $to, string $subject, string $html, ?string $replyTo = null): bool
    {
        $cfg = config('mail');
        $text = trim(html_entity_decode(strip_tags(preg_replace('#<br\s*/?>|</p>#i', "\n", $html)), ENT_QUOTES, 'UTF-8'));

        try {
            return match ($cfg['driver']) {
                'smtp'  => self::smtp($cfg, $to, $subject, $html, $text, $replyTo),
                'mail'  => self::phpMail($cfg, $to, $subject, $html, $replyTo),
                default => self::log($to, $subject, $text),
            };
        } catch (\Throwable $e) {
            error_log('Mailer error: ' . $e->getMessage());
            return false;
        }
    }

    private static function log(string $to, string $subject, string $text): bool
    {
        $entry = '[' . date('Y-m-d H:i:s') . "] To: $to | Subject: $subject\n$text\n" . str_repeat('-', 60) . "\n";
        return file_put_contents(ROOT . '/storage/logs/mail.log', $entry, FILE_APPEND | LOCK_EX) !== false;
    }

    private static function headers(array $cfg, string $subject, ?string $replyTo, string $boundary): array
    {
        $headers = [
            'From: ' . self::encodeName($cfg['from_name']) . ' <' . $cfg['from'] . '>',
            'MIME-Version: 1.0',
            "Content-Type: multipart/alternative; boundary=\"$boundary\"",
        ];
        if ($replyTo && filter_var($replyTo, FILTER_VALIDATE_EMAIL)) {
            $headers[] = 'Reply-To: ' . $replyTo;
        }
        return $headers;
    }

    private static function encodeName(string $name): string
    {
        return '=?UTF-8?B?' . base64_encode($name) . '?=';
    }

    private static function body(string $html, string $text, string $boundary): string
    {
        return "--$boundary\r\nContent-Type: text/plain; charset=UTF-8\r\nContent-Transfer-Encoding: base64\r\n\r\n"
            . chunk_split(base64_encode($text))
            . "--$boundary\r\nContent-Type: text/html; charset=UTF-8\r\nContent-Transfer-Encoding: base64\r\n\r\n"
            . chunk_split(base64_encode($html))
            . "--$boundary--\r\n";
    }

    private static function phpMail(array $cfg, string $to, string $subject, string $html, ?string $replyTo): bool
    {
        $boundary = 'b' . bin2hex(random_bytes(8));
        $text = strip_tags($html);
        return mail(
            $to,
            '=?UTF-8?B?' . base64_encode($subject) . '?=',
            self::body($html, $text, $boundary),
            implode("\r\n", self::headers($cfg, $subject, $replyTo, $boundary))
        );
    }

    private static function smtp(array $cfg, string $to, string $subject, string $html, string $text, ?string $replyTo): bool
    {
        $prefix = $cfg['encryption'] === 'ssl' ? 'ssl://' : '';
        $fp = @stream_socket_client($prefix . $cfg['host'] . ':' . $cfg['port'], $errno, $errstr, 15);
        if (!$fp) {
            throw new \RuntimeException("SMTP connect failed: $errstr");
        }
        stream_set_timeout($fp, 15);

        $read = function () use ($fp): string {
            $data = '';
            while (($line = fgets($fp, 515)) !== false) {
                $data .= $line;
                if (isset($line[3]) && $line[3] === ' ') {
                    break;
                }
            }
            return $data;
        };
        $cmd = function (string $line, string $expect) use ($fp, $read): void {
            fwrite($fp, $line . "\r\n");
            $resp = $read();
            if (!str_starts_with($resp, $expect)) {
                throw new \RuntimeException("SMTP error after '" . explode(' ', $line)[0] . "': $resp");
            }
        };

        $read();
        $host = $_SERVER['SERVER_NAME'] ?? 'localhost';
        $cmd("EHLO $host", '250');
        if ($cfg['encryption'] === 'tls') {
            $cmd('STARTTLS', '220');
            stream_socket_enable_crypto($fp, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
            $cmd("EHLO $host", '250');
        }
        if ($cfg['username'] !== '') {
            $cmd('AUTH LOGIN', '334');
            $cmd(base64_encode($cfg['username']), '334');
            $cmd(base64_encode($cfg['password']), '235');
        }
        $cmd('MAIL FROM:<' . $cfg['from'] . '>', '250');
        $cmd("RCPT TO:<$to>", '250');
        $cmd('DATA', '354');

        $boundary = 'b' . bin2hex(random_bytes(8));
        $headers = self::headers($cfg, $subject, $replyTo, $boundary);
        $headers[] = "To: <$to>";
        $headers[] = 'Subject: =?UTF-8?B?' . base64_encode($subject) . '?=';
        $headers[] = 'Date: ' . date('r');
        $headers[] = 'Message-ID: <' . bin2hex(random_bytes(8)) . '@' . $host . '>';

        $message = implode("\r\n", $headers) . "\r\n\r\n" . self::body($html, $text, $boundary);
        $message = preg_replace('/^\./m', '..', $message);
        fwrite($fp, $message . "\r\n.\r\n");
        if (!str_starts_with($read(), '250')) {
            throw new \RuntimeException('SMTP message rejected');
        }
        $cmd('QUIT', '221');
        fclose($fp);
        return true;
    }
}
