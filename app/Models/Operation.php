<?php

namespace App\Models;

use App\Models\OperationFamily;
use App\Models\OperationSubfamily;
use App\Models\SparePart;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Operation extends Model
{
    use Searchable;

    protected $fillable = [
        "code",
        "vehicle_type",
        "family_id",
        "subfamily_id",
        "name",
        "time_in_hours",
        "description"
    ];

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'repair_operations_index';
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'family' => $this->family->name,
            'subfamily' => $this->subfamily->name,
        ];
    }

    public function spareParts()
    {
        return $this->belongsToMany(SparePart::class, 'operation_spare_parts');
    }

    public function sparePartsGrouped()
    {
        return $this->spareParts->groupBy('id')->map(function ($group) {
            $sparePart = $group->first();
            $sparePart->price *= $group->count();
            $sparePart->units = $group->count();
            return $sparePart;
        });
    }

    public function family()
    {
        return $this->belongsTo(OperationFamily::class);
    }

    public function subfamily()
    {
        return $this->belongsTo(OperationSubfamily::class);
    }

    public static function filters($query)
    {
        $filters = [];

        if (isset($query['code']) && $query['code'] != null) {
            $filters[] = ['code', '=', $query['code']];
        }
        if (isset($query['name']) && $query['name'] != null) {
            $filters[] = ['name', 'LIKE', '%'.$query['name'].'%'];
        }
        
        return $filters;
    }
}
