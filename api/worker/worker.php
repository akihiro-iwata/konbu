<?php
// Agent側で動くデーモンプロセスのサンプル
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

    /*
     * 先にworkerプロセスが立ち上がった場合、channelにqueueが登録されていない。
     * この状態でconsumeを走らせるとエラーになるため、これを回避する。
     * */
    $channel->queue_declare('queue', false, true, false, false);

    echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

    $callback = function ($msg) {
        echo " [x] Received ", $msg->body, "\n";
        echo " [x] Correlation Id ", $msg->get('correlation_id'), "\n";

        instancesAdd(); // 仮想マシン起動
        echo " [x] Done", "\n";
        /*
         * acknowledgeを飛ばすことで、queueのタスクが完了したことをRabbitMQへ伝える。
         * ackが飛んでこない状態でconnectionが切れた場合、RabbitMQは別のworkerへqueueを投げる。
         * */
        $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
    };
    $channel->basic_consume('queue', '', false, false, false, false, $callback);

    /*
     * RabbitMQが投げたQueueの数 - 返ってきたackの数が常に1以下になるようにする。
     * 負荷分散のため。
     * */
    $channel->basic_qos(null, 1, null);

    while (count($channel->callbacks)) {
        $channel->wait();
    }

    $channel->close();
    $connection->close();
}

/*
 * 仮想マシンを起動する。
 * */
function instancesAdd()
{
    // TODO: Call KVM Command


    // TODO: send Message to RabbitMQ for Database update

}