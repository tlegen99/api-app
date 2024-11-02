<?php

namespace app\dto;

class TaskCreateDto
{
    public int $user_id;
    public ?int $author_id;
    public string $title;
    public ?string $body;

    public function __construct(array $data, ?int $author_id = null)
    {
        $this->user_id   = $data['user_id'] ?? '';
        $this->author_id = $author_id;
        $this->title     = $data['title'] ?? '';
        $this->body      = $data['body'] ?? null;
    }
}