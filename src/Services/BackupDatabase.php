<?php

namespace Pangolinkeys\BackupMigrations\Services;

use Illuminate\Support\Facades\DB;

class BackupDatabase
{
    protected $file = '';

    public function run()
    {
        $tables = DB::select('SHOW TABLES');

        foreach ($tables as $table) {
            $result = DB::select('SELECT * FROM $table');

            $this->file .= "DROP TABLE $table;";

            $this->file .= DB::select("SHOW CREATE TABLE $table") . ';';

        }


        dd($this->file);
    }
}