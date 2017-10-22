<?php
namespace Konbu\Controller;

use Slim\Container;
use PhpAmqpLib\Message\AMQPMessage;
use JsonSchema\Validator;

class InstanceController
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function index($request, $response, $args)
    {
        $instances = $this->container->database->table('instance')->get();
        return $response->withJson($instances);
    }

    public function add($request, $response, $args)
    {
        $channel = $this->container->connection->channel();
        $channel->queue_declare('queue', false, true, false, false);

        $correlationId = uniqid(str_replace('.', '', (string)microtime(TRUE)) . '_');
        $msg = new AMQPMessage('instances add', [
            'correlation_id' => $correlationId,
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
        ]);

        $channel->basic_qos(null, 1, null);
        $channel->basic_publish($msg, '', 'queue');

        // return json
        return $response->withJson(['status' => 'ok']);
    }
}