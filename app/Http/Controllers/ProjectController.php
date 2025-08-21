<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $query = request('q');
        $projects = Project::query();
        if ($query) {
            $projects->where('name', 'like', "%{$query}%");
        }
        $projects = $projects->orderByDesc('created_at')->paginate(5)->withQueryString();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        if (request()->ajax()) {
            $project = null;
            return view('projects._form', compact('project'))->render();
        }
        abort(404);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:projects',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                $project = null;
                /** @var \Illuminate\View\View $view */
                $view = view('projects._form', compact('project'));
                $html = $view->withErrors($e->validator)->render();
                return response()->json(['html' => $html]);
            }
            throw $e;
        }

        Project::create($request->only('name'));
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        if (request()->ajax()) {
            return view('projects._show', compact('project'))->render();
        }
        abort(404);
    }

    public function edit(Project $project)
    {
        if (request()->ajax()) {
            return view('projects._form', compact('project'))->render();
        }
        abort(404);
    }

    public function update(Request $request, Project $project)
    {
        try {
            $validated = $request->validate([
                'name' => "required|string|max:255|unique:projects,name,{$project->id}",
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                /** @var \Illuminate\View\View $view */
                $view = view('projects._form', compact('project'));
                $html = $view->withErrors($e->validator)->render();
                return response()->json(['html' => $html]);
            }
            throw $e;
        }
        $project->update($request->only('name'));
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
