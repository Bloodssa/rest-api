<?php

namespace App\Repositories\Tags;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

class TagRepository implements TagRepositoryInterface
{

    public function getUserTags(int $userId): Collection
    {
        return Tag::whereUserId($userId)->get();
    }

    public function findTag(int $id, int $userId): Tag
    {
        return Tag::whereUserId($userId)->findOrFail($id);
    }

    /**
     * @param array<string,mixed> $attributes
     */
    public function create(array $attributes): Tag
    {
        return Tag::query()->create($attributes);
    }

    /**
     * @param array<string,mixed> $attributes
     */
    public function update(Tag $tag, array $attributes): Tag
    {
        $tag->update($attributes);

        return $tag->refresh();
    }

    public function delete(Tag $tag): bool
    {
        return (bool) $tag->delete();
    }
}
