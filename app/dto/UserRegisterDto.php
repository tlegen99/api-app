<?php

namespace app\dto;

class UserRegisterDto
{
    public ?string $username = null;
    public ?string $password = null;
    public ?string $password_confirm = null;

    public function __construct(array $data)
    {
        $this->username = $data['username'];
        $this->password = $data['password'];
        $this->password_confirm = $data['password_confirm'];
    }
}