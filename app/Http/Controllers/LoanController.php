<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectDetails;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\LoanRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\UserActivityHistory;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = auth()->id();
        $search = $request->get('search');

        $loanItems = ProjectDetails::where('status', 'Available')
            ->whereHas('project', function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->where('id', '!=', Auth()->user()->id);
                });
            })
            ->whereNotIn('id', function ($query) {
                $query->select('project_details_id')
                    ->from('loan_requests')
                    ->where('return_status', '!=', 'returned');
            })
            ->when($search, function ($query) use ($search) {
                // Apply search logic if search query is present
                $query->whereHas('project', function ($query) use ($search) {
                    $query->where('item_name', 'like', '%' . $search . '%');
                });
            })
            ->paginate(5);




        $loanRequests = LoanRequest::where('requester_id', $userId)
            ->where('return_status', '!=', 'returned')
            ->paginate(4);

        $pendingApprovals = LoanRequest::where('owner_id', $userId)
            ->where('status', 'pending')
            ->paginate(4);

        return view('pages.loan-item', [
            'loanItems' => $loanItems,
            'loanRequests' => $loanRequests,
            'pendingApprovals' => $pendingApprovals
        ])->with('loanItemsPagination', $loanItems->links());
    }



    public function requestLoan(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'desc' => 'required',
            'start_date' => 'required|date',
            'return_date' => 'required|date',

        ]);

        // Create a new loan request instance
        $loanRequest = new LoanRequest();
        $loanRequest->desc = $validatedData['desc'];
        $loanRequest->loan_start_date = $validatedData['start_date'];
        $loanRequest->loan_end_date = $validatedData['return_date'];



        $loanRequest->project_details_id = $request->input('project_details_id');
        $loanRequest->owner_id = $request->input('owner_id');
        $loanRequest->requester_id = $request->input('requester_id');

        // Set other properties as needed
        $desc = Auth()->user()->username . " has request loan item [" . $loanRequest->projectDetails->item_name . '] from ' . $loanRequest->owner->username;
        // Save the loan request to the database
        $loanRequest->save();
        $activity = new UserActivityHistory();
        $activity->user_id = Auth()->user()->id;
        $activity->entity_type = 'loan';
        $activity->action = 'request';
        $activity->entity_id = $loanRequest->id;
        $activity->description = $desc;
        $activity->changes = null;
        $activity->action_timestamp = now(); // or specific timestamp if needed
        $activity->save();
        // Redirect or perform any additional actions

        // For example, you can redirect back with a success message
        return redirect()->back()->with('success', 'Loan request submitted successfully.');
    }

    public function updateReturnStatus(Request $request)
    {
        // Retrieve the item ID from the AJAX request
        $itemId = $request->input('id');

        // Find the LoanRequest based on the item ID
        $loanRequest = LoanRequest::findOrFail($itemId);

        // Update the return status and return date of the LoanRequest
        $loanRequest->update([
            'return_status' => 'returned',
            'return_date' => now(),
        ]);

        // Check if the return date is greater than the loan end date
        $loanEndDate = $loanRequest->loan_end_date;
        $returnDate = $loanRequest->return_date;
        if ($loanEndDate && $returnDate && $returnDate > $loanEndDate) {
            $loanRequest->overdue = true;
        } else {
            $loanRequest->overdue = false;
        }

        // Save the changes
        $loanRequest->save();

        // Update the status of the associated project details
        $projectDetails = ProjectDetails::where('id', $loanRequest->project_details_id)->first();
        if ($projectDetails) {
            $projectDetails->update(['status' => 'Available']);
            $projectDetails->save();
        }

        $desc = Auth()->user()->username . " has return loaned item [" . $loanRequest->projectDetails->item_name . '] to ' . $loanRequest->owner->username;
        // Save the loan request to the database
        $loanRequest->save();
        $activity = new UserActivityHistory();
        $activity->user_id = Auth()->user()->id;
        $activity->entity_type = 'loan';
        $activity->action = 'return';
        $activity->entity_id = $loanRequest->id;
        $activity->description = $desc;
        $activity->changes = null;
        $activity->action_timestamp = now(); // or specific timestamp if needed
        $activity->save();
        // Return a response indicating the success of the update
        return redirect()->back()->with('success', 'Return status updated successfully.');
    }



    public function cancelLoanRequest(Request $request)
    {

        $itemId = $request->input('id');

        // Find the LoanRequest based on the item ID
        $loanRequest = LoanRequest::findOrFail($itemId);


        // Delete the loan request
        $loanRequest->delete();
        $desc = Auth()->user()->username . " has cancel to loan item [" . $loanRequest->projectDetails->item_name . '] from ' . $loanRequest->owner->username;
        // Save the loan request to the database

        $activity = new UserActivityHistory();
        $activity->user_id = Auth()->user()->id;
        $activity->entity_type = 'loan';
        $activity->action = 'delete';
        $activity->entity_id = $loanRequest->id;
        $activity->description = $desc;
        $activity->changes = null;
        $activity->action_timestamp = now(); // or specific timestamp if needed
        $activity->save();
        // Return a response indicating the success of the deletion
        return redirect()->back()->with('success', 'Loan request canceled successfully.');
    }


    public function processPendingRequest(Request $request)
    {
        $action = $request->input('action');
        $itemId = $request->input('itemId');

        // Find the LoanRequest based on the item ID
        $loanRequest = LoanRequest::findOrFail($itemId);

        // Update the status based on the action
        if ($action === 'approve') {
            $loanRequest->update(['status' => 'approved',  'process_date' => now()]);

            // Find the related ProjectDetails and update its status to 'Loaned'
            $projectDetails = ProjectDetails::where('id', $loanRequest->project_details_id)->first();
            if ($projectDetails) {
                $projectDetails->update(['status' => 'Loaned']);
                $projectDetails->save();
            }
        } elseif ($action === 'decline') {
            $loanRequest->update(['status' => 'rejected',  'process_date' => now()]);
        } else {
            return response()->json(['message' => 'Invalid action'], 400);
        }

        // Save the changes
        $loanRequest->save();

        $desc = Auth()->user()->username . " has" . $loanRequest->action . " loan item [" . $loanRequest->projectDetails->item_name . '] to ' . $loanRequest->owner->username;
        // Save the loan request to the database
        $loanRequest->save();
        $activity = new UserActivityHistory();
        $activity->user_id = Auth()->user()->id;
        $activity->entity_type = 'loan';
        $activity->action = $loanRequest->action ?? 'approved';
        $activity->entity_id = $loanRequest->id;
        $activity->description = $desc;
        $activity->changes = null;
        $activity->action_timestamp = now(); // or specific timestamp if needed
        $activity->save();
        // Return a response indicating the success of the update
        return redirect()->back()->with('success', 'Loan request ' . $action . 'd successfully');
    }
}
