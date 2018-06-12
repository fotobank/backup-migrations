<?php

namespace Pangolinkeys\BackupMigrations\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class File
{
    public function getNextRotation($numberOfRotations = 5)
    {
        $disk = config('backup-migrations.folder');
        $files = Storage::disk($disk)->allFiles();

        dd($files[0]);

        if (count($files > $numberOfRotations)) {
        }

        return $this->generateFileName();
    }

    protected function generateFileName()
    {
        return Carbon::now()->timestamp() . '.sql';
    }
}