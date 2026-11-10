<?php

use Illuminate\Support\Str;

// Auto-detect and normalize Neon Serverless PostgreSQL connection URL / Host
$databaseUrl = env('DATABASE_URL');
$dbHost = env('DB_HOST', '127.0.0.1');
$dbPort = env('DB_PORT', '5432');
$dbName = env('DB_DATABASE', 'forge');
$dbUser = env('DB_USERNAME', 'forge');
$dbPass = env('DB_PASSWORD', '');
$dbSsl = env('DB_SSLMODE', 'require');

if (! empty($databaseUrl)) {
    $parsedUrl = parse_url($databaseUrl);
    if (! empty($parsedUrl['host'])) {
        $rawHost = $parsedUrl['host'];
        if (str_contains($rawHost, 'neon.tech') && ! str_contains($rawHost, 'options=')) {
            $endpoint = explode('.', str_replace('-pooler', '', $rawHost))[0];
            $dbHost = "{$rawHost};options='endpoint={$endpoint}'";
        } else {
            $dbHost = $rawHost;
        }
        $dbPort = $parsedUrl['port'] ?? $dbPort;
        $dbName = isset($parsedUrl['path']) ? ltrim($parsedUrl['path'], '/') : $dbName;
        $dbUser = $parsedUrl['user'] ?? $dbUser;
        $dbPass = $parsedUrl['pass'] ?? $dbPass;

        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $query);
            $dbSsl = $query['sslmode'] ?? $dbSsl;
        }

        // Set to null so Laravel uses our normalized host with options rather than unparsed URL
        $databaseUrl = null;
    }
} elseif (is_string($dbHost) && str_contains($dbHost, 'neon.tech') && ! str_contains($dbHost, 'options=')) {
    $cleanHost = explode(';', $dbHost)[0];
    $endpoint = explode('.', str_replace('-pooler', '', $cleanHost))[0];
    $dbHost = "{$cleanHost};options='endpoint={$endpoint}'";
}

$isPgsqlDefault = (! empty(env('DATABASE_URL')) || str_contains($dbHost, 'neon.tech') || env('DB_CONNECTION') === 'pgsql');

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    */

    'default' => env('DB_CONNECTION', $isPgsqlDefault ? 'pgsql' : 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => $databaseUrl,
            'host' => $dbHost,
            'port' => $dbPort,
            'database' => $dbName,
            'username' => $dbUser,
            'password' => $dbPass,
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => $dbSsl,
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            // 'encrypt' => env('DB_ENCRYPT', 'yes'),
            // 'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'false'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
