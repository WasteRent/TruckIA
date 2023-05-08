<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccidentReport extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['vehicle_id', 'file_id', 'summary'];

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
