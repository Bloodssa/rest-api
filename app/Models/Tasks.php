<?php

namespace App\Models;

use App\Enums\TaskPriorityType;
use App\Enums\TaskStatusType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['project_id', 'title', 'description', 'status', 'priority', 'due_date'])]
class Tasks extends Model
{
    protected $casts = [
        "status" => TaskStatusType::class,
        "priority" => TaskPriorityType::class,
        "due_date" => "date"
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Projects::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(TaskNotes::class, "task_id");
    }

    // pivot
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class,  "task_tags", "task_id", "tag_id");
    }
}
