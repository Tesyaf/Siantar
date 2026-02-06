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
        // Trust Ngrok proxy headers
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            URL::forceScheme($_SERVER['HTTP_X_FORWARDED_PROTO']);
        }

        // Force HTTPS and root URL only for production environment
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
