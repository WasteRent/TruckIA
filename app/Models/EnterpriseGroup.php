<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnterpriseGroup extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['name', 'email', 'contact', 'phone', 'address'];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
