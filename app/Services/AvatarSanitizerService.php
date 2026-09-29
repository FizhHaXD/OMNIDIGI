<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AvatarSanitizerService
{
    /**
     * Allowed MIME types and extensions for avatar images.
     */
    protected const ALLOWED_MIME_TYPES = [
        'image/jpeg' => ['jpg', 'jpeg'],
        'image/png'  => ['png'],
        'image/webp' => ['webp'],
    ];

    /**
     * Maximum allowed dimensions in pixels for input image (prevent decompression bomb).
     */
    protected const MAX_INPUT_DIMENSION = 6000;

    /**
     * Standard square dimension for stored avatar.
     */
    protected const TARGET_DIMENSION = 400;

    /**
     * Sanitize, re-encode, resize, and safely store the avatar image.
     *
     * @param UploadedFile $file
     * @param string|null $oldAvatarPath
     * @return string Stored relative file path (e.g. avatars/{hash}.webp)
     * @throws ValidationException
     */
    public function sanitizeAndStore(UploadedFile $file, ?string $oldAvatarPath = null): string
    {
        // 1. Verify file validity and size
        if (!$file->isValid()) {
            throw ValidationException::withMessages([
                'avatar' => 'Berkas gambar tidak valid atau gagal diunggah.',
            ]);
        }

        if ($file->getSize() > 2 * 1024 * 1024) { // 2MB max
            throw ValidationException::withMessages([
                'avatar' => 'Ukuran foto profil maksimal 2 MB.',
            ]);
        }

        // 2. Strict client extension check
        $clientExt = strtolower($file->getClientOriginalExtension());
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($clientExt, $allowedExtensions, true)) {
            throw ValidationException::withMessages([
                'avatar' => 'Format file tidak diizinkan. Gunakan format JPG, JPEG, PNG, atau WEBP.',
            ]);
        }

        // 3. Deep binary inspection with getimagesize
        $realPath = $file->getRealPath();
        $imageInfo = @getimagesize($realPath);
        if ($imageInfo === false || empty($imageInfo[0]) || empty($imageInfo[1])) {
            throw ValidationException::withMessages([
                'avatar' => 'Berkas bukan gambar yang valid atau data gambar rusak.',
            ]);
        }

        $width = $imageInfo[0];
        $height = $imageInfo[1];
        $mimeType = $imageInfo['mime'] ?? '';

        if (!array_key_exists($mimeType, self::ALLOWED_MIME_TYPES)) {
            throw ValidationException::withMessages([
                'avatar' => 'Tipe berkas tidak didukung. Harap unggah gambar JPG, PNG, atau WEBP.',
            ]);
        }

        // Prevent image decompression bomb (extremely large dimensions)
        if ($width > self::MAX_INPUT_DIMENSION || $height > self::MAX_INPUT_DIMENSION) {
            throw ValidationException::withMessages([
                'avatar' => 'Dimensi gambar terlalu besar (maksimal 6000x6000 piksel).',
            ]);
        }

        // 4. Load image into GD memory (stripping EXIF metadata, scripts, and comments)
        $sourceImage = match ($mimeType) {
            'image/jpeg' => @imagecreatefromjpeg($realPath),
            'image/png'  => @imagecreatefrompng($realPath),
            'image/webp' => @imagecreatefromwebp($realPath),
            default      => false,
        };

        if (!$sourceImage) {
            throw ValidationException::withMessages([
                'avatar' => 'Gagal memproses gambar. Pastikan gambar tidak korup.',
            ]);
        }

        // 5. Center-crop to square and resize to target dimension (e.g. 400x400)
        $minSide = min($width, $height);
        $srcX = (int) max(0, ($width - $minSide) / 2);
        $srcY = (int) max(0, ($height - $minSide) / 2);

        $targetImage = imagecreatetruecolor(self::TARGET_DIMENSION, self::TARGET_DIMENSION);

        // Preserve alpha transparency for PNG / WebP
        imagealphablending($targetImage, false);
        imagesavealpha($targetImage, true);
        $transparent = imagecolorallocatealpha($targetImage, 255, 255, 255, 127);
        imagefilledrectangle($targetImage, 0, 0, self::TARGET_DIMENSION, self::TARGET_DIMENSION, $transparent);
        imagealphablending($targetImage, true);

        imagecopyresampled(
            $targetImage,
            $sourceImage,
            0,
            0,
            $srcX,
            $srcY,
            self::TARGET_DIMENSION,
            self::TARGET_DIMENSION,
            $minSide,
            $minSide
        );

        // 6. Encode sanitized image to WebP in memory
        ob_start();
        imagealphablending($targetImage, false);
        imagesavealpha($targetImage, true);
        imagewebp($targetImage, null, 85);
        $sanitizedContent = ob_get_clean();

        // Free GD memory
        imagedestroy($sourceImage);
        imagedestroy($targetImage);

        if (empty($sanitizedContent)) {
            throw ValidationException::withMessages([
                'avatar' => 'Gagal melakukan sanitasi berkas foto profil.',
            ]);
        }

        // 7. Generate randomized, cryptographically safe filename
        $safeFileName = 'avatars/' . Str::random(40) . '.webp';

        // 8. Store on public disk
        Storage::disk('public')->put($safeFileName, $sanitizedContent);

        // 9. Remove old avatar if it existed
        $this->deleteAvatar($oldAvatarPath);

        return $safeFileName;
    }

    /**
     * Delete an existing avatar from public storage safely.
     *
     * @param string|null $avatarPath
     * @return void
     */
    public function deleteAvatar(?string $avatarPath): void
    {
        if ($avatarPath && Storage::disk('public')->exists($avatarPath)) {
            // Ensure path starts with 'avatars/' to prevent accidental deletion outside directory
            if (str_starts_with($avatarPath, 'avatars/')) {
                Storage::disk('public')->delete($avatarPath);
            }
        }
    }
}
