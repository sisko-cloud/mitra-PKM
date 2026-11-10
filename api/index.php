<?php

// Vercel Serverless Entrypoint for Laravel

// Initialize writable storage directories in /tmp
$directories = [
    '/tmp/storage/app/public/logos',
    '/tmp/storage/app/public/dokumen',
    '/tmp/storage/app/public/heroes',
    '/tmp/storage/app/public/products',
    '/tmp/storage/app/dokumen',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
];

foreach ($directories as $dir) {
    if (! is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// Ensure session, storage, and cache directories point to writable /tmp
putenv('APP_STORAGE=/tmp/storage');
$_ENV['APP_STORAGE'] = '/tmp/storage';
$_SERVER['APP_STORAGE'] = '/tmp/storage';

putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';
$_SERVER['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';

require __DIR__ . '/../public/index.php';
