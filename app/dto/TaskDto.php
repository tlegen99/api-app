<?php

namespace app\dto;

use app\models\Task;

class TaskDto
{
    public function __construct(
        public int $id,
        public string $title,
        public ?string $body,
        public string $created_at,
    )
    {
        $this->created_at = date('Y-m-d H:i:s', (int)$created_at);
    }
}