<?php

namespace App\Http\Controllers\Tenant;

use App\Models\File;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProjectFileController extends Controller
{

    public function show(Project $project, File $file){
       // return Storage::disk('tenant')->download($file->path, $file->name);
    }
    public function store(Project $project, Request $request)
    {
        $upload = $request->file('file');
       // dd($upload);
        if ($path = Storage::disk('tenant')->putFile('/', $upload)) {
            $file = File::make([
                'name' => $upload->getClientOriginalName(),
                'path' => $path
            ]);

            $project->files()->save($file);
        }

        return back();
    }
}
