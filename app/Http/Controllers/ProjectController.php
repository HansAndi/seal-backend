<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Project;
use App\Traits\HasImage;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\ProjectResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ProjectCollection;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

class ProjectController extends Controller
{
    use HasImage;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::filter(request(['name', 'status']))->with('user', 'tasks')->paginate(10);

        // return ProjectResource::collection($projects);
        return new ProjectCollection($projects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        Gate::authorize('create', Project::class);

        $validated = $request->validated();

        $validated['image'] = $this->uploadImage($request, 'image', 'projects');

        // $project = auth()->user()->projects()->create($validated);
        $project = Project::create($validated);

        return response()->json([
            'message' => 'Project created successfully',
            'data' => new ProjectResource($project),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load('tasks.user');

        return new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        Gate::authorize('update', $project);

        $validdated = $request->validated();

        if (Storage::disk('public')->exists($project->image)) {
            Storage::disk('public')->delete($project->image);
        }

        $validate['image'] = $this->uploadImage($request, 'image', 'projects', $project->image);

        $project->update($validate);

        return response()->json([
            'message' => 'Project updated successfully',
            'data' => new ProjectResource($project),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        Gate::authorize('delete', $project);

        if (Storage::disk('public')->exists($project->image)) {
            Storage::disk('public')->delete($project->image);
        }

        $project->delete();

        return response()->json([
            'message' => 'Project deleted successfully',
        ]);
    }
}
