<?php

namespace Pangolinkeys\BackupMigrations;

use Illuminate\Support\ServiceProvider;
use Midnite81\LaravelBase\BaseServiceProvider;

class BackupMigrationsServiceProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $this->app->register(BaseServiceProvider::class);
    }
}