<?php

namespace App\Models;

use App\Models\File;
use App\Models\OperationFamily;
use App\Models\OperationSubfamily;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class UniversalOperation extends Model
{
    use Searchable;

    protected $fillable = [
        'name', 'family_id', 'subfamily_id', 'time_in_hours', 'description', 'attachment_file_id'
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
        
        return $filters;
    }
}
