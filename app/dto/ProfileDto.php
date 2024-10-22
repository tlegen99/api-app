<?php

namespace app\dto;

class ProfileDto
{
    public function __construct(
        public int $id,
        public string $username,
        public ?string $first_name,
        public ?string $last_name,
        public ?string $email,
        public ?string $phone,
        public string $created_at,
    ) {
        $this->created_at = date('Y-m-d H:i:s', (int)$created_at);
    }
}