<?php

namespace App\Repositories\Project;

use App\Models\Projects;
use Illuminate\Database\Eloquent\Collection;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function getUserProjects(int $id): Collection
    {
        return Projects::whereUserId($id)->get();
    }

    /**
     * @param array<string,mixed> $attributes
     */
    public function create(array $attributes): Projects
    {
        return Projects::query()->create($attributes);
    }

    public function findProject(int $id, int $userId): Projects
    {
        return Projects::query()
            ->whereUserId($userId)
            ->findOrFail($id);
    }

    /**
     * @param Projects $project
     * @param array<string,mixed> $attributes
     */
    public function update(Projects $project, array $attributes): Projects
    {
        $project->update($attributes);

        return $project->refresh();
    }

    /**
     * @param Projects $project
     */
    public function delete(Projects $project): bool
    {
        return (bool) $project->delete();
    }
}