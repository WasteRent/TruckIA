<?php

namespace App\Models;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;

class AccidentReport extends Model
{
    protected $fillable = ['vehicle_id', 'file_id', 'summary'];

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
