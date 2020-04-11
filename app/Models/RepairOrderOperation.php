<?php

namespace App\Models;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;

class RepairOrderOperation extends Model
{
    protected $fillable = [
        'operation_family',
        'operation_subfamily',
        'operation_code',
        'operation_name',
        'operation_description',
        'estimated_time_in_hours',
        'real_time_in_hours',
        'garage_observations',
        'file_id',
        'completed_at'
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }


    public function isCompleted()
    {
        return !empty($this->completed_at);
    }
}
