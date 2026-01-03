<?php

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\File;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$imagesPath = public_path('images');
if (!File::exists($imagesPath)) {
    die("Images directory not found at $imagesPath\n");
}

$images = File::allFiles($imagesPath);

$mapping = [];

echo "Found " . count($images) . " images to migrate.\n";

foreach ($images as $image) {
    // echo "Uploading " . $image->getFilename() . "...\n";
    try {
        $upload = Cloudinary::uploadApi()->upload($image->getRealPath(), [
            'folder' => 'minari_static',
            'use_filename' => true,
            'unique_filename' => false,
            'overwrite' => true
        ]);

        $url = $upload['secure_url'];
        $mapping[$image->getFilename()] = $url;
        echo "Uploaded: " . $image->getFilename() . " -> $url\n";
    } catch (\Exception $e) {
        echo "Failed to upload " . $image->getFilename() . ": " . $e->getMessage() . "\n";
    }
}

echo "\n--- MAPPING START ---\n";
echo json_encode($mapping, JSON_PRETTY_PRINT);
echo "\n--- MAPPING END ---\n";
