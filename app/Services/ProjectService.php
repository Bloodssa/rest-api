<?php

namespace App\Services;

use App\Models\Projects;
use App\Repositories\Project\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProjectService
{
    public function __construct(private readonly ProjectRepositoryInterface $projectRepository) {}
    
    /**
     * @return Collection of projects of the auth user
     */
    public function userProjects(int $userId): Collection
    {
        return $this->projectRepository->getUserProjects($userId);
    }

    /**
     * @param array<string,mixed> $attributes
     */
    public function create(array $attributes, int $userId): Projects
    {
        $attributes["user_id"] = $userId;

        return $this->projectRepository->create($attributes);
    }

    /**
     * @param int $id of the project
     */
    public function show(int $id, int $userId): Projects
    {
        return $this->projectRepository->findProject($id, $userId);
    }

    /**
     * @param array<string,mixed> $attributes
     */
    public function update(array $attributes, int $id, int $userId): Projects
    {
        $project = $this->projectRepository->findProject($id, $userId);
        $this->projectRepository->update($project, $attributes);

        return $project->refresh();
    }

    public function delete(int $id, int $userId): bool
    {
        $project = $this->projectRepository->findProject($id, $userId);

        return $this->projectRepository->delete($project);
    }
}
