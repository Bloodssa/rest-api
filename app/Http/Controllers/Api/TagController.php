<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\ValidateTagRequest;
use App\Http\Resources\TagResource;
use App\Services\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class TagController extends Controller
{
    public function __construct(private readonly TagService $tagService) {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        return TagResource::collection($this->tagService->userTags($request->user()->id));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ValidateTagRequest $request): JsonResponse
    {
        return (new TagResource($this->tagService->createUserTag($request->validated(), $request->user()->id)))
            ->additional(["message" => "Tag Created Successfully"])
            ->toResponse($request)
            ->setStatusCode(201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ValidateTagRequest $request, string $task): TagResource
    {
        return new TagResource($this->tagService->update($request->validated(), (int) $task, $request->user()->id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $task): Response
    {
        $this->tagService->delete((int) $task, $request->user()->id);

        return response()->noContent();
    }
}
