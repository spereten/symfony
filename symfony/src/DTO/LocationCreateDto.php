<?php

namespace App\DTO;

class LocationCreateDto
{
    public function __construct(
        public string $city,
        public string $country,
        public ?int $parent_id = null
    ){}
}