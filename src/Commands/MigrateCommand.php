<?php

namespace Pangolinkeys\BackupMigrations\Commands;

use Illuminate\Database\Console\Migrations\MigrateCommand as BaseMigrateCommand;
use Illuminate\Support\Facades\Artisan;
use Pangolinkeys\BackupMigrations\Services\File;

class MigrateCommand extends BaseMigrateCommand
{
    /**
     * @var BaseMigrateCommand
     */
    protected $old;

    /**
     * MigrateCommand constructor.
     *
     * @param BaseMigrateCommand $old
     */
    public function __construct(BaseMigrateCommand $old)
    {
        parent::__construct($old->migrator);
        $this->old = $old;
    }

    /**
     * For newer versions of Laravel.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->action();

        return parent::handle();
    }

    /**
     * Command logic.
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
     * For older versions of Laravel.
     */
    public function fire()
    {
        $this->action();

        return parent::fire();
    }

}