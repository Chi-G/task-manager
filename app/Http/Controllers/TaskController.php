<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::all();
        $selectedProjectId = $request->input('project_id');
        $search = $request->input('search');

        $tasks = Task::query()
            ->when($selectedProjectId, function ($query) use ($selectedProjectId) {
                return $query->where('project_id', $selectedProjectId);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%$search%");
            })
            ->orderBy('priority')
            ->paginate(5)
            ->withQueryString();

        return view('tasks.index', compact('tasks', 'projects', 'selectedProjectId'));
    }

    public function create()
    {
        $projects = Project::all();
        if (request()->ajax()) {
            $task = null;
            return view('tasks._form', compact('task', 'projects'))->render();
        }
        abort(404);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'project_id' => 'required|exists:projects,id',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                $task = null;
                $projects = Project::all();
                $html = view('tasks._form', compact('task', 'projects'))
                    ->withErrors($e->validator)
                    ->render();
                return response()->json(['html' => $html]);
            }
            throw $e;
        }
        // setting priority
        $maxPriority = Task::where('project_id', $validated['project_id'])->max('priority') ?? 0;
        $validated['priority'] = $maxPriority + 1;
        Task::create($validated);
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        $projects = Project::all();
        if (request()->ajax()) {
            return view('tasks._form', compact('task', 'projects'))->render();
        }
        abort(404);
    }

    public function show(Task $task)
    {
        if (request()->ajax()) {
            return view('tasks._show', compact('task'))->render();
        }
        abort(404);
    }


    public function update(Request $request, Task $task)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'project_id' => 'required|exists:projects,id',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                $projects = Project::all();
                $html = view('tasks._form', compact('task', 'projects'))
                    ->withErrors($e->validator)
                    ->render();
                return response()->json(['html' => $html]);
            }
            throw $e;
        }
        // reset priority if project changes
        if ($task->project_id != $validated['project_id']) {
            $maxPriority = Task::where('project_id', $validated['project_id'])->max('priority') ?? 0;
            $validated['priority'] = $maxPriority + 1;
        }
        $task->update($validated);
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        // reorder priorities after delete
        $this->reorderPriorities($task->project_id);

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    /**
     * Reorder tasks based on drag-and-drop order.
     */
    public function reorder(Request $request)
    {
        $taskIds = $request->input('task_ids', []);
        foreach ($taskIds as $index => $taskId) {
            Task::where('id', $taskId)->update(['priority' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Helper to reorder priorities in a project after delete/edit.
     */
    private function reorderPriorities($projectId)
    {
        $tasks = Task::where('project_id', $projectId)->orderBy('priority')->get();
        foreach ($tasks as $index => $task) {
            $task->update(['priority' => $index + 1]);
        }
    }
}
