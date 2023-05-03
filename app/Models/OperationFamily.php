<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationFamily extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['name'];

    public function subfamilies()
    {
        return $this->hasMany(OperationSubfamily::class, 'family_id');
    }
}
