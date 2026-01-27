<?php

namespace App\Http\Controllers;

use Google\Client;
use Illuminate\Http\Request;

class GoogleAuthController extends Controller
{
    /**
     * Redirect to Google OAuth consent screen
     * Hanya admin yang bisa akses
     */
    public function redirect(Request $request)
    {
        if (!$request->user()?->hasRole('admin')) {
            abort(403, 'Hanya admin yang bisa setup Google Drive.');
        }

        $client = $this->getClient();
        $authUrl = $client->createAuthUrl();

        return redirect()->away($authUrl);
    }

    /**
     * Handle callback from Google OAuth
     */
    public function callback(Request $request)
    {
        if (!$request->user()?->hasRole('admin')) {
            abort(403);
        }

        if ($request->has('error')) {
            return redirect()->route('dashboard')
                ->with('error', 'Google authorization failed: ' . $request->get('error'));
        }

        $code = $request->get('code');
        if (!$code) {
            return redirect()->route('dashboard')
                ->with('error', 'No authorization code received.');
        }

        $client = $this->getClient();

        try {
            $token = $client->fetchAccessTokenWithAuthCode($code);

            if (isset($token['error'])) {
                return redirect()->route('dashboard')
                    ->with('error', 'Error getting token: ' . $token['error_description']);
            }

            $refreshToken = $token['refresh_token'] ?? null;

            if (!$refreshToken) {
                return redirect()->route('dashboard')
                    ->with('error', 'No refresh token received. Please revoke access at https://myaccount.google.com/permissions and try again.');
            }

            // Tampilkan refresh token untuk disimpan di .env
            return view('admin.google-token', [
                'refreshToken' => $refreshToken,
                'email' => $this->getAuthenticatedEmail($client),
            ]);
        } catch (\Exception $e) {
            return redirect()->route('dashboard')
                ->with('error', 'Failed to get token: ' . $e->getMessage());
        }
    }

    /**
     * Test current Google Drive connection
     */
    public function test(Request $request)
    {
        if (!$request->user()?->hasRole('admin')) {
            abort(403);
        }

        $refreshToken = config('services.google.refresh_token');

        if (!$refreshToken) {
            return response()->json([
                'success' => false,
                'message' => 'Refresh token belum dikonfigurasi. Silakan setup di /google/auth',
            ]);
        }

        try {
            $client = $this->getClient();
            $client->fetchAccessTokenWithRefreshToken($refreshToken);

            $driveService = new \Google\Service\Drive($client);
            $folderId = config('services.google.folder_id');

            // Test list files in folder
            $results = $driveService->files->listFiles([
                'q' => "'{$folderId}' in parents and trashed = false",
                'pageSize' => 5,
                'fields' => 'files(id, name)',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Google Drive connected!',
                'files_count' => count($results->getFiles()),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Connection failed: ' . $e->getMessage(),
            ]);
        }
    }

    private function getClient(): Client
    {
        $client = new Client();
        $client->setApplicationName(config('services.google.app_name', 'SIANTAR'));
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect_uri'));
        $client->setAccessType('offline'); // Penting untuk dapat refresh token
        $client->setPrompt('consent'); // Force consent untuk dapat refresh token
        $client->addScope(\Google\Service\Drive::DRIVE);

        return $client;
    }

    private function getAuthenticatedEmail(Client $client): ?string
    {
        try {
            $oauth2 = new \Google\Service\Oauth2($client);
            $userInfo = $oauth2->userinfo->get();
            return $userInfo->getEmail();
        } catch (\Exception $e) {
            return null;
        }
    }
}
