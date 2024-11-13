<?php

namespace App\Controller;

use App\Repository\CarRepository;
use App\Repository\CreditProgramRepository;
use App\Request\ApplicationRequest;
use App\Service\ApplicationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

use OpenApi\Attributes as OA;

class ApplicationController extends AbstractController
{
    public function __construct(
        private ApplicationService      $applicationService,
        private CarRepository           $carRepository,
        private CreditProgramRepository $creditProgramRepository
    )
    {
    }

    #[Route('/api/v1/request', name: 'app_application', methods: ['POST'])]
    #[OA\Post(
        path: "/api/v1/request",
        summary: "Создание заявки на кредит",
        description: "Метод для создания заявки на кредит по выбранному автомобилю и кредитной программе.",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                type: "object",
                properties: [
                    new OA\Property(property: "carId", type: "integer", example: 1),
                    new OA\Property(property: "creditProgramId", type: "integer", example: 1),
                    new OA\Property(property: "initialPayment", type: "number", format: "float", example: 200000),
                    new OA\Property(property: "loanTerm", type: "integer", example: 36)
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Заявка успешно создана",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true)
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
    public function create(#[MapRequestPayload(
        validationFailedStatusCode: Response::HTTP_BAD_REQUEST,
    )] ApplicationRequest $request): JsonResponse
    {
        $car = $this->carRepository->find($request->carId);
        $creditProgram = $this->creditProgramRepository->find($request->creditProgramId);
        $application = $this->applicationService->createApplication($request, $car, $creditProgram);

        return $this->json(['success' => true]);
    }
}
