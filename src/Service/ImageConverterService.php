<?php
// src/Service/ImageConverterService.php
namespace App\Service;

class ImageConverterService
{
    public function convertToWebP(string $sourcePath, string $destinationPath, int $quality = 80): bool
    {
        $info = getimagesize($sourcePath);
        $extension = $info['mime'] ?? null;

        if (!$extension) return false;

        switch ($extension) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($sourcePath);
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                break;
            default:
                return false; // format non supporté
        }

        $result = imagewebp($image, $destinationPath, $quality);
        imagedestroy($image);

        return $result;
    }
}
