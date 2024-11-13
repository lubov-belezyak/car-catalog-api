<?php

namespace App\Dto;

use OpenApi\Attributes as OA;
#[OA\Schema(
    schema: "BrandDto",
    type: "object",
    properties: [
        new OA\Property(property: "id", type: "integer", example: 4),
        new OA\Property(property: "name", type: "string", example: "Mercedes-Benz")
    ]
)]
class BrandDto
{
    private int $id;
    private string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }
}