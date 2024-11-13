<?php

namespace App\Controller;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Entity\Car;
use App\Repository\CarRepository;
use App\Service\CarDtoService;
use App\Service\PaginationDtoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\RequestBody;
use ApiPlatform\OpenApi\Model\Response;
use OpenApi\Attributes as OA;

class CarController extends AbstractController
{
    public function __construct(
        private CarRepository        $carRepository,
        private CarDtoService        $carDtoService,
        private PaginationDtoService $paginatorService
    )
    {
    }

    #[Route('/api/v1/cars', name: 'api.cars', methods: ['GET'])]
    #[OA\Get(
        path: "/api/v1/cars",
        summary: "Получить список автомобилей",
        description: "Возвращает список автомобилей с данными о бренде, цене и фото.",
        parameters: [
            new OA\Parameter(
                name: "page",
                in: "query",
                description: "Номер страницы для пагинации",
                required: false,
                schema: new OA\Schema(type: "integer", default: 1)
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Список автомобилей",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(
                                type: "object",
                                properties: [
                                    new OA\Property(property: "id", type: "integer", example: 1),
                                    new OA\Property(property: "price", type: "number", format: "float", example: 3621095),
                                    new OA\Property(property: "photo", type: "string", example: "https://placehold.co/600x400.png"),
                                    new OA\Property(
                                        property: "brand",
                                        type: "object",
                                        properties: [
                                            new OA\Property(property: "id", type: "integer", example: 4),
                                            new OA\Property(property: "name", type: "string", example: "Mercedes-Benz")
                                        ]
                                    )
                                ]
                            )
                        ),
                        new OA\Property(
                            property: "pagination",
                            type: "object",
                            properties: [
                                new OA\Property(property: "currentPage", type: "integer", example: 1),
                                new OA\Property(property: "totalPages", type: "integer", example: 2),
                                new OA\Property(property: "perPage", type: "integer", example: 10),
                                new OA\Property(property: "total", type: "integer", example: 20)
                            ]
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 400,
                description: "Некорректный запрос",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "type", type: "string", example: "https://tools.ietf.org/html/rfc2616#section-10"),
                        new OA\Property(property: "title", type: "string", example: "An error occurred"),
                        new OA\Property(property: "status", type: "integer", example: 400),
                        new OA\Property(property: "detail", type: "string", example: "Bad Request")
                    ]
                )
            )
        ]
    )]
    public function getCars(Request $request): JsonResponse
    {
        $page = $request->query->getInt('page');

        $pagination = $this->carRepository->getCarsListWithPagination($page);
        $carsDTO = array_map(function ($car) {
            return $this->carDtoService->createCarDto($car);
        }, $pagination->getItems());

        $paginationDTO = $this->paginatorService->createPaginationDTO($pagination);

        return $this->json([
            'data' => $carsDTO,
            'pagination' => $paginationDTO,
        ]);
    }

    #[Route('/api/v1/cars/{id}', name: 'api.car', methods: ['GET'])]
    #[OA\Get(
        path: "/api/v1/cars/{id}",
        summary: "Получить данные автомобиля по ID",
        description: "Возвращает данные конкретного автомобиля, включая информацию о бренде и модели.",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                description: "Идентификатор автомобиля",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Данные автомобиля",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(
                            property: "data",
                            type: "object",
                            properties: [
                                new OA\Property(property: "id", type: "integer", example: 1),
                                new OA\Property(property: "price", type: "number", format: "float", example: 3621095),
                                new OA\Property(property: "photo", type: "string", example: "https://placehold.co/600x400.png"),
                                new OA\Property(
                                    property: "brand",
                                    type: "object",
                                    properties: [
                                        new OA\Property(property: "id", type: "integer", example: 4),
                                        new OA\Property(property: "name", type: "string", example: "Mercedes-Benz")
                                    ]
                                ),
                                new OA\Property(
                                    property: "model",
                                    type: "object",
                                    properties: [
                                        new OA\Property(property: "id", type: "integer", example: 2),
                                        new OA\Property(property: "name", type: "string", example: "GLS")
                                    ]
                                )
                            ]
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: "Автомобиль не найден",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "type", type: "string", example: "https://tools.ietf.org/html/rfc2616#section-10"),
                        new OA\Property(property: "title", type: "string", example: "An error occurred"),
                        new OA\Property(property: "status", type: "integer", example: 404),
                        new OA\Property(property: "detail", type: "string", example: "Not Found")
                    ]
                )
            )
        ]
    )]
    public function getCar(Car $car): JsonResponse
    {
        $carDto = $this->carDtoService->createCarWithModelDto($car);
        return $this->json([
            'data' => $carDto,
        ]);
    }
}
