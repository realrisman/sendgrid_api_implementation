<?php

namespace App\Controller;

use App\Service\MailService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class MailController
{
    private $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * @Route("/mail/send", methods={"POST"}, name="send_mail")
     */
    public function send(Request $request): JsonResponse
    {
        $req_body = json_decode($request->getContent(), true);
        $results = $this->mailService->send($req_body);

        return new JsonResponse(json_decode($results['message']), $results['status_code']);
    }

    /**
     * @Route("/mail/send/queue", methods={"POST"}, name="send_mail_to_queue")
     */
    public function sendToQueue(Request $request): JsonResponse
    {
        $req_body = $request->getContent();
        $results = $this->mailService->sendToQueue($req_body);

        return new JsonResponse($results, $results['status_code']);
    }
}
