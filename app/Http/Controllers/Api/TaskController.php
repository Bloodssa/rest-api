<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskNotes\ValidateTaskNoteRequest;
use App\Http\Requests\Tasks\StoreTaskRequest;
use App\Http\Requests\Tasks\UpdateTaskRequest;
use App\Http\Resources\TaskNoteResource;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function __construct(private readonly TaskService $taskService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        return TaskResource::collection($this->taskService->getUserTasks($request->user()->id));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        return (new TaskResource($this->taskService->createProjectTask($request->validated(), $request->user()->id)))
            ->additional(["message" => "Task Added Successfully"])
            ->toResponse($request)
            ->setStatusCode(201);
    }
  
    /**
     * Display the specified resource.
     */
    public function show(string $task): TaskResource
    {
        return new TaskResource($this->taskService->show((int) $task));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, string $task): TaskResource
    {
        return new TaskResource($this->taskService->update($request->validated(), (int) $task, $request->user()->id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $task): Response
    {
        $this->taskService->delete((int) $task, $request->user()->id);

        return response()->noContent();
    }

    public function storeNote(ValidateTaskNoteRequest $request, string $task): JsonResponse
    {
        return (new TaskNoteResource($this->taskService->createTaskNote($request->validated(), (int) $task, $request->user()->id)))
            ->additional(["message" => "Note Added Successfully"])
            ->toResponse($request)
            ->setStatusCode(201);
    }

    public function updateNote(ValidateTaskNoteRequest $request, string $task, string $note)
    {
        return new TaskNoteResource($this->taskService->updateTaskNote(
            $request->validated(),
            (int) $task,
            (int) $note,
            $request->user()->id
        ));
    }

    public function destroyNote(Request $request, string $task, string $note): Response
    {
        $this->taskService->deleteTaskNote((int) $task, (int) $note, $request->user()->id);

        return response()->noContent();
    }
}
