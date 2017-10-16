<?php
use Slim\Http\Request;
use Slim\Http\Response;
use PhpAmqpLib\Message\AMQPMessage;

// Routes
$app->post('/instances', function ($request, $response) {
    $channel = $this->connection->channel();
    $channel->queue_declare('queue', false, true, false, false);

    $msg = new AMQPMessage('instances add', [
        'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
    ]);
    $channel->basic_publish($msg, '', 'queue');

    // return json
    return $response->withJson(['status' => 'ok']);
});

$app->get('/instances', function ($request, $response) {
    // TODO: DB Query
    $stub = [
        [
            "InstanceId" => "instance-1",
            "server" => "host-2",
            "ID" => "1",
        ],
        [
            "InstanceId" => "instance-1",
            "server" => "host-2",
            "ID" => "1",
        ],
    ];
    return $response->withJson($stub);
});

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

