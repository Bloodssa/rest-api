<?php

namespace App\Repositories\Task;

use App\Models\Tasks;
use App\Models\Projects;
use App\Models\TaskNotes;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

class TaskRepository implements TaskRepositoryInterface
{
    public function getTasks(int $id): Collection
    {
        return $this->queryByUser($id)->with("tags")->get();
    }

    public function getProjectTask(Projects $project): Collection
    {
        return $project->tasks()->get();
    }

    public function findTask(int $id, int $userId): Tasks
    {
        return $this->queryByUser($userId)->with("tags")->findOrFail($id);
    }

    private function queryByUser(int $userId): Builder
    {
        return Tasks::query()
            ->whereHas('project', fn ($q) => $q->where("user_id", $userId));
    }

    /**
     * @param array<string,mixed> $attributes
     * @param array<int> $tagsId
     */
    public function create(array $attributes, array $tagsId = []): Tasks
    {
        $task = Tasks::create($attributes);
        
        // attch in pivot table
        if(!empty($tagsId)) {
            $task->tags()->sync($tagsId);

            $task->setRelation("tags", $task->tags()->get());
        }else {
            $task->setRelation("tags", collect());
        }

        return $task;
    }

    /**
     * @param array<string,mixed> $attributes
     */
    public function update(Tasks $task, array $attributes): Tasks
    {
        $task->update($attributes);

        return $task->refresh();
    }

    public function delete(Tasks $task): bool
    {
        return (bool) $task->delete();
    }

    /**
     * @param array<string,mixed> $attributes
     */
    public function createNote(Tasks $task, array $attributes): TaskNotes
    {
        return $task->notes()->create($attributes);
    }

    public function findNote(Tasks $task, int $noteId): TaskNotes
    {
        return $task->notes()->findOrFail($noteId);
    }

    /**
     * @param array<string,mixed> $attributes
     */
    public function updateNote(TaskNotes $note, array $attributes): TaskNotes
    {
        $note->update($attributes);

        return $note->refresh();
    }

    public function deleteNote(TaskNotes $note): bool
    {
        return $note->delete();
    }
}
