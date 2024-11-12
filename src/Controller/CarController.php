<?php

namespace App\Controller;

use App\Entity\Car;
use App\Repository\CarRepository;
use App\Service\CarDtoService;
use App\Service\PaginationDtoService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class CarController extends AbstractController
{
    public function __construct(
        private CarRepository        $carRepository,
        private CarDtoService        $carDtoService,
        private PaginationDtoService $paginatorService
    )
    {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/cars",
     *     summary="Get a list of cars",
     *     tags={"Cars"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number for pagination",
     *         required=false,
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of cars",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/CarDTO")
     *             ),
     *             @OA\Property(
     *                 property="pagination",
     *                 ref="#/components/schemas/PaginationDTO"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="Not Found")
     * )
     */
    #[Route('/api/v1/cars', name: 'api.cars', methods: ['GET'])]
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

    /**
     * @OA\Get(
     *     path="/api/v1/cars/{id}",
     *     summary="Get a car by ID",
     *     tags={"Cars"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the car",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Car details",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/CarDTO"
     *             )
     *         )
     *     ),
     *     @OA\Response(response=404, description="Car not found")
     * )
     */
    #[Route('/api/v1/cars/{id}', name: 'api.car', methods: ['GET'])]
    public function getCar(Car $car): JsonResponse
    {
        $carDto = $this->carDtoService->createCarWithModelDto($car);
        return $this->json([
            'data' => $carDto,
        ]);
    }
}
