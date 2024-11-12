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
