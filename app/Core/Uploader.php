<?php
declare(strict_types=1);

namespace App\Core;

final class Uploader
{
    /**
     * Validate and store an uploaded image under public/uploads/blog.
     * @return array{0: ?string, 1: ?string} [stored filename, error message]
     */
    public static function image(string $field): array
    {
        $file = $_FILES[$field] ?? null;
        if (!$file || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return [null, null];
        }
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return [null, 'The image could not be uploaded. Please try again.'];
        }
        if ($file['size'] > config('uploads.max_bytes')) {
            return [null, 'Image is too large. Maximum size is 2 MB.'];
        }

        // Detect the real type from file contents, never from the client-supplied name/type.
        $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
        $ext = config('uploads.types')[$mime] ?? null;
        if ($ext === null || @getimagesize($file['tmp_name']) === false) {
            return [null, 'Only JPG, PNG or WebP images are allowed.'];
        }

        $name = bin2hex(random_bytes(12)) . '.' . $ext;
        $dir = ROOT . '/public/uploads/blog';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        if (!move_uploaded_file($file['tmp_name'], $dir . '/' . $name)) {
            return [null, 'Could not save the uploaded image.'];
        }
        return [$name, null];
    }

    public static function delete(?string $filename): void
    {
        if ($filename && preg_match('/^[a-f0-9]{24}\.(jpg|png|webp)$/', $filename)) {
            @unlink(ROOT . '/public/uploads/blog/' . $filename);
        }
    }
}
