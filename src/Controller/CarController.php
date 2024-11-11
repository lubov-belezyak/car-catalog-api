<?php

namespace App\Controller;

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
}
