<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationSubfamily extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['name'];

    public function family()
    {
        return $this->belongsTo(OperationFamily::class);
    }
}
