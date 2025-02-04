<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

trait ImageUploadTrait
{
    /**
     * Upload an image to the specified folder and delete the existing image if needed.
     *
     * @param UploadedFile $image
     * @param string $folderName
     * @param string|null $existingImagePath
     * @return string The path of the uploaded image.
     */
    public function uploadImage(UploadedFile $image, string $folderName, ?string $existingImagePath = null): string
    {
        // Define the path where the image will be stored
        $publicPath = public_path("uploads/{$folderName}/");

        // Create the folder if it doesn't exist
        if (!file_exists($publicPath)) {
            mkdir($publicPath, 0755, true);
        }

        // Check if an existing image path is provided
        if ($existingImagePath) {
            // Define the full path for the existing image
            $existingImageFullPath = public_path($existingImagePath);

            // Delete the existing image if it exists
            if (file_exists($existingImageFullPath)) {
                unlink($existingImageFullPath);
            }
        }

        // Generate a new filename for the uploaded image
        $filename = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());
        $imagePath = "uploads/{$folderName}/{$filename}";

        // Move the new image to the public directory
        $image->move($publicPath, $filename);

        return $imagePath;
    }

    public function deleteImage(string $imagePath): bool
    {
        // Define the full path for the image
        $imageFullPath = public_path($imagePath);

        // Check if the file exists and delete it
        if (file_exists($imageFullPath)) {
            return unlink($imageFullPath);
        }

        return false;
    }
}
