<?php
return [
    'disks' => [
        'backup-migrations' => [
            'driver' => 'local',
            'root' => storage_path(config('backup-migrations.path')),
        ],
    ],
];
