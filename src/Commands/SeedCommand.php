<?php

namespace Fotobank\BackupMigrations\Commands;

use Illuminate\Database\Console\Seeds\SeedCommand as BaseSeedCommand;
use Illuminate\Support\Facades\Artisan;
use Fotobank\BackupMigrations\Services\File;
use Carbon\Carbon;

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
	    File::backupSQL('seeds');
    }
}
