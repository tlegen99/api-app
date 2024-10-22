<?php

namespace app\dto;

class TaskCreateDto
{
    public function __construct(
        public int $user_id,
        public ?int $author_id,
        public string $title,
        public ?string $body,
    )
    {}
}