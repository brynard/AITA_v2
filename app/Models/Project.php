<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function projectDetails()
    {
        return $this->hasMany(ProjectDetails::class);
    }

    protected $fillable = [
        'name',
        'budget',
        'status',
        'completion',
        'logo',
    ];
}
