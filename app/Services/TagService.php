<?php

namespace App\Services;

use App\Models\Tag;
use App\Repositories\Tags\TagRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TagService
{

    public function __construct(private readonly TagRepositoryInterface $tagRepository) {}

    public function userTags(int $userId): Collection
    {
        return $this->tagRepository->getUserTags($userId);
    }

    /**
     * @param array<string,mixed> $attributes
     */
    public function createUserTag(array $attributes, int $userId): Tag
    {
        $attributes['user_id'] = $userId;

        return $this->tagRepository->create($attributes);
    }

    /**
     * @param array<string,mixed> $attributes
     */
    public function update(array $attributes, int $id, int $userId): Tag
    {
        $tag = $this->tagRepository->findTag($id, $userId);
        $this->tagRepository->update($tag, $attributes);

        return $tag->refresh();
    }

    public function delete(int $id, int $userId): bool
    {
        $tag = $this->tagRepository->findTag($id, $userId);

        return $this->tagRepository->delete($tag);
    }
}
