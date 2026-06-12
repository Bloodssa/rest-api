<?php

namespace App\Repositories\Task;

use App\Models\Projects;
use App\Models\TaskNotes;
use App\Models\Tasks;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    public function getTasks(int $id): Collection;

    public function getProjectTask(Projects $project): Collection;

    public function findTask(int $id, int $userId): Tasks;

    /**
     * @param array<string,mixed> $attributes
     * @param array<int> $tagsId
     */
    public function create(array $attributes, array $tagsId): Tasks;

    /**
     * @param array<string,mixed> $attributes
     */
    public function update(Tasks $task, array $attributes): Tasks;

    public function delete(Tasks $task): bool;

    /**
     * @param array<string,mixed> $attributes
     */
    public function createNote(Tasks $task, array $attributes): TaskNotes;

    public function findNote(Tasks $task, int $noteId): TaskNotes;

    /**
     * @param array<string,mixed> $attributes
     */
    public function updateNote(TaskNotes $note, array $attributes): TaskNotes;

    public function deleteNote(TaskNotes $note): bool;
}
