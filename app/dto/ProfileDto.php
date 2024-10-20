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
        public string $create_at,
    ) {
        $this->create_at = date('Y-m-d H:i:s', (int)$create_at);
    }
}