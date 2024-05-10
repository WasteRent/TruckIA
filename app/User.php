<?php

namespace App;

use App\Models\Alert;
use App\Models\Customer;
use App\Models\Failure;
use App\Models\File;
use App\Models\Fleet;
use App\Models\Garage;
use App\Models\RepairOrder;
use App\Models\VehicleIncident;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements \OwenIt\Auditing\Contracts\Auditable
{
    use Notifiable;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password', 'role', 'avatar_file_id', 'entity_relation_id', 'is_active', 'is_readonly', 'job', 'can_email_alerts', 'trial_ends_at', 'allowed_schedule',
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

    public function getLogo()
    {
        if ($this->role == 'garage') {
            return $this->garage->fleet->logo;
        } elseif ($this->role == 'customer') {
            return $this->customer->fleet->logo;
        } elseif ($this->role == 'fleet') {
            return $this->fleet->logo;
        }
    }

    public function garage()
    {
        if (! $this->hasRole('garage')) {
            throw new \Exception('Invalid role');
        }

        return $this->belongsTo(Garage::class, 'entity_relation_id');
    }

    public function fleet()
    {
        if (! $this->hasRole('fleet')) {
            throw new \Exception('Invalid role');
        }

        return $this->belongsTo(Fleet::class, 'entity_relation_id');
    }

    public function customer()
    {
        if (! $this->hasRole('customer')) {
            throw new \Exception('Invalid role');
        }

        return $this->belongsTo(Customer::class, 'entity_relation_id');
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

    public function incidents()
    {
        return $this->hasMany(VehicleIncident::class, 'user_id');
    }

    public function allowedFleets()
    {
        return $this->belongsToMany(Fleet::class, 'user_fleets');
    }

    public function allowedCustomers()
    {
        return $this->belongsToMany(Customer::class, 'user_allowed_customers');
    }

    public function allowOriginalPlans()
    {
        return $this->allow_original_plans;
    }

    public function pendingTasksCount()
    {
        $orders = RepairOrder::where('assigned_user_id', auth()->id())->inProgress()->count();
        $incidents = VehicleIncident::where('user_id', auth()->id())->whereNull('closed_at')->count();

        return $orders + $incidents;
    }

    public static function filter(array $filters)
    {
        $query = User::query();

        if (isset($filters['email']) && $filters['email'] != null) {
            $query->where('email', 'like', "%{$filters['email']}%");
        }
        if (isset($filters['username']) && $filters['username'] != null) {
            $query->where('username', 'like', "%{$filters['username']}%");
        }
        if (isset($filters['name']) && $filters['name'] != null) {
            $query->where('name', 'like', "%{$filters['name']}%");
        }

        return $query;
    }
}
