<?php

namespace App\Providers;

use Google\Client;
use Google\Service\Drive;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Spatie\FlysystemGoogleDrive\GoogleDriveAdapter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Check if accessed via ngrok or other proxy
        $isProxied = isset($_SERVER['HTTP_X_FORWARDED_PROTO']) || isset($_SERVER['HTTP_X_FORWARDED_HOST']);

        // Trust proxy headers and force correct URL when accessed via ngrok
        if ($isProxied) {
            if (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
                URL::forceScheme($_SERVER['HTTP_X_FORWARDED_PROTO']);
            }
            // Use APP_URL when accessed via proxy (ngrok)
            if ($appUrl = config('app.url')) {
                URL::forceRootUrl($appUrl);
            }
        }

        // Force HTTPS and root URL for production environment
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
            if ($appUrl = config('app.url')) {
                URL::forceRootUrl($appUrl);
            }
        }

        Storage::extend('google', function ($app, $config) {
            $client = new Client();
            $client->setClientId($config['clientId']);
            $client->setClientSecret($config['clientSecret']);
            $client->refreshToken($config['refreshToken']);
            $client->setAccessType('offline');

            $service = new Drive($client);
            $adapter = new GoogleDriveAdapter($service, $config['folderId'] ?? null);
            $filesystem = new Filesystem($adapter);

            return new FilesystemAdapter($filesystem, $adapter, $config);
        });
    }
}
