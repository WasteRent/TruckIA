<?php

namespace App\Models;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleDeliveryNote extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function front_picture()
    {
        return $this->belongsTo(File::class, 'front_picture_id');
    }

    public function left_picture()
    {
        return $this->belongsTo(File::class, 'left_picture_id');
    }

    public function back_picture()
    {
        return $this->belongsTo(File::class, 'back_picture_id');
    }

    public function right_picture()
    {
        return $this->belongsTo(File::class, 'right_picture_id');
    }
}
