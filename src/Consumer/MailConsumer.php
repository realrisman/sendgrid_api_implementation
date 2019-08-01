<?php

namespace App\Consumer;

use App\Service\MailService;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class MailConsumer
{
    private $connection;
    private $mailService;
    private $channel;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
        $this->connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $this->channel = $this->connection->channel();
    }

    public function consume($io)
    {
        $this->channel->queue_declare('task_mail_send', false, true, false, false);

        echo " [*] Waiting for messages. To exit press CTRL+C\n";

        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";

            $result = $this->mailService->send(json_decode($msg->body, true));
            if ($result['status_code'] === 202) {
                echo " [x] Done\n";
            } else {
                echo ' [x] Fail: ', $result['message'], "\n";
            }

            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        };

        $this->channel->basic_qos(null, 1, null);
        $this->channel->basic_consume('task_mail_send', '', false, false, false, false, $callback);

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }

        $this->channel->close();
        $this->connection->close();
    }
}
