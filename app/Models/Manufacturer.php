<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Manufacturer extends EloquentModel implements \OwenIt\Auditing\Contracts\Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['name'];

    public function models()
    {
        return $this->hasMany(Model::class);
    }
}
