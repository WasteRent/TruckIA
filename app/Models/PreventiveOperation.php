<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreventiveOperation extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'operation_family',
        'operation_subfamily',
        'operation_code',
        'operation_name',
        'operation_description',
        'completed_at',
    ];

    public function isCompleted()
    {
        return ! empty($this->completed_at);
    }
}
