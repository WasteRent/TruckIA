<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniversalOperation extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name', 'family_id', 'subfamily_id', 'time_in_hours', 'description', 'attachment_file_id',
    ];

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'operations_index';
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
            'family_id' => $this->family->id,
            'family' => $this->family->name,
            'subfamily_id' => $this->subfamily->id,
            'subfamily' => $this->subfamily->name,
        ];
    }

    public function family()
    {
        return $this->belongsTo(OperationFamily::class);
    }

    public function subfamily()
    {
        return $this->belongsTo(OperationSubfamily::class);
    }

    public function attachment()
    {
        return $this->belongsTo(File::class, 'attachment_file_id');
    }

    public static function filters($query)
    {
        $filters = [];

        if (isset($query['name']) && $query['name'] != null) {
            $filters[] = ['name', 'LIKE', '%'.$query['name'].'%'];
        }
        if (isset($query['family_id']) && $query['family_id'] != null) {
            $filters[] = ['family_id', '=', $query['family_id']];
        }

        return $filters;
    }
}
