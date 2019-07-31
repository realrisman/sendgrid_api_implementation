<?php

namespace App\Controller;

use App\Service\TemplateService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class TemplateController
{
    private $templateService;

    public function __construct(TemplateService $templateService)
    {
        $this->templateService = $templateService;
    }

    /**
     * @Route("/templates", methods={"GET"}, name="browse_template")
     */
    public function browse(): JsonResponse
    {
        $results = $this->templateService->get();

        return new JsonResponse(json_decode($results['message']), $results['status_code']);
    }
}
