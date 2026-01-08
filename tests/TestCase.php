<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Run migrations for test database
        Artisan::call('migrate:fresh', [
            '--database' => 'testing',
            '--quiet' => true,
        ]);
    }
}
