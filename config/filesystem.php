<?php
return [
    'disks' => [
        'backup-migrations' => [
            'driver' => 'local',
            'root' => config('filesystems.disks.backup.root').'/'.config('backup-migrations.path'),
        ],
    ],
];
