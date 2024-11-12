<?php

namespace App\Dto;

/**
 * @OA\Schema(
 *     schema="PaginationDTO",
 *     type="object",
 *     @OA\Property(property="totalItems", type="integer"),
 *     @OA\Property(property="totalPages", type="integer"),
 *     @OA\Property(property="currentPage", type="integer"),
 *     @OA\Property(property="itemsPerPage", type="integer")
 * )
 */
class PaginationDto
{
    private int $currentPage;
    private int $totalPages;
    private int $perPage;
    private int $total;

    public function __construct(int $currentPage, int $totalPages, int $perPage, int $total){
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