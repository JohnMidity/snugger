<?php
require_once __DIR__ . '/bootstrap/app.php';

if (! isset($container)) {
    /*
     * The container will be available if we run as phinx,
     * but must be defined as a global when we run a PHPUnit test
     */
    global $container;
}

$config = $container['settings']['database'];

return [
    'paths' => [
        'migrations' => 'Database/Migrations'
    ],
    'migration_base_class' => 'App\Database\Migrations\Migration',
    'templates' => [
        'file' => 'app/Database/Migrations/MigrationStub.php'
    ],
    'environments' => [
        'default_migration_table' => 'migrations',
        'default' => [
            'adapter' => $config['driver'],
            'host' => $config['host'],
            'port' => $config['port'],
            'name' => $config['database'],
            'user' => $config['username'],
            'pass' => $config['password']
        ]
    ]
];

?>