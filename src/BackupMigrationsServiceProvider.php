<?php

namespace Pangolinkeys\BackupMigrations;

use Illuminate\Database\MigrationServiceProvider;
use Midnite81\LaravelBase\BaseServiceProvider;
use Pangolinkeys\BackupMigrations\Commands\MigrateCommand;
use Pangolinkeys\BackupMigrations\Commands\RestoreCommand;
use Pangolinkeys\BackupMigrations\Commands\SeedCommand;

class BackupMigrationsServiceProvider extends MigrationServiceProvider
{
    public function register()
    {
        parent::register();

        $this->app->extend('command.migrate', function ($old) {
            return new MigrateCommand($old);
        });

        $this->app->extend('command.seed', function ($old) {
            return new SeedCommand($old);
        });

        $this->app->register(BaseServiceProvider::class);

        $this->commands([
            RestoreCommand::class,
        ]);
        $this->publishes([__DIR__ . '/../config' => base_path('config')]);
    }
}