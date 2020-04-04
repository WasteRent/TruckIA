<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    public $table = 'equipments';

    protected $fillable = [
        'type',
        'maker_id',
        'model_id',
        'version',
        'warranty_date',
        'plate',
        'bomb_serial_number',
        'bomb_maker',
        'bomb_model'
    ];
}
