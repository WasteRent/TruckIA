<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'state',
        'province',
        'zip'
    ];
    
    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->zip}, {$this->state}, {$this->province}";
    }

    public static function filters($query)
    {
        $filters = [];

        if (isset($query['name']) && $query['name'] != null) {
            $filters[] = ['name', 'LIKE', '%'.$query['name'].'%'];
        }
        
        return $filters;
    }
}
