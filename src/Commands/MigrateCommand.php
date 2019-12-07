<?php

namespace Fotobank\BackupMigrations\Commands;

use Illuminate\Database\Console\Migrations\MigrateCommand as BaseMigrateCommand;
use Illuminate\Support\Facades\Artisan;
use Fotobank\BackupMigrations\Services\File;
use Carbon\Carbon;

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
     * Command logic.
     */
    protected function action()
    {
	    File::backupSQL('migrations');
    }

}
