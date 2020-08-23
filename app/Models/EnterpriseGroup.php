<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;

class EnterpriseGroup extends Model
{
    protected $fillable = ['name', 'email', 'contact', 'phone', 'address'];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
