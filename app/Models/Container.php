<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Container extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function state()
    {
        return $this->belongsTo(VehicleState::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(\App\User::class, 'created_by');
    }

    public function pictures()
    {
        return $this->belongsToMany(File::class, 'container_pictures')->withPivot('cover');
    }

    public function incidents()
    {
        return $this->hasMany(ContainerIncident::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function containerChecklists()
    {
        return $this->hasMany(ContainerChecklist::class);
    }

    public function scopeAllowForUser($query)
    {
        $fleet_id = auth()->user()->fleet->id;
        $query->where('fleet_id', $fleet_id);

        if (Auth::user()->allowedCustomers->count()) {
            $query->whereIn('customer_id', Auth::user()->allowedCustomers->pluck('id'));
        }

        return $query;
    }

    public static function filter(array $filters)
    {
        $query = Container::query();

        if (isset($filters['state_id']) && $filters['state_id'] != null) {
            $query->where('state_id', $filters['state_id']);
        }
        if (isset($filters['assigned_customer_id']) && $filters['assigned_customer_id'] != null) {
            $query->where('customer_id', $filters['assigned_customer_id']);
        }
        if (isset($filters['reference']) && $filters['reference'] != null) {
            $query->where('reference', $filters['reference']);
        }
        if (isset($filters['maker']) && $filters['maker'] != null) {
            $query->where('maker', 'LIKE', "%{$filters['maker']}%");
        }
        if (isset($filters['model']) && $filters['model'] != null) {
            $query->where('model', 'LIKE', "%{$filters['model']}%");
        }
        if (isset($filters['location']) && $filters['location'] != null) {
            $query->where('location', 'LIKE', "%{$filters['location']}%");
        }
        if (isset($filters['owner']) && $filters['owner'] != null) {
            $query->where('owner', $filters['owner']);
        }

        return $query;
    }
}
