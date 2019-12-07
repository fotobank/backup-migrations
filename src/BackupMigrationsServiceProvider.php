<?php

namespace Fotobank\BackupMigrations;

use Illuminate\Database\MigrationServiceProvider;
use Midnite81\LaravelBase\BaseServiceProvider;
use Fotobank\BackupMigrations\Commands\MigrateCommand;
use Fotobank\BackupMigrations\Commands\RestoreCommand;
use Fotobank\BackupMigrations\Commands\SeedCommand;

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
        $this->publishes([__DIR__ . '/../config/backup-migrations.php' => config_path('backup-migrations.php')],'backup-migrations');
        $this->mergeConfigFrom(__DIR__ . '/../config/filesystem.php', 'filesystems');
    }
}
