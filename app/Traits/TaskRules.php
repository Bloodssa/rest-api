<?php

namespace App\Traits;

use Illuminate\Validation\Rule;
use App\Enums\TaskPriorityType;
use App\Enums\TaskStatusType;

trait TaskRules
{
    protected function baseRules(): array
    {
        $userId = $this->user()?->id ?? auth('api')->user()->id;
        
        return [
            "project_id" => [
                "required", 
                "integer",
                Rule::exists('projects', 'id')->where(fn($q) => $q->where("user_id", $userId)), 
            ],
            "title" => ["required", "string", "max:255"],
            "description" => ["required", "string", "max:2000"],
            "status" => ["required", Rule::enum(TaskStatusType::class)],
            "priority" => ["required", Rule::enum(TaskPriorityType::class)],
            "due_date" => ["required", "date", "after:now"],
            "tags" => ["nullable", "array"],
            "tags.*" => [
                "integer",
                Rule::exists('tags', 'id')->where(fn($q) => $q->where("user_id", $userId)) // ensure the owner of the tag is the auth->user
            ]
        ];
    }
}
