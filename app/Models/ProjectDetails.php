<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectDetails extends Model
{
    use HasFactory;


    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    public $timestamps = true;
    protected $fillable = [
        'id',
        'project_id',
        'item_name',
        'quantity',
        'unit_price',
        'subtype',
        'serial_number',
        'model',
        'engine_type',
        'voltage',
        'supplier',
        'location',
        'type',
        'price',
        'date_received',
        'status',
        'image'
    ];
}
