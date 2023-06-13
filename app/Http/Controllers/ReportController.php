<?php

namespace App\Http\Controllers;

use App\Models\ProjectDetails;
use App\Models\Project;
use App\Models\LoanRequest;
use App\Models\UserActivityHistory;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    private $projectDetails;
    private $projects;

    public function __construct()
    {

        $this->projectDetails = ProjectDetails::all();
        $this->projects = Project::all();
    }

    public function index(Request $request)
    {

        return view('pages.report-dashboard');
    }

    public function itemOverview(Request $request)
    {
        $itemChanges = $this->itemChangesOverTime();
        $histogram = $this->getPriceDistribution();
        // Access the returned data
        $timestamps = $itemChanges['timestamps'];
        $createdCounts = $itemChanges['createdCounts'];
        $updatedCounts = $itemChanges['updatedCounts'];
        $priceRanges = $histogram['priceRanges'];
        $priceCounts = $histogram['priceCounts'];
        return view(
            'pages.report-item-overview',
            [
                'statusCounts' => $this->getStatusCount(),
                'itemCount' => $this->getItemCount(),
                'totalValue' => $this->getTotalValue(),
                'projectItemCounts' => $this->getItemByProject(),
                'timestamps' => $timestamps,
                'createdCounts' => $createdCounts,
                'updatedCounts' => $updatedCounts,
                'priceRanges' => $priceRanges,
                'priceCounts' => $priceCounts,
            ]
        );
    }


    public function userActivity(Request $request)
    {
        $userId = Auth()->user()->id;

        // Fetch the user activity history for the current user and sort by the latest activity
        $userActivity = UserActivityHistory::where('user_id', $userId)
            ->orderBy('action_timestamp', 'desc')
            ->paginate(5);
        return view(
            'pages.report-user-activtity',
            ['userActivity' => $userActivity]
        );
    }


    public function getStatusCount()
    {

        $statusLabels = ['Available', 'In-use', 'Loaned'];
        $statusCounts = [];
        foreach ($statusLabels as $statusLabel) {
            $statusCounts[$statusLabel] = 0;
        }
        foreach ($this->projectDetails as $item) {
            $status = $item->status;

            // If the status is valid and exists in the labels array, increment its count by 1
            if (isset($statusCounts[$status])) {
                $statusCounts[$status]++;
            }
        }
        return $statusCounts;
    }


    public function getItemCount()
    {
        $itemCount = [];
        $itemLabels = ['asset', 'inventory'];
        foreach ($itemLabels as $itemLabel) {
            $itemCount[$itemLabel] = 0;
        }

        foreach ($this->projectDetails as $item) {

            $type = $item->type;
            if (isset($itemCount[$type])) {
                $itemCount[$type] =  $itemCount[$type] + $item->quantity;
            }

            // $totalValue = $totalValue + $item->price;
        }
        return $itemCount;
    }

    public function getTotalValue()
    {
        $totalValue = 0;
        foreach ($this->projectDetails as $item) {

            $totalValue = $totalValue + $item->price;

            // $totalValue = $totalValue + $item->price;
        }
        return $totalValue;
    }

    public function getItemByProject()
    {
        $projectItems = [];

        // Loop through each project and retrieve the item counts for assets and inventory
        foreach ($this->projects as $project) {
            $projectId = $project->id;
            $assetCount = $this->getItemCountByType($projectId, 'asset');
            $inventoryCount = $this->getItemCountByType($projectId, 'inventory');

            // Store the project name as the key and the asset and inventory counts as the values
            $projectItems[$project->name] = [
                'asset' => $assetCount,
                'inventory' => $inventoryCount
            ];
        }

        return $projectItems;
    }


    public function getItemCountByType($projectId, $type)
    {
        // Fetch project details by project ID and item type
        $itemCount = ProjectDetails::where('project_id', $projectId)
            ->where('type', $type)
            ->sum('quantity');

        return $itemCount;
    }


    public function itemChangesOverTime()
    {
        // Fetch the project details within the desired date range
        $startDateTime = Carbon::parse('2023-01-01 00:00:00');
        $endDateTime = Carbon::now()->endOfDay();
        $projectDetails = ProjectDetails::whereBetween('created_at', [$startDateTime, $endDateTime])->get();

        // Group the projectDetails by date and calculate the counts
        $data = $projectDetails->groupBy(function ($item) {
            return $item->created_at->toDateString(); // Group by date
        })->map(function ($group) {
            $createdCount = $group->whereNotNull('created_at')->count();
            $updatedCount = $group->whereNotNull('created_at')->whereNotNull('updated_at')->count();

            return [
                'created' => $createdCount,
                'updated' => $updatedCount,
            ];
        })->toArray();

        // Prepare the chart data
        $timestamps = array_keys($data);
        $createdCounts = array_column($data, 'created');
        $updatedCounts = array_column($data, 'updated');

        // Pass the data to the view
        return [
            'timestamps' => $timestamps,
            'createdCounts' => $createdCounts,
            'updatedCounts' => $updatedCounts,
        ];
    }


    public function getPriceDistribution()
    {

        $priceDistribution = [];

        // Calculate the frequency of item prices
        foreach ($this->projectDetails as $item) {
            $price = $item->price;

            // Round the price to a desired precision or interval
            $roundedPrice = round($price, 100); // Adjust the precision as per your requirement

            // Increment the count for the rounded price
            if (isset($priceDistribution[$roundedPrice])) {
                $priceDistribution[$roundedPrice]++;
            } else {
                $priceDistribution[$roundedPrice] = 1;
            }
        }

        // Prepare the data for the Histogram chart
        $priceRanges = array_keys($priceDistribution);
        $priceCounts = array_values($priceDistribution);

        // Pass the data to the view
        return [
            'priceRanges' => $priceRanges,
            'priceCounts' => $priceCounts,
        ];
    }



    public function loanOverview(Request $request)
    {
        $itemOverTime = $this->loanedItemsOverTime();
        $timestamps =  $itemOverTime['timestamps'];
        $requesterCounts =  $itemOverTime['requesterCounts'];
        $ownerCounts =  $itemOverTime['ownerCounts'];


        return view(
            'pages.report-loan-Overview',
            [
                'totalLoan' => $this->getTotalLoanRequest(),
                'totalApprovedLoanRequest' => $this->getTotalApprovedLoanRequests(),
                'timestamps' => $timestamps,
                'requesterCounts' => $requesterCounts,
                'ownerCounts' => $ownerCounts,
                'sortedLoanActivities' => $this->loanActivityReport(),
                'totalRequest' => $this->getTotalLoanRequest(),
                'totalOverdue' => $this->getOverdueCount(),

            ]
        );
    }

    public function getTotalLoanRequest()
    {


        $currentOwnerId = Auth()->user()->id; // Assuming you're using Laravel's authentication and getting the current user ID

        $totalLoanRequests = LoanRequest::where('requester_id', $currentOwnerId)->count();

        return $totalLoanRequests;
    }

    public function getTotalApprovedLoanRequests()
    {
        $currentOwnerId = Auth()->user()->id; // Assuming you're using Laravel's authentication and getting the current user ID

        $totalApprovedLoanRequests = LoanRequest::where('owner_id', $currentOwnerId)
            ->where('status', 'approved')
            ->count();

        return $totalApprovedLoanRequests;
    }



    public function loanedItemsOverTime()
    {
        $currentUserId = Auth()->user()->id;

        $requesterLoanItems = LoanRequest::where('requester_id', $currentUserId)
            ->selectRaw("DATE_FORMAT(loan_start_date, '%Y-%m-%d') AS date, COUNT(*) AS count")
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $ownerLoanItems = LoanRequest::where('owner_id', $currentUserId)
            ->selectRaw("DATE_FORMAT(loan_start_date, '%Y-%m-%d') AS date, COUNT(*) AS count")
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Prepare the data for the chart
        $timestamps = $requesterLoanItems->pluck('date');
        $requesterCounts = $requesterLoanItems->pluck('count');
        $ownerCounts = $ownerLoanItems->pluck('count');

        // Pass the data to the view
        return  [
            'timestamps' => $timestamps,
            'requesterCounts' => $requesterCounts,
            'ownerCounts' => $ownerCounts,
        ];
    }


    public function loanActivityReport()
    {
        // Step 1: Retrieve the loan requests sorted by the latest activity
        $loanRequests = LoanRequest::orderBy('updated_at', 'desc')->get();

        // Step 2: Initialize an empty array to store the loan activities
        $loanActivities = [];

        // Step 3: Iterate over each loan request
        foreach ($loanRequests as $loanRequest) {
            // Step 4: Check if owner_id or requester_id is equal to the current user's ID
            if ($loanRequest->owner_id == Auth()->user()->id || $loanRequest->requester_id == Auth()->user()->id) {
                // Step 6: Initialize an empty string variable `action` to store the action
                // Step 7: Initialize a variable `date` to store the corresponding date

                $return = $loanRequest->return_date != null ? $loanRequest->return_date : null;
                $process = $loanRequest->process_date != null ? $loanRequest->process_date : null;
                $create = $loanRequest->created_at;

                $loanActivity = [];

                if (!empty($return)) {
                    $loanActivity[] = [
                        'content' => $this->getDescription('return', $loanRequest),
                        'date' => date('Y/m/d', strtotime($return))
                    ];
                }

                if (!empty($process)) {
                    $loanActivity[] = [
                        'content' => $this->getDescription('process', $loanRequest),
                        'date' => date('Y/m/d', strtotime($process))
                    ];
                }

                if (!empty($create)) {
                    $loanActivity[] = [
                        'content' => $this->getDescription('request', $loanRequest),
                        'date' => date('Y/m/d', strtotime($create))
                    ];
                }

                $loanActivities = array_merge($loanActivities, $loanActivity);
            }
        }

        // Step 15: Sort the array of loan activities in descending order based on the date
        // usort($loanActivities, function ($a, $b) {
        //     $dateA = substr($a, 0, strpos($a, ':'));
        //     $dateB = substr($b, 0, strpos($b, ':'));
        //     return strtotime($dateB) - strtotime($dateA);
        // });

        $activities = [
            'this_week' => [],
            'last_week' => [],
            'last_month' => [],
        ];

        $currentDate = Carbon::now();

        foreach ($loanActivities as $activity) {
            $activityDate = Carbon::createFromFormat('Y/m/d', substr($activity['date'], 0, 10));
            $diffInDays = $currentDate->diffInDays($activityDate);

            if ($diffInDays <= 7) {
                $activities['this_week'][] = $activity; // Add the entire activity to the this_week array
            } elseif ($diffInDays > 7 && $diffInDays <= 14) {
                $activities['last_week'][] = $activity; // Add the entire activity to the last_week array
            } elseif ($diffInDays > 14 && $diffInDays <= 30) {
                $activities['last_month'][] = $activity; // Add the entire activity to the last_month array
            }
        }


        // dd($activities);

        return ['sortedLoanActivities' => $activities];
    }

    public function getDescription($action, $loanRequest)
    {
        if ($action == 'return') {

            return $loanRequest->requester->username . ' returned ' . $loanRequest->projectDetails->item_name . ' to ' . $loanRequest->owner->username;
        } elseif ($action == 'process') {
            if ($loanRequest->status == 'approved') {
                return $loanRequest->owner->username . ' approved to loan ' . $loanRequest->projectDetails->item_name . ' to ' . $loanRequest->requester->username;
            } else {
                return $loanRequest->owner->username . ' rejected to loan ' . $loanRequest->projectDetails->item_name . ' to ' . $loanRequest->requester->username;
            }
        } elseif ($action == 'request') {
            return $loanRequest->requester->username . ' requested ' . $loanRequest->projectDetails->item_name . ' to loan from ' .  $loanRequest->owner->username;
        }

        // Default description if no matching condition
        return 'Loan activity: ' . $action;
    }



    public function getOverdueCount()
    {
        $currentUserId = Auth()->user()->id;
        $totalOverdue = LoanRequest::where('requester_id', $currentUserId)
            ->where('overdue', true)
            ->count();



        return $totalOverdue;
    }

    public function getTotalRequest()
    {
        $currentUserId = $currentUserId = Auth()->user()->id;
        $totalRequest = LoanRequest::where('requester_id', $currentUserId)
            ->count();

        return $totalRequest;
    }
}
