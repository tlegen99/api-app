<?php

namespace app\dto;

class AuthLoginDto
{
    public ?string $username = null;
    public ?string $password = null;

    public function __construct(array $data) {
        $this->username = $data['username'] ?? '';
        $this->password = $data['password'] ?? '';
    }
}