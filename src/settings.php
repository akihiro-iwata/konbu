<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

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
            'host' => isset($_ENV['rabbit-host']) ? $_ENV['rabbit-host'] : 'localhost',
            'port' => isset($_ENV['rabbit-port']) ? $_ENV['rabbit-port'] : '5672',
            'user' => isset($_ENV['rabbit-user']) ? $_ENV['rabbit-user'] : 'guest',
            'pass' => isset($_ENV['rabbit-pass']) ? $_ENV['rabbit-pass'] : 'guest',
        ],
    ],
];
