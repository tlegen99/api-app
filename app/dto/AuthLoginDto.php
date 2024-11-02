<?php

namespace app\dto;

class AuthLoginDto
{
    public string $username;
    public string $password;

    public function __construct(array $data) {
        $this->username = $data['username'] ?? '';
        $this->password = $data['password'] ?? '';
    }
}