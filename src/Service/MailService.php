<?php

namespace App\Service;

use SendGrid;

class MailService
{
    private $sg;

    public function __construct()
    {
        $apiKey = $_SERVER['SENDGRID_KEY'];
        $this->sg = new SendGrid($apiKey);
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
}
