<?php

namespace App\Models;

use OwenIt\Auditing\Models\Audit as BaseAudit;

class Audit extends BaseAudit
{
    /**
     * Aplicar filtros a la consulta de auditorías
     *
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function filter(array $filters)
    {
        $query = static::query();

        if (isset($filters['event']) && $filters['event'] != null) {
            $query->where('event', $filters['event']);
        }

        if (isset($filters['date_from']) && $filters['date_from'] != null) {
            $query->where('created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to']) && $filters['date_to'] != null) {
            $query->where('created_at', '<=', $filters['date_to']);
        }

        return $query;
    }
}

