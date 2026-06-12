<?php

namespace App\Repositories\Tags;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

interface TagRepositoryInterface
{
    public function getUserTags(int $userId): Collection;

    public function findTag(int $id, int $userId): Tag;

    /**
     * @param array<string,mixed> $attributes
     */
    public function create(array $attributes): Tag;

    /**
     * @param array<string,mixed> $attributes
     */
    public function update(Tag $tag, array $attributes): Tag;

    public function delete(Tag $tag): bool;
}
