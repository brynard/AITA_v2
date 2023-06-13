<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivityHistory extends Model
{
    protected $table = 'user_activity_history';

    protected $fillable = [
        'user_id',
        'entity_type',
        'action',
        'entity_id',
        'description',
        'changes',
        'action_timestamp',
    ];

    protected $casts = [
        'changes' => 'json',
        'action_timestamp' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'entity_id')->where('entity_type', 'project');
    }

    public function projectDetail()
    {
        return $this->belongsTo(ProjectDetails::class, 'entity_id')->where('entity_type', 'item');
    }

    public function loanRequest()
    {
        return $this->belongsTo(loanRequest::class, 'entity_id')->where('entity_type', 'loan');
    }


    public function getFormattedActionTimestampAttribute()
    {
        // Format the action_timestamp using Carbon's format method
        return $this->action_timestamp->format('Y-m-d h:ia');
    }
}
