<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\ProjectDetails;
use App\Models\UserActivityHistory;

class ProjectController extends Controller
{
    // public function index()
    // {
    //     $projects = Project::all();
    //     // dd('hello');
    //     return view('pages.projects', compact('projects'));
    // }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $userId = auth()->user()->id; // Get the ID of the currently authenticated user

        $query = Project::where('user_id', $userId); // Filter projects by user ID

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('budget', 'LIKE', '%' . $search . '%')
                    ->orWhere('status', 'LIKE', '%' . $search . '%');
            });
        }

        $projects = $query->orderBy('created_at', 'desc')->paginate(10);


        return view('pages.projects', ['projects' => $projects, 'readOnly' => 2]);
    }




    public function show(Project $project, $readOnly = 2, Request $request)
    {
        $projectWithDetails = Project::with('projectDetails')->findOrFail($project->id);
        // get the search query from the request
        $search = $request->input('search');

        $readOnly = $readOnly;
        if ($request->has('filter')) {
            // Filter the items based on the filter parameter
            if ($request->get('filter') == 'assets') {
                $projectWithDetails->projectDetails = $projectWithDetails->projectDetails->where('type', 'asset');
            } elseif ($request->get('filter') == 'inventory') {
                $projectWithDetails->projectDetails = $projectWithDetails->projectDetails->where('type', 'inventory');
            }
        }
        // filter the project details based on the search query
        if ($search) {
            $projectWithDetails->projectDetails = $projectWithDetails->projectDetails->filter(function ($detail) use ($search) {
                return stristr($detail->item_name, $search) !== false;
            });
        }

        return view('pages.project-detail', compact('projectWithDetails', 'readOnly'));
    }



    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'budget' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle the form submission
        $project = new Project;
        $project->name = $request->input('name');
        $project->budget = $request->input('budget');
        $project->user_id = auth()->user()->id;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_data = file_get_contents($image);
            $image_base64 = base64_encode($image_data);
            $project->logo = $image_base64;
        }



        $project->save();

        $desc = Auth()->user()->username . " has created project " . $project->name;


        //Save into history
        $activity = new UserActivityHistory();
        $activity->user_id = Auth()->user()->id;
        $activity->entity_type = 'project';
        $activity->action = 'create';
        $activity->entity_id = $project->id;
        $activity->description = $desc;
        $activity->changes = null;
        $activity->action_timestamp = now(); // or specific timestamp if needed
        $activity->save();

        // Redirect to the projects index page
        return redirect()->route('projects');
    }


    public function destroy(Project $project)
    {
        $project->delete();

        $desc = Auth()->user()->id . " has deleted project " . $project->name;

        //Save into history
        $activity = new UserActivityHistory();
        $activity->user_id = Auth()->user()->id;
        $activity->entity_type = 'project';
        $activity->action = 'delete';
        $activity->entity_id = $project->id;
        $activity->description = $desc;
        $activity->changes = null;
        $activity->action_timestamp = now(); // or specific timestamp if needed
        $activity->save();
        return redirect()->route('projects')->with('status', 'Project deleted successfully!');
    }


    public function storeItem(Project $project, Request $request)
    {
        $validatedData = $request->validate([
            'item_name' => 'required|string|max:255',
            'type' => 'required|string',
            'subtype' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'engine_type' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'voltage' => 'nullable|numeric|max:255',
            'supplier' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'unit_price' => 'required|numeric',
            'quantity' => 'required|integer',
            'date_received' => 'required|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $detail = new ProjectDetails;
        $detail->project_id = $project->id;
        $detail->item_name = $validatedData['item_name'];
        $detail->type = $validatedData['type'];
        $detail->subtype = $validatedData['subtype'];
        $detail->model = $validatedData['model'];
        $detail->engine_type = $validatedData['engine_type'];
        $detail->serial_number = $validatedData['serial_number'];
        $detail->voltage = $validatedData['voltage'];
        $detail->supplier = $validatedData['supplier'];
        $detail->location = $validatedData['location'];
        $detail->unit_price = $validatedData['unit_price'];
        $detail->quantity = $validatedData['quantity'];
        $detail->price = $validatedData['quantity'] * $validatedData['unit_price'];
        $detail->date_received = $validatedData['date_received'];

        // upload and store image file if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_data = file_get_contents($image);
            $detail->image = base64_encode($image_data);
        }


        $detail->save();


        $desc = Auth()->user()->username . " has created item " . $detail->item_name . " from project " . $detail->project->name;

        //Save into history
        $activity = new UserActivityHistory();
        $activity->user_id = Auth()->user()->id;
        $activity->entity_type = 'item';
        $activity->action = 'create';
        $activity->entity_id = $detail->id;
        $activity->description = $desc;
        $activity->changes = null;
        $activity->action_timestamp = now(); // or specific timestamp if needed
        $activity->save();
        return redirect()->route('projects.show', ['project' => $project->id, 'readOnly' => 2])
            ->with('success', 'New item has been added to the project.');
    }


    public function updateItem(Project $project, ProjectDetails $detail, $readOnly, Request $request)
    {

        $before = $detail;
        $validatedData = $request->validate([
            'item_name' => 'required|string|max:255',
            'type' => 'required|string',
            'subtype' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'engine_type' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'voltage' => 'nullable|numeric|max:255',
            'supplier' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'unit_price' => 'required|numeric',
            'quantity' => 'required|integer',
            'date_received' => 'required|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $detail->item_name = $validatedData['item_name'];
        $detail->type = $validatedData['type'];
        $detail->subtype = $validatedData['subtype'];
        $detail->model = $validatedData['model'];
        $detail->engine_type = $validatedData['engine_type'];
        $detail->serial_number = $validatedData['serial_number'];
        $detail->voltage = $validatedData['voltage'];
        $detail->supplier = $validatedData['supplier'];
        $detail->location = $validatedData['location'];
        $detail->unit_price = $validatedData['unit_price'];
        $detail->quantity = $validatedData['quantity'];
        $detail->price = $validatedData['quantity'] * $validatedData['unit_price'];
        $detail->date_received = $validatedData['date_received'];

        // upload and update image file if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_data = file_get_contents($image);
            $detail->image = base64_encode($image_data);
        }

        $detail->save();
        $changes = [];
        if ($before && $detail) {
            $originalData = $before->toArray();
            $updatedData = $detail->toArray();

            foreach ($updatedData as $key => $value) {
                if ($originalData[$key] != $value) {
                    $changes[$key] = [
                        'before' => $originalData[$key],
                        'after' => $value,
                    ];
                }
            }
        }

        $desc = Auth()->user()->username . " has edited item " . $detail->item_name . " from project " . $detail->project->name;

        $activity = new UserActivityHistory();
        $activity->user_id = Auth()->user()->id;
        $activity->entity_type = 'item';
        $activity->action = 'edit';
        $activity->entity_id = $detail->id;
        $activity->description = $desc;
        $activity->changes = $changes;
        $activity->action_timestamp = now(); // or specific timestamp if needed
        $activity->save();
        return redirect()->route('projects.show', ['project' => $project->id, 'readOnly' => $readOnly])
            ->with('success', 'Item has been updated successfully.');
    }


    public function destroyItem(Project $project, ProjectDetails $detail, $readOnly, Request $request)
    {
        $desc = Auth()->user()->username . " has deleted item ";
        //Save into history
        $activity = new UserActivityHistory();
        $activity->user_id = Auth()->user()->id;
        $activity->entity_type = 'item';
        $activity->action = 'delete';
        $activity->entity_id = $detail->id;
        $activity->description = $desc;
        $activity->action_timestamp = now(); // or specific timestamp if needed
        $activity->save();



        $detail->delete();




        return redirect()->route('projects.show', ['project' => $project->id, 'readOnly' => $readOnly])
            ->with('success', 'Item has been deleted successfully.');
    }



    public function createItem(Project $project)
    {
        return view('pages.item-form', compact('project'));
    }

    // public function edit(Project $project, ProjectDetails $details)
    // {
    //     // $projectDe = Project::findOrFail($project);
    //     $item = ProjectDetails::findOrFail($details);
    //     $projectWithDetails = Project::with('projectDetails')->findOrFail($details);
    //     dd($item);
    //     return view('pages.item-form', compact('project', 'details'));
    // }


    public function edit(Project $project, $detail, $readOnly)
    {
        // Find the project detail by id, with its corresponding project
        // $detail = ProjectDetails::with('project')->findOrFail($id);
        // $project = Project::find(1); // Retrieve the project with id 1
        $detail = $project->projectDetails()->where('id', $detail)->first();

        return view('pages.item-form', compact('detail', 'project', 'readOnly'));
    }


    public function test()
    {
        return view('pages.item-selection');
    }
}
