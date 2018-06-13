<?php
return [
    'disks' => [
        'backups' => [
            'driver' => 'local',
            'root' => storage_path(config('backup-migrations.path')),
        ],
    ],
];