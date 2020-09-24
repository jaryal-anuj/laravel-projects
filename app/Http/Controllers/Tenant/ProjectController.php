<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function index(Request $request){

        // $projects = cache()->remember('projects', 10, function () {
        //     return Project::get();
        // });


        // $projects = cache()->remember($request->tenant()->id.'.projects', 10, function () {
        //     return Project::get();
        // });

        $projects = Project::get();

        return view('tenant.projects.index', compact('projects'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        Project::create([
            'name' => $request->name
        ]);

       // cache()->forget('projects');

        return back();
    }
}
