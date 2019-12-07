<?php
return [
    'disks' => [
	    'backup' => [
		    'driver' => 'local',
		    'root' => storage_path('mysql_dump'),
		    'url' => env('APP_URL').'/storage',
		    'visibility' => 'public',
	    ],
        'backup-migrations' => [
            'driver' => 'local',
            'root' => storage_path('mysql_dump').'/'.config('backup-migrations.path'),
        ],
    ],
];
