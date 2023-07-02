<?php

namespace App\Http\Controllers;

use App\Models\LoanRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth()->user();
        $totalProjects = $user->projects()->count();

        // Total Items
        $totalItems = $user->projects()->with('projectDetails')->get()->flatMap(function ($project) {
            return $project->projectDetails;
        })->count();

        // Total Item Values
        $totalItemValues = $user->projects()->with('projectDetails')->get()->sum(function ($project) {
            return $project->projectDetails->sum('price');
        });

        // Total Pending Loan Requests
        $totalPendingLoanRequests = LoanRequest::where('owner_id', $user->id)
            ->where('status', 'pending')
            ->count();
        $projects = $user->projects()->with('projectDetails')->get();

        $projectData = [];

        foreach ($projects as $project) {
            $totalItems = $project->projectDetails->count();
            $totalValues = $project->projectDetails->sum('price');
            $availability = $project->projectDetails->where('status', 'Available')->count();

            $projectData[] = [
                'projectName' => $project->name,
                'totalItems' => $totalItems,
                'totalValues' => $totalValues,
                'availability' => $availability,
            ];
        }

        $pendingApprovals = LoanRequest::where('owner_id', $user->id)
            ->where('status', 'pending')
            ->paginate(4);
        // Paginate the projectData array
        $perPage = 5;
        $currentPage = request()->query('page', 1);
        $pagedData = array_slice($projectData, ($currentPage - 1) * $perPage, $perPage);




        //Projects

        return view('pages.dashboard', [
            'totalProjects' => $totalProjects,
            'totalItems' => $totalItems,
            'totalItemValues' => $totalItemValues,
            'totalPendingLoanRequests' => $totalPendingLoanRequests,
            'projectData' => $pagedData,
            'pendingApprovals' => $pendingApprovals,
        ]);
    }
}
