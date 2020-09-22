<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function index(){
        $projects = Project::get();
        return view('tenant.projects.index', compact('projects'));
    }
}
