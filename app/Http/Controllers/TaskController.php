<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::filter(request(['name', 'status', 'priority']))->with('user')->paginate(10);

        return new TaskCollection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        Gate::authorize('create', Task::class);

        $validated = $request->validated();

        $task = Task::create($validated);

        return response()->json([
            'message' => 'Task created successfully',
            'data' => new TaskResource($task),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load('user', 'project');

        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        Gate::authorize('update', $task);

        $validated = $request->validated();

        $task->update($validated);

        return response()->json([
            'message' => 'Task updated successfully',
            'data' => new TaskResource($task),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        Gate::authorize('delete', $task);

        $task->delete();

        return response()->json([
            'status' => true,
            'message' => 'Task deleted successfully',
        ]);
    }

    public function myTask()
    {
        $user_id = Auth::id();

        $tasks = Task::filter(request(['name', 'status', 'priority']))->where('user_id', $user_id)->paginate(10);

        if ($tasks->isEmpty()) {
            return response()->json([
                'message' => 'No task found',
            ], 404);
        }

        return new TaskCollection($tasks);
    }
}
