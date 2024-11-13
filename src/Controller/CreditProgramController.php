<?php

namespace App\Controller;

use App\Request\CalculateCreditProgramRequest;
use App\Service\CreditCalculatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

use OpenApi\Attributes as OA;

class CreditProgramController extends AbstractController
{
    public function __construct(
        private CreditCalculatorService $creditCalculatorService
    )
    {
    }

    /**
     * @param CalculateCreditProgramRequest $request
     * @return JsonResponse
     */
    #[Route('/api/v1/credit/calculate', name: 'credit_calculate', methods: ['GET'])]
    #[OA\Get(
        path: "/api/v1/credit/calculate",
        summary: "Получить кредитную программу",
        description: "Метод для получения кредитной программы платежа по кредиту на основе цены, первоначального взноса и срока кредита.",
        parameters: [
            new OA\Parameter(
                name: "price",
                in: "query",
                description: "Цена автомобиля",
                required: true,
                schema: new OA\Schema(type: "integer", example: 500000)
            ),
            new OA\Parameter(
                name: "initialPayment",
                in: "query",
                description: "Первоначальный взнос",
                required: true,
                schema: new OA\Schema(type: "number", format: "float", example: 100000)
            ),
            new OA\Parameter(
                name: "loanTerm",
                in: "query",
                description: "Срок кредита (в месяцах)",
                required: true,
                schema: new OA\Schema(type: "integer", example: 36)
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Результат расчета",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "id", type: "integer", example: 1),
                        new OA\Property(property: "interestRate", type: "number", format: "float", example: 15),
                        new OA\Property(property: "monthlyPayment", type: "integer", example: 83099),
                        new OA\Property(property: "title", type: "string", example: "Expensive Car")
                    ]
                )
            ),
            new OA\Response(
                response: 400,
                description: "Ошибка валидации",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "type", type: "string", example: "https://symfony.com/errors/validation"),
                        new OA\Property(property: "title", type: "string", example: "Validation Failed"),
                        new OA\Property(property: "status", type: "integer", example: 400),
                        new OA\Property(property: "detail", type: "string", example: "initialPayment: The initial payment cannot exceed the price."),
                        new OA\Property(
                            property: "violations",
                            type: "array",
                            items: new OA\Items(
                                type: "object",
                                properties: [
                                    new OA\Property(property: "propertyPath", type: "string", example: "initialPayment"),
                                    new OA\Property(property: "title", type: "string", example: "The initial payment cannot exceed the price."),
                                    new OA\Property(property: "template", type: "string", example: "The initial payment cannot exceed the price.")
                                ]
                            )
                        )
                    ]
                )
            )
        ]
    )]
    public function calculate(#[MapQueryString(
        validationFailedStatusCode: Response::HTTP_BAD_REQUEST,
    )] CalculateCreditProgramRequest $request): JsonResponse
    {
        $result = $this->creditCalculatorService->getCreditProductDto($request);
        return $this->json($result);
    }
}
