<?php

namespace App\Service;

use SendGrid;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class MailService
{
    private $sg;
    private $connection;
    private $channel;

    public function __construct()
    {
        $apiKey = $_SERVER['SENDGRID_KEY'];
        $this->sg = new SendGrid($apiKey);
        $this->connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $this->channel = $this->connection->channel();
    }

    public function send($request_body)
    {
        $results = [];
        try {
            $response = $this->sg->client->mail()->send()->post($request_body);
            $results['status_code'] = $response->statusCode();
            $results['message'] = $response->body();
        } catch (Exception $e) {
            $results['status_code'] = 500;
            $results['message'] = json_encode($e->getMessage());
        }

        return $results;
    }

    public function sendToQueue($request_body)
    {
        $this->channel->queue_declare(
            'task_mail_send',
            false, // passive
            true, // durable
            false, // exclusive
            false // autodelete
        );

        $msg = new AMQPMessage(
            $request_body,
            array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)
        );

        $this->channel->basic_publish($msg, '', 'task_mail_send');

        $this->channel->close();
        $this->connection->close();

        return ['message' => 'Request has been sent!', 'status_code' => 200];
    }
}
