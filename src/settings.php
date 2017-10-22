<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'determineRouteBeforeAppMiddleware' => false,

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        'rabbitMQ' => [
            'host' => getenv('rabbit-host') ? getenv('rabbit-host') : 'localhost',
            'port' => getenv('rabbit-port') ? getenv('rabbit-port') : '5672',
            'user' => getenv('rabbit-user') ? getenv('rabbit-user') : 'guest',
            'pass' => getenv('rabbit-pass') ? getenv('rabbit-pass') : 'guest',
        ],
        'db' => [
            'host' => getenv('db_host'),
            'port' => getenv('db_port'),
            'username' => getenv('db_user'),
            'password' => getenv('db_pass'),
            'database' => getenv('db_name'),
            'driver' => 'mysql',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ],
    ],
];
