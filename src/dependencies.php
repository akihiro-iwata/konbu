<?php
use PhpAmqpLib\Connection\AMQPStreamConnection;

// DIC configuration
$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// RabbitMQ
$container['connection'] = function ($c){
    $rabbit = $c->get('settings')['rabbitMQ'];
    return new AMQPStreamConnection(
        $rabbit['host'],
        $rabbit['port'],
        $rabbit['user'],
        $rabbit['pass']
    );
};

// Eloquent
$container['database'] = function ($c){
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($c['settings']['db']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};