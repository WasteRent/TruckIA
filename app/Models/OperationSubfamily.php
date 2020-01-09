<?php

namespace App\Models;

use App\Models\OperationFamily;
use Illuminate\Database\Eloquent\Model;

class OperationSubfamily extends Model
{
    protected $fillable = ['name'];

    public function family()
    {
        return $this->belongsTo(OperationFamily::class);
    }
}
