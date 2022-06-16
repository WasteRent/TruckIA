<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\File;
use App\Models\Vehicle;
use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleDeliveryNote extends Model
{
    use HasFactory, SoftDeletes;


    protected $guarded = [];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_user_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

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
