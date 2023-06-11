<?php

namespace App\DTO;

class ProfileManagerDto
{

    public function __construct( 
        public ?int $id = null,
        public ?string $slug = null,
        public ?string $first_name = null,
        public ?string $last_name = null,
        public ?string $surname = null,
        public ?string $email = null,
        public ?int $phone = null,
        public ?int $experience = null,
    ){}
}