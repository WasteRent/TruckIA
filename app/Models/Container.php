<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function state()
    {
        return $this->belongsTo(VehicleState::class);
    }

    public function pictures()
    {
        return $this->belongsToMany(File::class, 'container_pictures')->withPivot('cover');
    }


    public function incidents()
    {
        return $this->hasMany(ContainerIncident::class);
    }

    public static function filter(array $filters)
    {
        $query = Container::query();

        if (isset($filters['state_id']) && $filters['state_id'] != null) {
            $query->where('state_id', $filters['state_id']);
        }
        if (isset($filters['customer_id']) && $filters['customer_id'] != null) {
            $query->where('customer_id', $filters['customer_id']);
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
            $query->where('location', $filters['location']);
        }
        if (isset($filters['owner']) && $filters['owner'] != null) {
            $query->where('owner', $filters['owner']);
        }

        return $query;
    }
}
