<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['user_id', 'name'])]
class Tag extends Model
{
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Tasks::class, "task_tags", "task_id", "tag_id");
    }
}
