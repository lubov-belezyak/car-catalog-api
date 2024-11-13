<?php

namespace App\Dto;
use OpenApi\Attributes as OA;
#[OA\Schema(
    schema: "PaginationDto",
    type: "object",
    properties: [
        new OA\Property(property: "currentPage", type: "integer", example: 1),
        new OA\Property(property: "totalPages", type: "integer", example: 2),
        new OA\Property(property: "perPage", type: "integer", example: 10),
        new OA\Property(property: "total", type: "integer", example: 20)
    ]
)]
class PaginationDto
{
    private int $currentPage;
    private int $totalPages;
    private int $perPage;
    private int $total;

    public function __construct(int $currentPage, int $totalPages, int $perPage, int $total)
    {
        $this->currentPage = $currentPage;
        $this->totalPages = $totalPages;
        $this->perPage = $perPage;
        $this->total = $total;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getTotal(): int
    {
        return $this->total;
    }
}