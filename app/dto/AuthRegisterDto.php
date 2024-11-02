<?php

namespace app\dto;

class AuthRegisterDto
{
    public string $username;
    public ?string $first_name;
    public ?string $last_name;
    public string $password;
    public string $password_confirm;
    public ?string $email;
    public ?string $phone;

    public function __construct(array $data)
    {
        $this->username         = $data['username'] ?? '';
        $this->first_name       = $data['first_name'] ?? null;
        $this->last_name        = $data['last_name'] ?? null;
        $this->password         = $data['password'] ?? '';
        $this->password_confirm = $data['password_confirm'] ?? '';
        $this->email            = $data['email'] ?? null;
        $this->phone            = $data['phone'] ?? null;
    }
}