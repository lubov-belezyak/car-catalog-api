<?php

namespace App\Controller;

use App\Request\CalculateCreditProgramRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

class CreditProgramController extends AbstractController
{
    public function __construct(
    )
    {
    }

    /**
     * @TODO валидация запроса
     * @param CalculateCreditProgramRequest $request
     * @return JsonResponse
     */
    #[Route('/api/v1/credit/calculate', name: 'credit_calculate', methods: ['GET'])]
    public function calculate(#[MapQueryString(
        validationFailedStatusCode: Response::HTTP_BAD_REQUEST,
    )] CalculateCreditProgramRequest $request): JsonResponse
    {
        return $this->json([]);
    }
}
