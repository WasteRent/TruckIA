<?php

namespace App;

use App\Classes\AlertService;
use App\Models\Alert;
use App\Models\Customer;
use App\Models\Failure;
use App\Models\File;
use App\Models\Fleet;
use App\Models\Garage;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'role', 'avatar_file_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function garage()
    {
        return $this->hasOne(Garage::class);
    }

    public function fleet()
    {
        return $this->hasOne(Fleet::class);
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function avatar()
    {
        return $this->belongsTo(File::class, 'avatar_file_id');
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }

    public function failures()
    {
        return $this->hasMany(Failure::class, 'reporter_user_id');
    }

    public function notify(int $vehicle_id, string $title, string $message)
    {
        (new AlertService)->notify($this->id, $vehicle_id, $title, $message);
    }
}
