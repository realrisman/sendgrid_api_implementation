<?php

namespace App\Controller;

use App\Service\TemplateService;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/templates/{template_id}", methods={"GET"}, name="read_template_by_id")
     */
    public function read($template_id): JsonResponse
    {
        $results = $this->templateService->read($template_id);

        return new JsonResponse(json_decode($results['message']), $results['status_code']);
    }

    /**
     * @Route("/templates/{template_id}", methods={"PATCH"}, name="edit_template_by_id")
     */
    public function edit($template_id, Request $request): JsonResponse
    {
        $req_body = json_decode($request->getContent(), true);
        $results = $this->templateService->edit($template_id, $req_body);

        return new JsonResponse(json_decode($results['message']), $results['status_code']);
    }

    /**
     * @Route("/templates", methods={"POST"}, name="add_template")
     */
    public function add(Request $request): JsonResponse
    {
        $req_body = json_decode($request->getContent(), true);
        $results = $this->templateService->add($req_body);

        return new JsonResponse(json_decode($results['message']), $results['status_code']);
    }

    /**
     * @Route("/templates/{template_id}", methods={"DELETE"}, name="delete_template_by_id")
     */
    public function delete($template_id): JsonResponse
    {
        $results = $this->templateService->delete($template_id);

        return new JsonResponse(json_decode($results['message']), $results['status_code']);
    }
}
