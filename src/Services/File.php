<?php

namespace Fotobank\BackupMigrations\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
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
    public static function tidy($numberOfRotations)
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
    
    public static function backupSQL($command){
    	
	    File::tidy(config('backup-migrations.backupCount') ?? 5 );

	    $path = config('backup-migrations.path');
	    $connectionName = config('database.default');
	    $filename = str_slug($connectionName) . '-' . Carbon::now()->format('Y-m-d_H-i-s') . '.sql';

	    Artisan::call('backup:mysql-dump', ['filename'=>$path . DIRECTORY_SEPARATOR . $filename]);

	    echo 'application in ' . ((env('APP_ENV') === 'production') ? 'production' : 'development') . PHP_EOL;
	    echo "pre-{$command} database backup to {$filename} completed" . PHP_EOL;
    }
}
