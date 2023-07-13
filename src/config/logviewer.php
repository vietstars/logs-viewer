<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Pattern and storage path settings
    |--------------------------------------------------------------------------
    |
    | The env key for pattern and storage path with a default value
    |
    */
    'max_file_size' => 52428800, // size in Byte
    'pattern'       => env('LOGSVIEWER_PATTERN', '*.log'),
    'storage_path'  => env('LOGSVIEWER_STORAGE_PATH', storage_path('logs')),
];
