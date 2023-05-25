<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanRequest extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $fillable = [
        'id',
        'requester_id',
        'owner_id',
        'project_details_id',
        'request_date',
        'status',
        'desc',
        'return_status',
        'loan_start_date',
        'loan_end_date',
        'created_at',
        'updated_at'

        // additional attributes specific to the loan request
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function projectDetails()
    {
        return $this->belongsTo(ProjectDetails::class, 'project_details_id');
    }
}
