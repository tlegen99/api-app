<?php

namespace app\dto;

class AuthRegisterDto
{
    public function __construct(
        public ?string $username = null,
        public ?string $first_name = null,
        public ?string $last_name = null,
        public ?string $password = null,
        public ?string $password_confirm = null,
        public ?string $email = null,
        public ?string $phone = null,
    ) {}
}