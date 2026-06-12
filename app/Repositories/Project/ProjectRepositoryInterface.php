<?php

namespace App\Repositories\Project;

use App\Models\Projects;
use Illuminate\Database\Eloquent\Collection;

interface ProjectRepositoryInterface
{
    public function getUserProjects(int $id): Collection;

    /**
     * @param array<string,mixed> $attributes
     */
    public function create(array $attributes): Projects;

    public function findProject(int $id, int $userId): Projects;

    /**
     * @param Projects $project
     * @param array<string,mixed> $attributes
     */
    public function update(Projects $project, array $attributes): Projects;

    /**
     * @param Projects $project
     */
    public function delete(Projects $project): bool;
}