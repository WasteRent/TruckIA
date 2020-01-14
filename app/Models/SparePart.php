<?php

namespace App\Models;

use App\Classes\Helpers;
use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
    protected $fillable = [
        'reference',
        'short_reference',
        'price',
        'description'
    ];


    public function setReferenceAttribute($value)
    {
        $this->attributes['reference'] = strtoupper($value);
    }


    public function getFormattedPrice()
    {
        return number_format($this->price, 2, ',', '.') . ' €';
    }

    public static function filters($query)
    {
        $filters = [];

        if (isset($query['reference']) && $query['reference'] != null) {
            $filters[] = ['short_reference', '=', Helpers::shortReference($query['reference'])];
        }
        if (isset($query['description']) && $query['description'] != null) {
            $filters[] = ['description', 'LIKE', '%'.$query['description'].'%'];
        }
        
        return $filters;
    }
}
