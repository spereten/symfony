<?php

namespace App\DTO;

class ServiceManagerDto
{
    public function __construct(
        public ?int $id = null,
        public ?string $slug = null,
        public ?string $title = null,
    ){}

    public static function fromArray($attribute){
        return new self(...$attribute);
    }
}