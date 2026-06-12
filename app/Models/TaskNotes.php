<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['note'])]
class TaskNotes extends Model
{
    public function task(): BelongsTo
    {
        return $this->belongsTo(Tasks::class);
    }
}
