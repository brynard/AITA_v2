<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectDetails;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\LoanRequest;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->id();


        $loanItems = ProjectDetails::where('status', 'available')
            ->where('id', '!=', auth()->id())
            ->paginate(5);

        $loanRequests = LoanRequest::where('requester_id', $userId)
            ->where('return_status', '!=', 'returned')
            ->paginate(4);


        return view('pages.loan-item', [
            'loanItems' => $loanItems,
            'loanRequests' => $loanRequests
        ]);
    }




    public function create()
    {
        //
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

        // Save the loan request to the database
        $loanRequest->save();

        // Redirect or perform any additional actions

        // For example, you can redirect back with a success message
        return redirect()->back()->with('success', 'Loan request submitted successfully.');
    }

    public function updateReturnStatus(Request $request)
    {
        // Retrieve the item ID from the AJAX request
        $itemId = $request->input('itemId');

        // Find the LoanRequest based on the item ID
        $loanRequest = LoanRequest::findOrFail($itemId);

        // Update the return status of the LoanRequest
        $loanRequest->update(['return_status' => 'returned']);

        $loanRequest->save();

     
        // Return a response indicating the success of the update
        return response()->json(['message' => 'Return status updated successfully']);
    }
}
