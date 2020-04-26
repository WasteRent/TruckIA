<?php

namespace App\Models;

use App\Models\File;
use App\Models\Manufacturer;
use App\Models\Model;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Equipment extends EloquentModel
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
        'bomb_model',
        'picture_file_id'
    ];

    public function maker()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function model()
    {
        return $this->belongsTo(Model::class);
    }

    public function picture()
    {
        return $this->belongsTo(File::class, 'picture_file_id');
    }
}
