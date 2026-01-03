<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

echo "--- Cloudinary Debug ---\n";

// 1. Check Config
$config = config('cloudinary');
echo "Cloud Name in Config: " . ($config['cloud_name'] ?? 'NULL') . "\n";
echo "API Key in Config: " . (isset($config['api_key']) ? 'SET' : 'NULL') . "\n";
echo "API Secret in Config: " . (isset($config['api_secret']) ? 'SET' : 'NULL') . "\n";
echo "Cloud URL in Config: " . (isset($config['cloud_url']) ? 'SET' : 'NULL') . "\n";

// 2. Test Upload
try {
    echo "Attempting test upload...\n";
    // Create a dummy file
    $dummyFile = 'test_debug_image.txt';
    file_put_contents($dummyFile, 'This is a test file for Cloudinary verification.');
    
    $uploaded = Cloudinary::uploadApi()->upload($dummyFile, [
        'folder' => 'debug_test',
        'resource_type' => 'auto'
    ]);
    
    echo "UPLOAD SUCCESS!\n";
    echo "Public ID: " . $uploaded['public_id'] . "\n";
    echo "URL: " . $uploaded['secure_url'] . "\n";
    
    // Clean up
    unlink($dummyFile);
    
} catch (\Exception $e) {
    echo "UPLOAD FAILED: " . $e->getMessage() . "\n";
}
