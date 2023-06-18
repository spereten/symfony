<?php

namespace App\DTO;

class ServiceManagerDto
{
    public function __construct(
        public ?int $id = null,
        public ?string $slug = null,
        public ?string $name = null,
        public ?int $parent = null,
    ){}

    public static function fromArray($attribute): ServiceManagerDto
    {
        return new self(...$attribute);
    }
}