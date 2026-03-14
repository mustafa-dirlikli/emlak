<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::where('is_active', true)
            ->latest()
            ->paginate(12);
        return view('projects.index', compact('projects'));
    }

    public function show(Project $project): View
    {
        if (! $project->is_active) {
            abort(404);
        }
        return view('projects.show', compact('project'));
    }
}
