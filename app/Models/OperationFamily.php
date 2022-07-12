<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationFamily extends Model
{
    protected $fillable = ['name'];

    public function subfamilies()
    {
        return $this->hasMany(OperationSubfamily::class, 'family_id');
    }
}
