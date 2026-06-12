<?php

namespace App\Services;

use App\Models\Projects;
use App\Models\TaskNotes;
use App\Models\Tasks;
use App\Repositories\Project\ProjectRepositoryInterface;
use App\Repositories\Task\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository,
        private readonly ProjectRepositoryInterface $projectRepository
    ) {}

    public function getUserTasks(int $userId): Collection
    {
        return $this->taskRepository->getTasks($userId);
    }

    public function getProject(int $id, int $userId): Projects
    {
        return $this->projectRepository->findProject($id, $userId);
    }

    /**
     * @param array<string,mixed> $attributes
     */
    public function createProjectTask(array $attributes, int $userId): Tasks
    {
        $this->projectRepository->findProject($attributes['project_id'], $userId);

        $tagsId = $attributes['tags'] ?? []; // extract tag id
        unset($attributes['tags']);  // remove in the attributes to create a task

        return $this->taskRepository->create($attributes, $tagsId);
    }

    public function show(int $id): Tasks
    {
        return $this->taskRepository->findTask($id, auth("api")->user()->id);
    }

    /**
     * @param array<string,mixed> $attributes
     */
    public function update(array $attributes, int $id, int $userId): Tasks
    {
        $task = $this->taskRepository->findTask($id, $userId);

        $tagsId = $attributes["tags"] ?? [];
        unset($attributes["tags"]);

        $this->taskRepository->update($task, $attributes);

        $task->tags()->sync($tagsId); // if there is no tag keys then empty array is passed to remove tags

        return $task->refresh();
    }

    public function delete(int $id, int $userId): bool
    {
        $task = $this->taskRepository->findTask($id, $userId);

        return $this->taskRepository->delete($task);
    }

    /**
     * @param array<string,mixed> $attributes
     */
    public function createTaskNote(array $attributes, int $id, int $userId): TaskNotes
    {
        $task = $this->taskRepository->findTask($id, $userId);

        return $this->taskRepository->createNote($task, $attributes);
    }

    /**
     * @param array<string,mixed> $attributes
     */
    public function updateTaskNote(array $attributes, int $taskId, int $noteId, int $userId): TaskNotes
    {
        $note = $this->findTaskNoteForUser($taskId, $noteId, $userId);

        return $this->taskRepository->updateNote($note, $attributes);
    }

    public function deleteTaskNote(int $taskId, int $noteId, int $userId): bool
    {
        $note = $this->findTaskNoteForUser($taskId, $noteId, $userId);

        return $this->taskRepository->deleteNote($note);
    }

    // helper fn
    private function findTaskNoteForUser(int $taskId, int $noteId, int $userId): TaskNotes
    {
        $task = $this->taskRepository->findTask($taskId, $userId);

        return  $this->taskRepository->findNote($task, $noteId);
    }
}
