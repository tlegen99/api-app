<?php

namespace app\dto;

class AuthLoginDto
{
    public function __construct(
        public ?string $username = null,
        public ?string $password = null,
    ) {}
}