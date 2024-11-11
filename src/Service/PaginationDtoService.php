<?php

namespace App\Service;

use App\Dto\PaginationDto;
use Knp\Component\Pager\Pagination\PaginationInterface;

class PaginationDtoService
{
    public function createPaginationDto(PaginationInterface $pagination): PaginationDto {

        return new PaginationDto(
            $pagination->getCurrentPageNumber(),
            $pagination->getPageCount(),
            $pagination->getItemNumberPerPage(),
            $pagination->getTotalItemCount(),
        );
    }
}