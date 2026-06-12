<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Projects\StoreProjectRequest;
use App\Http\Requests\Projects\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    public function __construct(private readonly ProjectService $projectService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        return ProjectResource::collection($this->projectService->userProjects($request->user()->id));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request): JsonResponse
    {
        return (new ProjectResource($this->projectService->create($request->validated(), $request->user()->id)))
            ->additional(["message" => "Project Created Successfully"])
            ->toResponse($request)
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $project): ProjectResource
    {
        return new ProjectResource($this->projectService->show((int) $project, $request->user()->id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, string $project): ProjectResource
    {
        return new ProjectResource($this->projectService->update($request->validated(), (int) $project, $request->user()->id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $project): Response
    {
        $this->projectService->delete((int) $project, $request->user()->id);

        return response()->noContent();
    }
}
