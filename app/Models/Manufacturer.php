<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Manufacturer extends EloquentModel
{
    protected $fillable = ['name'];

    public function models()
    {
        return $this->hasMany(Model::class);
    }
}
