<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleChecklistFile extends Model
{
    use HasFactory;
    protected $fillable = ['vehicle_id','vehicle_checklist_file_type_id'];

    public const ISCHECKED = '1';

    
}
