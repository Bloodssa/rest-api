<?php

namespace App\Enums;

enum TaskStatusType: string
{
    case TODO = "todo";
    case IN_PROGRESS = "in-progress";
    case COMPLETED = "completed";

    public function label(): string
    {
        return ucfirst($this->value);
    }
}
