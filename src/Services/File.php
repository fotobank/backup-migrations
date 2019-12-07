<?php

namespace Fotobank\BackupMigrations\Services;

use Illuminate\Support\Facades\Storage;

class File
{
    /**
     * Tidy up the file structure before storing the backup.
     * Allows you to limit the number of files that are
     * stored at any given time. By default 5.
     *
     * @param int $numberOfRotations
     * @return mixed
     */
    public static function tidy($numberOfRotations = 5)
    {
        $diskName = config('backup-migrations.disk');

        $files = Storage::disk($diskName)->allFiles();

        if (count($files) >= $numberOfRotations) {
            Storage::disk($diskName)->delete($files[0]);
            self::tidy($numberOfRotations);
        }

        return Storage::disk($diskName)->getAdapter()->getPathPrefix();
    }

    /**
     * Get a file before executing the restore
     * command. By default get the latest
     * file in the directory.
     *
     * @param mixed $file
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public static function getBackup($file = null)
    {
        $diskName = config('backup-migrations.disk');

        if (is_null($file)) {
            $files = Storage::disk($diskName)->allFiles();

            if (count($files) > 0) {
                $file = Storage::disk($diskName)->get(array_last($files));
            } else {
                return null;
            }
        } else {
            if (Storage::disk($diskName)->exists($file)) {
                $file = Storage::disk($diskName)->get($file);
            } else {
                return null;
            }
        }

        return $file;
    }
}
