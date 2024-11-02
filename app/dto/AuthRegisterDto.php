<?php

namespace app\dto;

class AuthRegisterDto
{
    public ?string $username = null;
    public ?string $first_name = null;
    public ?string $last_name = null;
    public ?string $password = null;
    public ?string $password_confirm = null;
    public ?string $email = null;
    public ?string $phone = null;

    public function __construct(array $data)
    {
        $this->username         = $data['username'] ?? '';
        $this->first_name       = $data['first_name'] ?? '';
        $this->last_name        = $data['last_name'] ?? '';
        $this->password         = $data['password'] ?? '';
        $this->password_confirm = $data['password_confirm'] ?? '';
        $this->email            = $data['email'] ?? '';
        $this->phone            = $data['phone'] ?? '';
    }
}