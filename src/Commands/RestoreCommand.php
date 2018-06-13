<?php

namespace Pangolinkeys\BackupMigrations\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Pangolinkeys\BackupMigrations\Services\File;

class RestoreCommand extends Command
{
    protected $signature = 'migrate:restore 
                            {--file= : A specific file that should be rolled back to.}';

    protected $description = 'Restore the database to a backup.';

    /**
     * RestoreCommand constructor.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * For newer versions of Laravel.
     */
    public function handle()
    {
        $this->action();
    }

    /**
     * Command logic.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function action()
    {
        if ($this->hasArgument('file')) {
            $file = File::getBackup($this->argument('file'));
        } else {
            $file = File::getBackup();
        }

        if ($file) {
            DB::unprepared($file);
        }
    }

    /**
     * For older versions of Laravel.
     */
    public function fire()
    {
        $this->action();
    }
}