<?php

namespace App\Service;

use SendGrid;

class TemplateService
{
    private $sg;

    public function __construct()
    {
        $apiKey = $_SERVER['SENDGRID_KEY'];
        $this->sg = new SendGrid($apiKey);
    }

    public function browse()
    {
        $results = [];
        $query_params = json_decode('{"generations": "legacy,dynamic"}');
        try {
            $response = $this->sg->client->templates()->get(null, $query_params);
            $results['status_code'] = $response->statusCode();
            $results['message'] = $response->body();
        } catch (Exception $e) {
            $results['status_code'] = 500;
            $results['message'] = json_encode($e->getMessage());
        }

        return $results;
    }

    public function read($template_id)
    {
        $results = [];
        try {
            $response = $this->sg->client->templates()->_($template_id)->get();
            $results['status_code'] = $response->statusCode();
            $results['message'] = $response->body();
        } catch (Exception $e) {
            $results['status_code'] = 500;
            $results['message'] = json_encode($e->getMessage());
        }

        return $results;
    }

    public function edit($template_id, $req_body)
    {
        $results = [];
        try {
            $response = $this->sg->client->templates()->_($template_id)->patch($req_body);
            $results['status_code'] = $response->statusCode();
            $results['message'] = $response->body();
        } catch (Exception $e) {
            $results['status_code'] = 500;
            $results['message'] = json_encode($e->getMessage());
        }

        return $results;
    }

    public function add($req_body)
    {
        $results = [];
        try {
            $response = $this->sg->client->templates()->post($req_body);
            $results['status_code'] = $response->statusCode();
            $results['message'] = $response->body();
        } catch (Exception $e) {
            $results['status_code'] = 500;
            $results['message'] = json_encode($e->getMessage());
        }

        return $results;
    }

    public function delete($template_id)
    {
        $results = [];
        try {
            $response = $this->sg->client->templates()->_($template_id)->delete();
            $results['status_code'] = $response->statusCode();
            $results['message'] = $response->body();
        } catch (Exception $e) {
            $results['status_code'] = 500;
            $results['message'] = json_encode($e->getMessage());
        }

        return $results;
    }
}
