<?php

namespace Fotobank\BackupMigrations\Commands;

use Illuminate\Database\Console\Seeds\SeedCommand as BaseSeedCommand;
use Illuminate\Support\Facades\Artisan;
use Fotobank\BackupMigrations\Services\File;

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
     * Handle the command execution.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->action();

        if (method_exists($this, 'fire')) {
            return parent::fire();
        } else {
            return parent::handle();
        }
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
}
