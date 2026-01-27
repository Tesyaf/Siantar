<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GoogleDriveService
{
    protected Client $client;
    protected ?Drive $driveService = null;
    protected ?string $folderId;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setApplicationName(config('services.google.app_name', 'SIANTAR'));

        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');
        $refreshToken = config('services.google.refresh_token');

        if ($clientId && $clientSecret && $refreshToken) {
            $this->client->setClientId($clientId);
            $this->client->setClientSecret($clientSecret);
            $this->client->setAccessType('offline');
            $this->client->addScope(Drive::DRIVE);

            // Use refresh token to get access token
            $this->client->fetchAccessTokenWithRefreshToken($refreshToken);

            $this->driveService = new Drive($this->client);
        }

        $this->folderId = config('services.google.folder_id');
    }

    /**
     * Check if Google Drive is configured
     */
    public function isConfigured(): bool
    {
        $refreshToken = config('services.google.refresh_token');
        return $refreshToken && $this->folderId && $this->driveService !== null;
    }

    /**
     * Upload file to Google Drive
     *
     * @param UploadedFile $file
     * @param string|null $customName
     * @return array|null Returns [id, name, webViewLink, webContentLink] or null on failure
     */
    public function uploadFile(UploadedFile $file, ?string $customName = null): ?array
    {
        if (!$this->isConfigured()) {
            Log::warning('Google Drive not configured, falling back to local storage');
            return null;
        }

        try {
            $fileName = $customName ?? $file->getClientOriginalName();
            $mimeType = $file->getMimeType();
            $content = file_get_contents($file->getRealPath());

            $driveFile = new DriveFile([
                'name' => $fileName,
                'parents' => [$this->folderId],
            ]);

            $uploadedFile = $this->driveService->files->create($driveFile, [
                'data' => $content,
                'mimeType' => $mimeType,
                'uploadType' => 'multipart',
                'fields' => 'id, name, webViewLink, webContentLink, mimeType, size',
                'supportsAllDrives' => true,
            ]);

            // Set file permission to anyone with link can view
            $this->setPublicPermission($uploadedFile->getId());

            Log::info('Google Drive upload successful: ' . $uploadedFile->getId());

            return [
                'id' => $uploadedFile->getId(),
                'name' => $uploadedFile->getName(),
                'mimeType' => $uploadedFile->getMimeType(),
                'webViewLink' => $uploadedFile->getWebViewLink(),
                'webContentLink' => $uploadedFile->getWebContentLink(),
            ];
        } catch (\Exception $e) {
            Log::error('Google Drive upload failed: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            return null;
        }
    }

    /**
     * Set file permission to public (anyone with link can view)
     */
    protected function setPublicPermission(string $fileId): void
    {
        try {
            $permission = new \Google\Service\Drive\Permission([
                'type' => 'anyone',
                'role' => 'reader',
            ]);

            $this->driveService->permissions->create($fileId, $permission);
        } catch (\Exception $e) {
            Log::warning('Failed to set public permission: ' . $e->getMessage());
        }
    }

    /**
     * Delete file from Google Drive
     */
    public function deleteFile(string $fileId): bool
    {
        if (!$this->isConfigured()) {
            return false;
        }

        try {
            $this->driveService->files->delete($fileId);
            return true;
        } catch (\Exception $e) {
            Log::error('Google Drive delete failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get file info from Google Drive
     */
    public function getFile(string $fileId): ?array
    {
        if (!$this->isConfigured()) {
            return null;
        }

        try {
            $file = $this->driveService->files->get($fileId, [
                'fields' => 'id, name, mimeType, size, webViewLink, webContentLink',
            ]);

            return [
                'id' => $file->getId(),
                'name' => $file->getName(),
                'mimeType' => $file->getMimeType(),
                'size' => $file->getSize(),
                'webViewLink' => $file->getWebViewLink(),
                'webContentLink' => $file->getWebContentLink(),
            ];
        } catch (\Exception $e) {
            Log::error('Google Drive get file failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get preview URL (for iframe embedding)
     */
    public static function getPreviewUrl(string $fileId): string
    {
        return "https://drive.google.com/file/d/{$fileId}/preview";
    }

    /**
     * Get view URL (opens in Google Drive viewer)
     */
    public static function getViewUrl(string $fileId): string
    {
        return "https://drive.google.com/file/d/{$fileId}/view?usp=sharing";
    }

    /**
     * Get download URL
     */
    public static function getDownloadUrl(string $fileId): string
    {
        return "https://drive.google.com/uc?export=download&id={$fileId}";
    }

    /**
     * Download file content from Google Drive
     */
    public function downloadFile(string $fileId): ?string
    {
        if (!$this->isConfigured()) {
            return null;
        }

        try {
            $response = $this->driveService->files->get($fileId, [
                'alt' => 'media',
            ]);

            return $response->getBody()->getContents();
        } catch (\Exception $e) {
            Log::error('Google Drive download failed: ' . $e->getMessage());
            return null;
        }
    }
}
