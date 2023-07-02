<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Project;

class AuditController extends Controller
{
    public function index()
    {

        $users = User::where('id', '!=', auth()->user()->id)->get();


        $query = Project::where('user_id', auth()->user()->id); // Filter projects by user ID

        $projects = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('pages.user-management', [
            'users' => $users,
            'projects' => $projects
        ]);
    }


    public function show(int $user, Request $request)
    {


        $query = Project::where('user_id', $user); // Filter projects by user ID


        $projects = $query->orderBy('created_at', 'desc')->paginate(10);



        return view('pages.projects', ['projects' => $projects, 'readOnly' => 1]);
    }
}
