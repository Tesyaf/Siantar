<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Folder ID: " . config('services.google.folder_id') . "\n";

// Test upload sederhana
$service = app(\App\Services\GoogleDriveService::class);
echo "isConfigured: " . ($service->isConfigured() ? 'YES' : 'NO') . "\n";

// Coba upload test file
try {
    $client = new \Google\Client();
    $client->setApplicationName(config('services.google.app_name'));
    $client->setAuthConfig(config('services.google.credentials_path'));
    $client->setScopes([\Google\Service\Drive::DRIVE]);

    $driveService = new \Google\Service\Drive($client);
    $folderId = config('services.google.folder_id');

    echo "Uploading to folder: $folderId\n";

    // Create a test file with parents explicitly set
    $driveFile = new \Google\Service\Drive\DriveFile();
    $driveFile->setName('test_upload_' . time() . '.txt');
    $driveFile->setParents([$folderId]);

    $uploadedFile = $driveService->files->create($driveFile, [
        'data' => 'Test content from SIANTAR app',
        'mimeType' => 'text/plain',
        'uploadType' => 'multipart',
        'fields' => 'id, name, parents',
        'supportsAllDrives' => true,
    ]);

    echo "Upload test: SUCCESS\n";
    echo "File ID: " . $uploadedFile->getId() . "\n";
    echo "File Name: " . $uploadedFile->getName() . "\n";

    // Delete test file
    $driveService->files->delete($uploadedFile->getId());
    echo "Test file deleted\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
