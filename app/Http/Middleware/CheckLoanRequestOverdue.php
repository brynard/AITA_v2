<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use App\Models\LoanRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLoanRequestOverdue
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $currentDate = Carbon::today();

        LoanRequest::where('return_status', '!=', 'returned')
            ->where('loan_end_date', '<', $currentDate)
            ->update(['overdue' => true]);

        return $next($request);
    }
}
