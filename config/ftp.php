<?php

return [
    'server' => env('FTP_SERVER', 'ftp.example.com'),
    'username' => env('FTP_USERNAME', 'your-username'),
    'password' => env('FTP_PASSWORD', 'your-password'),
    'remote_dir' => env('FTP_REMOTE_DIR', '/path/to/remote/dir'),
    'port' => env('FTP_PORT', 21),
    'timeout' => env('FTP_TIMEOUT', 90),
    'passive' => env('FTP_PASSIVE', true),
];
