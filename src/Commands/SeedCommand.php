<?php

namespace Pangolinkeys\BackupMigrations\Commands;

use Illuminate\Database\Console\Seeds\SeedCommand as BaseSeedCommand;
use Pangolinkeys\BackupMigrations\Services\File;

class SeedCommand extends BaseSeedCommand
{
    /**
     * @var BaseSeedCommand
     */
    protected $old;

    /**
     * SeedCommand constructor.
     *
     * @param BaseSeedCommand $old
     */
    public function __construct(BaseSeedCommand $old)
    {
        parent::__construct($old->resolver);
        $this->old = $old;
    }

    /**
     * For older versions of Laravel.
     */
    public function fire()
    {
        $this->action();

        return $this->old->handle();
    }

    /**
     * Command Logic.
     */
    protected function action()
    {
        $backupCount = config('backup-migrations.backupCount');
        if (empty($backupCount)) {
            File::tidy();
        } else {
            File::tidy($backupCount);
        }
        $disk = config('backup-migrations.disk');
        if (env('APP_ENV') === 'production') {
            Artisan::call('database:backup', [
                'directory' => implode('/', array_slice(explode('/', config("filesystems.disks.$disk.root")), -3, 3)),
            ]);
            echo 'Backup Completed' . PHP_EOL;
        } else {
            echo 'Application in development' . PHP_EOL;
        }
    }

    /**
     * For newer versions of Laravel.
     */
    public function handle()
    {
        $this->action();

        return $this->old->handle();
    }
}