<?php

namespace App\Models;

use App\Models\OperationSubfamily;
use Illuminate\Database\Eloquent\Model;

class OperationFamily extends Model
{
    public function subfamilies()
    {
        return $this->hasMany(OperationSubfamily::class, 'family_id');
    }
}
