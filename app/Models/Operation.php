<?php

namespace App\Models;

use App\Models\OperationFamily;
use App\Models\OperationSubfamily;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{


    public function subfamily()
    {
        return $this->belongsTo(OperationSubfamily::class);
    }
}
