<?php
require __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

if (PHP_SAPI == 'cli') {
    $connection = new AMQPStreamConnection(
        'localhost', // RabbitMQホスト名
        5672, // RabbitMQポート
        'guest', // RabbitMQユーザ
        'guest' // RabbitMQパスワード
    );
    $channel = $connection->channel();
    $channel->queue_declare('queue', false, true, false, false);

    echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

    $callback = function ($msg) {
        echo " [x] Received ", $msg->body, "\n";
        sleep(substr_count($msg->body, '.'));
        echo " [x] Done", "\n";
        $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
    };
    $channel->basic_consume('queue', '', false, false, false, false, $callback);
    $channel->basic_qos(null, 1, null);

    while (count($channel->callbacks)) {
        $channel->wait();
    }

    $channel->close();
    $connection->close();
}

function instancesAdd()
{
    // TODO: Call KVM Command


    // TODO: send Message to RabbitMQ for Database update

}